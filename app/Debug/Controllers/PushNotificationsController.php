<?php
namespace RealEstate\Debug\Controllers;
use Illuminate\Container\Container;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Entities\Property;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification;
use RealEstate\Core\Appraisal\Notifications\SendMessageNotification;
use RealEstate\Core\Customer\Entities\AdditionalStatus;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\Message;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;
use RealEstate\Core\Log\Extras\AdditionalStatusExtra;
use RealEstate\Core\Log\Extras\Extra;
use RealEstate\Core\Log\Extras\StateExtra;
use RealEstate\Core\Log\Notifications\CreateLogNotification;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Debug\Support\BaseController;
use RealEstate\Mobile\Support\Notifier;
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PushNotificationsController extends BaseController
{
    /**
     * @var Notifier
     */
    private $notifier;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->notifier = new Notifier($container);
        $this->session = $container->make(Session::class);

        if ($this->session->getId() === null){
            throw new BadRequestHttpException('You have to be logged-in!');
        }
    }

    public function createOrder($id)
    {
        $this->notifyLog($id, new Action(Action::CREATE_ORDER));
    }

    public function updateOrder($id)
    {
        $this->notifyLog($id, new Action(Action::UPDATE_ORDER));

    }

    public function deleteOrder($id)
    {
        $customer = new Customer();
        $customer->setId(100);
        $customer->setName('Dummy');
        $customer->setUsername('dummy');

        $order = new Order();
        $order->setId($id);
        $order->setCustomer($customer);
        $order->setAssignee($this->session->getUser());

        $property = new Property();
        $property->setAddress1('123 Market Str.');
        $property->setCity('San Francisco');

        $state = new State();
        $state->setCode('CA');
        $state->setName('California');

        $property->setState($state);
        $property->setZip('94132');

        $order->setProperty($property);

        $this->container->singleton(Session::class, function() use ($customer){
            $session = new Session();
            $session->setUser($customer);

            return $session;
        });

        $this->notifier->notify(new DeleteOrderNotification($order));
    }

    public function updateProcessStatus($id)
    {
        $this->notifyLog($id, new Action(Action::UPDATE_PROCESS_STATUS), [
            Extra::OLD_PROCESS_STATUS => new ProcessStatus(ProcessStatus::ACCEPTED),
            Extra::NEW_PROCESS_STATUS => new ProcessStatus(ProcessStatus::LATE)
        ]);

    }

    public function changeAdditionalStatus($id)
    {
        $s1 = new AdditionalStatus();
        $s1->setTitle('Just started');
        $s1->setComment('I have just started working on the order');

        $s2 = new AdditionalStatus();
        $s2->setTitle('Almost done!');
        $s2->setComment('I have almost done working on the order');


        $this->notifyLog($id, new Action(Action::CHANGE_ADDITIONAL_STATUS), [
            Extra::OLD_ADDITIONAL_STATUS => AdditionalStatusExtra::fromAdditionalStatus($s1),
            Extra::NEW_ADDITIONAL_STATUS => AdditionalStatusExtra::fromAdditionalStatus($s2),
        ]);
    }

    public function createDocument($id)
    {
        $this->notifyLog($id, new Action(Action::CREATE_DOCUMENT), [
            Extra::NAME => 'order-abc222.pdf'
        ]);
    }

    public function deleteDocument($id)
    {
        $this->notifyLog($id, new Action(Action::DELETE_DOCUMENT), [
            Extra::NAME => 'order-abc222.pdf'
        ]);
    }

    public function createAdditionalDocument($id)
    {
        $this->notifyLog($id, new Action(Action::CREATE_ADDITIONAL_DOCUMENT), [
            Extra::NAME => 'order-xxx.pdf'
        ]);
    }

    public function deleteAdditionalDocument($id)
    {
        $this->notifyLog($id, new Action(Action::DELETE_ADDITIONAL_DOCUMENT), [
            Extra::NAME => 'order-xxx.pdf'
        ]);
    }

    public function bidRequest($id)
    {
        $this->notifyLog($id, new Action(Action::BID_REQUEST));
    }

    public function sendMessage($id)
    {
        $order = new Order();
        $order->setId($id);
        $order->setFileNumber('xxx-yyy-zzz');

        $message = new Message();
        $message->setId(999);
        $message->setEmployee('John Black');

        $message->setOrder($order);

        $order->setAssignee($this->session->getUser());

        $customer = new Customer();
        $customer->setId(100);
        $customer->setName('Dummy');
        $customer->setUsername('dummy');

        $message->setSender($customer);


        $notification = new SendMessageNotification($order, $message);

        $this->notifier->notify($notification);
    }

    public function revisionRequest($id)
    {
        $this->notifyLog($id, new Action(Action::REVISION_REQUEST));
    }

    public function reconsiderationRequest($id)
    {
        $this->notifyLog($id, new Action(Action::RECONSIDERATION_REQUEST));
    }

    private function notifyLog($orderId, Action $action, array $options = [])
    {
        $log = new Log();
        $log->setId(1);
        $log->setAssignee($this->session->getUser());

        $customer = new Customer();
        $customer->setId(100);
        $customer->setName('Dummy');
        $customer->setUsername('dummy');

        $log->setUser($customer);
        $log->setAction($action);

        $order = new Order();
        $order->setId($orderId);

        $log->setOrder($order);

        $extra = new Extra();

        $extra[Extra::ADDRESS_1] = '123 Market Str.';
        $extra[Extra::CITY] = 'San Francisco';
        $extra[Extra::STATE] = new StateExtra('CA', 'California');
        $extra[Extra::ZIP] = '94132';
        $extra[Extra::CUSTOMER] = 'Dummy';
        $extra[Extra::USER] = 'Dude';


        foreach ($options as $name => $value){
            $extra[$name] = $value;
        }

        $log->setExtra($extra);

        $notification = new CreateLogNotification($log);

        $this->notifier->notify($notification);
    }
}