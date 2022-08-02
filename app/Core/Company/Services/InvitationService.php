<?php
namespace RealEstate\Core\Company\Services;

use Restate\Libraries\Validation\PresentableException;
use RealEstate\Core\Asc\Entities\AscAppraiser;
use RealEstate\Core\Company\Entities\Branch;
use RealEstate\Core\Company\Entities\Invitation;
use RealEstate\Core\Company\Notifications\CreateCompanyInvitationNotification;
use RealEstate\Core\Company\Persistables\InvitationPersistable;
use RealEstate\Core\Company\Validation\InvitationValidator;
use RealEstate\Core\Invitation\Services\VerifyRequirementsTrait;
use RealEstate\Core\Support\Service\AbstractService;
use RealEstate\Core\User\Interfaces\ActorProviderInterface;

class InvitationService extends AbstractService
{
    use VerifyRequirementsTrait;

    /**
     * @param $branchId
     * @return Invitation[]
     */
    public function getAll($branchId)
    {
        return $this->entityManager
            ->getRepository(Invitation::class)
            ->retrieveAll(['branch' => $branchId]);
    }

    /**
     * @param int $branchId
     * @param InvitationPersistable $persistable
     * @return Invitation
     */
    public function create($branchId, InvitationPersistable $persistable)
    {
        /**
         * @var Branch $branch
         */
        $branch = $this->entityManager->find(Branch::class, $branchId);

        (new InvitationValidator($this->container))
            ->setCompany($branch->getCompany())
            ->validate($persistable);

        $invitation = new Invitation();

        $this->transfer($persistable, $invitation, [
            'ignore' => ['ascAppraiser']
        ]);

        $invitation->setBranch($branch);

        /**
         * @var AscAppraiser $ascAppraiser
         */
        $ascAppraiser = $this->entityManager->getReference(
            AscAppraiser::class,
            $persistable->getAscAppraiser()
        );

        $invitation->setAscAppraiser($ascAppraiser);

        $this->entityManager->persist($invitation);
        $this->entityManager->flush();

        $notification = new CreateCompanyInvitationNotification($invitation);

        $this->notify($notification);

        return $invitation;
    }

    /**
     * @param int $appraiserId
     * @return Invitation[]
     */
    public function getAllByAppraiserId($appraiserId)
    {
        /**
         * @var AscAppraisers[] $ascAppraisers
         */
        $ascAppraisers = $this->entityManager
            ->getRepository(AscAppraiser::class)
            ->findBy(['appraiser' => $appraiserId]);

        return $this->entityManager
            ->getRepository(Invitation::class)
            ->retrieveAll(['ascAppraiser' => ['in', $ascAppraisers]]);
    }

    /**
     * @param int $id
     */
    public function accept($id)
    {
        $invitation = $this->entityManager->find(Invitation::class, $id);

        if (! $this->verifyRequirements(
            $invitation->getRequirements(), $invitation->getAscAppraiser()->getAppraiser()
        )) {
            throw new PresentableException(
                'The customer requires the following information to be provided in the profile of the appraiser: '
                .implode(', ', $invitation->getRequirements()->toArray()
            ));
        }

        $staffService = $this->container->get(StaffService::class);
        $staffService->makeStaffByInvitation($invitation);

        $this->entityManager->remove($invitation);

        $this->entityManager->flush();
    }

    /**
     * @param int $id
     */
    public function decline($id)
    {
        $invitation = $this->entityManager->find(Invitation::class, $id);

        $this->entityManager->remove($invitation);

        $this->entityManager->flush();
    }

    /**
     * @param int $ascAppraiserId
     * @param int|array $branchIds
     * @return bool
     */
    public function existsByAscAppraiser($ascAppraiserId, $branchIds = null)
    {
        $criteria = ['ascAppraiser' => $ascAppraiserId];

        if ($branchIds) {
            if (! is_array($branchIds)) {
                $branchIds = [$branchIds];
            }

            $criteria['branch'] = ['in', $branchIds];
        }

        return $this->entityManager
            ->getRepository(Invitation::class)
            ->exists($criteria);
    }
}
