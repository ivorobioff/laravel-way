<?php
namespace RealEstate\Core\Company\Services;

use Restate\Libraries\Validation\PresentableException;
use RealEstate\Core\Appraiser\Entities\Ach;
use RealEstate\Core\Appraiser\Entities\Eo;
use RealEstate\Core\Company\Entities\Branch;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Entities\Staff;
use RealEstate\Core\Company\Persistables\CompanyPersistable;
use RealEstate\Core\Company\Validation\CompanyValidator;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Service\AbstractService;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CompanyService extends AbstractService
{
    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @var StaffService
     */
    private $staffService;

    /**
     * @param BranchService $branchService
     * @param StaffService $staffService
     */
    public function initialize(BranchService $branchService, StaffService $staffService)
    {
        $this->branchService = $branchService;
        $this->staffService = $staffService;
    }

    /**
     * @param int $id
     * @return Company
     */
    public function get($id)
    {
        return $this->entityManager->find(Company::class, $id);
    }

    /**
     * @param string $taxId
     * @return Company
     */
    public function getByTaxId($taxId)
    {
        return $this->entityManager
            ->getRepository(Company::class)
            ->retrieve(['taxId' => $taxId]);
    }

    /**
     * @param int $creatorId
     * @param CompanyPersistable $persistable
     * @return Company
     */
    public function create($creatorId, CompanyPersistable $persistable)
    {
        if ($this->staffService->isAdmin($creatorId)) {
            throw new PresentableException('User is already an admin of a company');
        }

        (new CompanyValidator($this->container))->validate($persistable);

        /**
         * @var User $creator
         */
        $creator = $this->entityManager->getReference(User::class, $creatorId);

        $company = new Company();
        $company->setCreator($creator);

        $this->save($persistable, $company);

        /**
         * @var Branch $branch
         */
        $branch = $this->branchService->makeDefault($company);

        $this->staffService->makeAdmin($branch, $creator);

        return $company;
    }

    /**
     * @param int $id
     * @param CompanyPersistable $persistable
     * @param UpdateOptions $options
     */
    public function update($id, CompanyPersistable $persistable, UpdateOptions $options = null)
    {
        if ($options === null){
            $options = new UpdateOptions();
        }

        /**
         * @var Company $company
         */
        $company = $this->entityManager->find(Company::class, $id);

        (new CompanyValidator($this->container))
            ->setForcedProperties($options->getPropertiesScheduledToClear())
            ->setCurrentCompany($company)
            ->validate($persistable, true);

        $this->save($persistable, $company);
    }

    /**
     * @param CompanyPersistable $persistable
     * @param Company $company
     * @param array $nullable
     */
    private function save(CompanyPersistable $persistable, Company $company, array $nullable = [])
    {
        if ($eoPersistable = $persistable->getEo()){
            $eo = $company->getEo() ?? new Eo();

            $this->transfer($eoPersistable, $eo, [
                'ignore' => [
                    'document'
                ],
                'nullable' => array_map(function($field){
                    return cut_string_left($field, 'eo.');
                }, array_filter($nullable, function($field){
                    return starts_with($field, 'eo.');
                }))
            ]);

            if ($eoPersistable->getDocument()) {
                /**
                 * @var Document $eoDoc
                 */
                $eoDoc = $this->entityManager->getReference(
                    Document::class, $eoPersistable->getDocument()->getId()
                );

                $eo->setDocument($eoDoc);
            }

            if ($eo->getId() === null){
                $this->entityManager->persist($eo);
            }

            $company->setEo($eo);
        }


        if ($achPersistable = $persistable->getAch()){
            $ach = $company->getAch() ?? new Ach();

            $this->transfer($achPersistable, $ach, [
                'nullable' => array_map(function($field){
                    return cut_string_left($field, 'ach.');
                }, array_filter($nullable, function($field){
                    return starts_with($field, 'ach.');
                }))
            ]);

            if ($ach->getId() === null){
                $this->entityManager->persist($ach);
            }

            $company->setAch($ach);
        }

        if ($persistable->getW9()){
            /**
             * @var Document $w9
             */
            $w9 = $this->entityManager->getReference(Document::class, $persistable->getW9()->getId());
            $company->setW9($w9);
        }

        $this->transfer($persistable, $company, [
            'ignore' => [
                'state',
                'eo',
                'ach',
                'w9'
            ]
        ]);

        if ($state = $persistable->getState()){
            $state = $this->entityManager->getReference(State::class, $state);
            $company->setState($state);
        }

        if ($company->getId() === null){
            $this->entityManager->persist($company);
        }

        $this->entityManager->flush();
    }

    /**
     * @param int $appraiserId
     * @return Company[]
     */
    public function getAllByAppraiserId($appraiserId)
    {
        $staff = $this->entityManager->getRepository(Staff::class)->retrieveAll(['user' => $appraiserId]);
        $companies = array_map(function ($staff) {
            return $staff->getBranch()->getCompany();
        }, $staff);

        return $companies;
    }

    /**
     * @param int $companyId
     * @return bool
     */
    public function exists($companyId)
    {
        return $this->entityManager->getRepository(Company::class)->exists(['id' => $companyId]);
    }

    /**
     * @param string $taxId
     * @return bool
     */
    public function existsWithTaxId($taxId)
    {
        return $this->entityManager->getRepository(Company::class)->exists(['taxId' => $taxId]);
    }

    /**
     * @param int $companyId
     * @param int $userId
     * @return bool
     */
    public function hasAdmin($companyId, $userId)
    {
        return $this->entityManager->getRepository(Staff::class)->exists([
            'isAdmin' => true, 'user' => $userId, 'company' => $companyId
        ]);
    }

    /**
     * @param int $companyId
     * @param int $branchId
     * @return bool
     */
    public function hasBranch($companyId, $branchId)
    {
        return $this->entityManager->getRepository(Branch::class)
            ->exists(['id' => $branchId, 'company' => $companyId]);
    }

    /**
     * @param int $companyId
     * @param int $staffId
     * @return bool
     */
    public function hasStaff($companyId, $staffId)
    {
        return $this->entityManager->getRepository(Staff::class)
            ->exists(['id' => $staffId, 'company' => $companyId]);
    }

    /**
     * @param int $companyId
     * @param int $userId
     * @return bool
     */
    public function hasManager($companyId, $userId)
    {
        return $this->entityManager->getRepository(Staff::class)->exists([
            'isManager' => true, 'user' => $userId, 'company' => $companyId
        ]);
    }
}