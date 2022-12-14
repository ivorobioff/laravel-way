<?php
namespace RealEstate\Core\Amc\Services;
use Restate\Libraries\Validation\PresentableException;
use RealEstate\Core\Amc\Criteria\InvoiceFilterResolver;
use RealEstate\Core\Amc\Criteria\InvoiceSorterResolver;
use RealEstate\Core\Amc\Emails\InvoiceEmail;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Amc\Entities\Invoice;
use RealEstate\Core\Amc\Entities\Item;
use RealEstate\Core\Amc\Interfaces\InvoiceTransformerInterface;
use RealEstate\Core\Amc\Options\FetchInvoicesOptions;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Document\Services\DocumentService;
use RealEstate\Core\Payment\Enums\Means;
use RealEstate\Core\Payment\Objects\Purchase;
use RealEstate\Core\Payment\Services\PaymentService;
use RealEstate\Core\Support\Criteria\Criteria;
use RealEstate\Core\Support\Criteria\Filter;
use RealEstate\Core\Support\Criteria\Paginator;
use RealEstate\Core\Support\Letter\EmailerInterface;
use RealEstate\Core\Support\Letter\LetterPreferenceInterface;
use RealEstate\Core\Support\Service\AbstractService;
use DateTime;
use RealEstate\Letter\Support\Emailer;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InvoiceService extends AbstractService
{
    /**
     * @param int $amcId
     * @param DateTime $from
     * @param DateTime $to
     * @return Invoice
     */
    public function generate($amcId, DateTime $from, DateTime $to)
    {
        $builder = $this->entityManager->createQueryBuilder();

        /**
         * @var Order[] $orders
         */
        $orders = $builder
            ->select('o')
            ->from(Order::class, 'o')
            ->where($builder->expr()->between('o.completedAt', ':from', ':to'))
            ->andWhere($builder->expr()->isNotNull('o.completedAt'))
            ->andWhere($builder->expr()->eq('o.isTechFeePaid', ':isPaid'))
            ->andWhere($builder->expr()->isNotNull('o.techFee'))
            ->andWhere($builder->expr()->eq('o.assignee', ':amc'))
            ->setParameters([
                'from' => $from,
                'to' => $to,
                'amc' => $amcId,
                'isPaid' => false
            ])
            ->getQuery()
            ->getResult();

        if (count($orders) === 0){
            return null;
        }

        /**
         * @var Amc $amc
         */
        $amc = $this->entityManager->getReference(Amc::class, $amcId);

        $invoice = new Invoice();

        $invoice->setAmc($amc);
        $invoice->setFrom($from);
        $invoice->setTo($to);
        $invoice->setAmount(0);

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        $items = [];
        $total = 0;

        foreach ($orders as $order){

            $total += $order->getTechFee();

            $item = new Item();

            $item->setAmount($order->getTechFee());
            $item->setAddress($order->getProperty()->getDisplayAddress());
            $item->setBorrowerName(object_take($order, 'borrower.displayName', ''));
            $item->setOrderedAt($order->getOrderedAt());
            $item->setCompletedAt($order->getCompletedAt());
            $item->setJobType($order->getJobType()->getTitle());
            $item->setFileNumber($order->getFileNumber());
            $item->setLoanNumber($order->getLoanNumber());

            $item->setOrder($order);
            $item->setInvoice($invoice);

            $this->entityManager->persist($item);

            $items[] = $item;
        }

        $this->entityManager->flush();

        $invoice->setAmount($total);

        $invoice->setItems($items);

        /**
         * @var InvoiceTransformerInterface $transformer
         */
        $transformer = $this->container->get(InvoiceTransformerInterface::class);

        $document = $transformer->toPdf($invoice);

        /**
         * @var DocumentService $documentService
         */
        $documentService = $this->container->get(DocumentService::class);

        $document = $documentService->create($document);

        $invoice->setDocument($document);

        $this->entityManager->flush();

        return $invoice;
    }

    /**
     * @param int $amcId
     * @param FetchInvoicesOptions $options
     * @return Invoice[]
     */
    public function getAll($amcId, FetchInvoicesOptions $options = null)
    {
        if ($options === null){
            $options = new FetchInvoicesOptions();
        }

        $builder = $this->entityManager->createQueryBuilder();

        $builder
            ->from(Invoice::class, 'i')
            ->select('i')
            ->where($builder->expr()->eq('i.amc', ':amc'))
            ->setParameter('amc', $amcId);

        (new Filter())->apply($builder, $options->getCriteria(), new InvoiceFilterResolver())
            ->withSorter($builder, $options->getSortables(), new InvoiceSorterResolver());

        return (new Paginator())->apply($builder, $options->getPagination());
    }

    /**
     * @param int $amcId
     * @param Criteria[] $criteria
     * @return int
     */
    public function getTotal($amcId, array $criteria = [])
    {
        $builder = $this->entityManager->createQueryBuilder();

        $builder
            ->from(Invoice::class, 'i')
            ->select($builder->expr()->count('i'))
            ->where($builder->expr()->eq('i.amc', ':amc'))
            ->setParameter('amc', $amcId);

        (new Filter())->apply($builder, $criteria, new InvoiceFilterResolver());

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    public function generateMonthlyInvoices()
    {
        /**
         * @var Amc[] $amcs
         */
        $amcs = $this->entityManager->createQueryBuilder()
            ->from(Amc::class, 'a')
            ->select('a')
            ->getQuery()
            ->getResult();


        $to = new DateTime((new DateTime())->format('Y-m-1 00:00:00'));
        $to->modify('-1 second');

        $from = new DateTime($to->format('Y-m-1 00:00:00'));

        /**
         * @var Emailer $emailer
         */
        $emailer = $this->container->get(EmailerInterface::class);

        /**
         * @var LetterPreferenceInterface $preference
         */
        $preference = $this->container->get(LetterPreferenceInterface::class);

        foreach ($amcs as $amc){

            if ($invoice = $this->generate($amc->getId(), $from, $to)){
                $email = new InvoiceEmail($invoice);
                $email->setSender($preference->getNoReply(), $preference->getSignature());
                $email->addRecipient($amc->getEmail());
                $emailer->send($email);
            }
        }
    }

    /**
     * @param int $invoiceId
     * @param Means $means
     */
    public function pay($invoiceId, Means $means)
    {
        /**
         * @var Invoice $invoice
         */
        $invoice = $this->entityManager->find(Invoice::class, $invoiceId);

        if ($invoice->isPaid()){
            throw new PresentableException('The provided invoice is already paid.');
        }

        /**
         * @var PaymentService $paymentService
         */
        $paymentService = $this->container->get(PaymentService::class);

        $purchase = new Purchase();
        $purchase->setPrice($invoice->getAmount());
        $purchase->setProduct($invoice);

        $paymentService->charge($invoice->getAmc()->getId(), $purchase, $means);

        $invoice->setPaid(true);

        foreach ($invoice->getItems() as $item){
            if ($order = $item->getOrder()){
                $order->setTechFeePaid(true);
            }
        }

        $this->entityManager->flush();
    }
}