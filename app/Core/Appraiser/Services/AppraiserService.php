<?php
namespace RealEstate\Core\Appraiser\Services;

use Restate\Libraries\Validation\ErrorsThrowableCollection;
use DateTime;
use Exception;
use Log;
use RealEstate\Core\Appraiser\Criteria\FilterResolver;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Entities\Availability;
use RealEstate\Core\Appraiser\Entities\DefaultFee;
use RealEstate\Core\Appraiser\Entities\EoEx;
use RealEstate\Core\Appraiser\Entities\License;
use RealEstate\Core\Appraiser\Entities\Qualifications;
use RealEstate\Core\Appraiser\Exceptions\LicenseNotAllowedException;
use RealEstate\Core\Appraiser\Notifications\UpdateAppraiserNotification;
use RealEstate\Core\Appraiser\Options\CreateLicenseOptions;
use RealEstate\Core\Appraiser\Options\FetchAppraisersOptions;
use RealEstate\Core\Appraiser\Options\UpdateAppraiserOptions;
use RealEstate\Core\Appraiser\Options\UpdateLicenseOptions;
use RealEstate\Core\Appraiser\Persistables\AppraiserPersistable;
use RealEstate\Core\Appraiser\Persistables\AvailabilityPersistable;
use RealEstate\Core\Appraiser\Persistables\EoExPersistable;
use RealEstate\Core\Appraiser\Persistables\QualificationsPersistable;
use RealEstate\Core\Appraiser\Validation\AppraiserValidator;
use RealEstate\Core\Appraiser\Validation\AvailabilityValidator;
use RealEstate\Core\Asc\Entities\AscAppraiser;
use RealEstate\Core\Asc\Services\AscService;
use RealEstate\Core\Assignee\Services\AssigneeService;
use RealEstate\Core\Company\Entities\Invitation as CompanyInvitation;
use RealEstate\Core\Company\Entities\Staff;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Invitation\Entities\Invitation;
use RealEstate\Core\Invitation\Enums\Status;
use RealEstate\Core\Language\Entities\Language;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Payment\Services\PaymentService;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Criteria\Filter;
use RealEstate\Core\Support\Criteria\Paginator;
use RealEstate\Core\User\Interfaces\PasswordEncryptorInterface;
use RealEstate\Support\Tracker;
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraiserService extends AssigneeService
{
    /**
     * @var LicenseService
     */
    private $licenseService;

    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var AscService
     */
    private $ascService;

    /**
     * @param LicenseService $certificateService
     * @param StateService $stateService
     * @param AscService $ascService
     */
    public function initialize(
		LicenseService $certificateService,
		StateService $stateService,
		AscService $ascService
	)
    {
        $this->licenseService = $certificateService;
        $this->ascService = $ascService;
        $this->stateService = $stateService;
    }

    /**
     * @param int $id
     * @return Appraiser|null
     */
    public function get($id)
    {
        return $this->entityManager->find(Appraiser::class, $id);
    }

	/**
	 * @param FetchAppraisersOptions $options
	 * @return Appraiser[]
	 */
	public function getAll(FetchAppraisersOptions $options = null)
	{
		if ($options === null){
			$options = new FetchAppraisersOptions();
		}

		$builder = $this->entityManager->createQueryBuilder();

		$builder->select('a')->from(Appraiser::class, 'a');

		(new Filter())->apply($builder, $options->getCriteria(), new FilterResolver($this->entityManager));

		return (new Paginator())->apply($builder, $options->getPagination());
	}

	/**
	 * @param array $criteria
	 * @return int
	 */
	public function getTotal(array $criteria = [])
	{
		$builder = $this->entityManager->createQueryBuilder();

		$builder->select($builder->expr()->countDistinct('a'))->from(Appraiser::class, 'a');

		(new Filter())->apply($builder, $criteria, new FilterResolver($this->entityManager));

		return (int) $builder->getQuery()->getSingleScalarResult();
	}

	/**
	 * @param int $customerId
	 * @param FetchAppraisersOptions $options
	 * @return Appraiser[]
	 */
	public function getAllByCustomerId($customerId, FetchAppraisersOptions $options = null)
	{
		if ($options === null){
			$options = new FetchAppraisersOptions();
		}

		$builder = $this->entityManager->createQueryBuilder();

		$builder
			->select('a')
			->from(Appraiser::class, 'a')
			->where($builder->expr()->isMemberOf(':customer', 'a.customers'))
			->setParameter('customer', $customerId);

		(new Filter())->apply($builder, $options->getCriteria(), new FilterResolver($this->entityManager));

		return (new Paginator())->apply($builder, $options->getPagination());
	}

	/**
	 * @param int $customerId
	 * @param array $criteria
	 * @return int
	 */
	public function getTotalByCustomerId($customerId, array $criteria = [])
	{
		$builder = $this->entityManager->createQueryBuilder();

		$builder
			->select($builder->expr()->countDistinct('a'))
			->from(Appraiser::class, 'a')
			->where($builder->expr()->isMemberOf(':customer', 'a.customers'))
			->setParameter('customer', $customerId);

		(new Filter())->apply($builder, $criteria, new FilterResolver($this->entityManager));

		return (int) $builder->getQuery()->getSingleScalarResult();
	}

    /**
     * @param AppraiserPersistable $persistable
     * @return Appraiser
     */
    public function create(AppraiserPersistable $persistable)
    {
		(new AppraiserValidator($this->container))->validate($persistable);

        $appraiser = new Appraiser();
		
		if ($this->environment->isRelaxed()){
			$appraiser->setRegistered(false);
		} else {
			$appraiser->setRegistered(true);
		}

        $this->save($persistable, $appraiser);

        return $appraiser;
    }

	/**
	 * @param int $id
	 * @param AppraiserPersistable $persistable
	 * @param UpdateAppraiserOptions $options
	 * @return void
	 */
	public function update($id, AppraiserPersistable $persistable, UpdateAppraiserOptions $options = null)
	{
		if ($options === null) {
			$options = new UpdateAppraiserOptions();
		}

		$nullable = array_filter($options->getPropertiesScheduledToClear(), function($value){
			return !in_array($value, ['showInitialDisplay', 'status']);
		});

		/**
		 * @var Appraiser $appraiser
		 */
		$appraiser = $this->entityManager->find(Appraiser::class, $id);

		$validator = new AppraiserValidator($this->container);
		$validator->setForcedProperties($nullable);

		if ($options->isSoftValidationMode()){
			$validator->validateSoftlyWithAppraiser($persistable, $appraiser);
		} else {
			$validator->validateWithAppraiser($persistable, $appraiser);
		}

		if (!$this->environment->isRelaxed()){
			$appraiser->setRegistered(true);
		}

		$this->save($persistable, $appraiser, $nullable);

        if ($persistable->getEmail()
            || $persistable->getCompanyName()
            || $persistable->getFirstName()
            || $persistable->getLastName()
            || $persistable->getPhone()
            || $persistable->getFax()
            || $options->isPropertyScheduledToClear('fax')){

            /**
             * @var PaymentService $paymentService
             */
            $paymentService = $this->container->get(PaymentService::class);

            try {
                $paymentService->refreshProfile($appraiser->getId());
            } catch (Exception $ex){
                Log::warning($ex);
            }
        }

		$this->notify(new UpdateAppraiserNotification($appraiser));
	}

	/**
	 * @param int $appraiserId
	 * @param int $licenseId
	 */
	public function changePrimaryLicense($appraiserId, $licenseId)
	{
		if (!$this->hasLicense($appraiserId, $licenseId)){
			throw new LicenseNotAllowedException();
		}

		/**
		 * @var Appraiser $appraiser
		 */
		$appraiser = $this->entityManager->find(Appraiser::class, $appraiserId);

		/**
		 * @var License $license
		 */
		$license = $this->entityManager->find(License::class, $licenseId);

		$appraiser->getQualifications()->setPrimaryLicense($license);

		if (!$this->environment->isRelaxed()){
			$appraiser->setRegistered(true);
		}

		$appraiser->setUpdatedAt(new DateTime());

		$this->entityManager->flush();

		$this->notify(new UpdateAppraiserNotification($appraiser));
	}

	/**
	 * @param int $appraiserId
	 * @param AvailabilityPersistable $persistable
	 * @param UpdateOptions $options
	 */
	public function updateAvailability(
		$appraiserId,
		AvailabilityPersistable $persistable,
		UpdateOptions $options = null
	)
	{
		if ($options === null){
			$options = new UpdateOptions();
		}

		/**
		 * @var Appraiser $appraiser
		 */
		$appraiser = $this->entityManager->find(Appraiser::class, $appraiserId);
		$availability = $appraiser->getAvailability();

		(new AvailabilityValidator())
			->setForcedProperties($options->getPropertiesScheduledToClear())
			->validateWithAvailability($persistable, $availability);

		if (!$this->environment->isRelaxed()){
			$appraiser->setRegistered(true);
		}

		$appraiser->setUpdatedAt(new DateTime());

		$this->saveAvailability($persistable, $availability, $options->getPropertiesScheduledToClear());

		$this->notify(new UpdateAppraiserNotification($appraiser));
	}

	/**
	 * @param AppraiserPersistable $persistable
	 * @return bool
	 * @throws ErrorsThrowableCollection
	 */
	public function dryCreateWithoutLicenseExistenceValidation(AppraiserPersistable $persistable)
	{
		$validator = new AppraiserValidator($this->container);
		$validator->setBypassValidatePrimaryLicenseExistence(true);

		try {
			$validator->validate($persistable);
		} catch (ErrorsThrowableCollection $ex){
			return false;
		}

		return true;
	}

    /**
     * @param int $id
     * @return bool
     */
    public function exists($id)
    {
        return $this->existsByCriteria(['id' => $id]);
    }

    /**
     *
     * @param array $criteria
     * @return bool
     */
    public function existsByCriteria(array $criteria)
    {
        return $this->entityManager->getRepository(Appraiser::class)->exists($criteria);
    }

    /**
     * @param AppraiserPersistable $persistable
     * @param Appraiser $appraiser
     * @param array $nullable
     */
    private function save(AppraiserPersistable $persistable, Appraiser $appraiser, array $nullable = [])
    {
		if ($appraiser->getId() !== null){
			$appraiser->setUpdatedAt(new DateTime());
		}

		if (($availability = $appraiser->getAvailability()) === null){
			$availability = new Availability();
		}

		$this->saveAvailability(
			$persistable->getAvailability() ?? new AvailabilityPersistable(),
			$availability,
			array_map(function($value){
				return cut_string_left($value, 'availability.');
			}, array_filter($nullable, function($v){
				return starts_with($v, 'availability.');
			}))
		);

		$appraiser->setAvailability($availability);

		if ($persistable->getQualifications()){
			$qualifications = $appraiser->getQualifications();

			if ($qualifications === null){
				$qualifications = new Qualifications();
			}

			$this->saveQualifications(
				$persistable->getQualifications(),
				$qualifications,
				array_map(function($value){
					return cut_string_left($value, 'qualifications.');
				}, array_filter($nullable, function($v){
					return starts_with($v, 'qualifications.');
				}))
			);

			$appraiser->setQualifications($qualifications);
		}

		if ($persistable->getEo()){
			$eo = $appraiser->getEo();

			if ($eo === null){
				$eo = new EoEx();
			}

			$this->saveEo($persistable->getEo(), $eo, array_map(function($value){
				return cut_string_left($value, 'eo.');
			}, array_filter($nullable, function($v){
				return starts_with($v, 'eo.');
			})));

			$appraiser->setEo($eo);
		}

        $this->transfer($persistable, $appraiser, [
            'ignore' => [
                'password',
                'sampleReports',
                'state',
                'assignmentState',
                'licenseState',
                'languages',
				'qualifications',
				'eo',
				'w9'
            ],
            'nullable' => array_filter($nullable, function($v){
				return !starts_with($v, 'qualifications.') && !starts_with($v, 'eo.');
			})
        ]);

		if ($persistable->getW9()){
			/**
			 * @var Document $w9
			 */
			$w9 = $this->entityManager->getReference(Document::class, $persistable->getW9()->getId());
			$appraiser->setW9($w9);
		}

        if ($persistable->getSampleReports()) {

			$sampleReports = [];

			foreach ($persistable->getSampleReports()->getIds() as $documentId){
				$sampleReports[] = $this->entityManager->getReference(Document::class, $documentId);
			}

			$appraiser->setSampleReports($sampleReports);
		}

        if ($persistable->getPassword()) {
            /**
             * @var PasswordEncryptorInterface $encryptor
             */
            $encryptor = $this->container->get(PasswordEncryptorInterface::class);
            $appraiser->setPassword($encryptor->encrypt($persistable->getPassword()));
        }

        if ($persistable->getState()) {
            /**
             * @var State $state
             */
            $state = $this->entityManager->getReference(State::class, $persistable->getState());
            $appraiser->setState($state);
        }

        if ($persistable->getAssignmentState()) {
            /**
             * @var State $assignmentState
             */
            $assignmentState = $this->entityManager->getReference(State::class, $persistable->getAssignmentState());
            $appraiser->setAssignmentState($assignmentState);
        }

        if ($persistable->getLanguages()) {

			$languages = [];

            foreach ($persistable->getLanguages() as $code) {
				$languages[] = $this->entityManager->getReference(Language::class, $code);
            }

			$appraiser->setLanguages($languages);
        }

		$isNew = false;

        if (!$appraiser->getId()) {
			$isNew = true;
            $this->entityManager->persist($appraiser);
        }

		$this->entityManager->flush();

		if ($licensePersistable = object_take($persistable, 'qualifications.primaryLicense')){
			if ($isNew){
				$license = $this->licenseService->create(
					$appraiser->getId(),
					$licensePersistable,
					(new CreateLicenseOptions())->setTrusted(true)
				);

				$appraiser->getQualifications()->setPrimaryLicense($license);
			} else {
				$this->licenseService->update(
					$appraiser->getQualifications()->getPrimaryLicense()->getId(),
					$licensePersistable,
					(new UpdateLicenseOptions())->schedulePropertiesToClear(
						array_map(function($value){
							return cut_string_left($value, 'qualifications.primaryLicense.');
						}, array_filter($nullable, function($value){
							return starts_with($value, 'qualifications.primaryLicense.');
						}))
					)->setTrusted(true)
				);
			}
		}

        $this->entityManager->flush();
    }

	/**
	 * @param AvailabilityPersistable $persistable
	 * @param Availability $availability
	 * @param array $nullable
	 */
	private function saveAvailability(
		AvailabilityPersistable $persistable,
		Availability $availability,
		array $nullable = []
	)
	{
		$this->transfer($persistable, $availability, ['nullable' => $nullable]);

		if ($availability->getId() === null){
			$this->entityManager->persist($availability);
		}

		$this->entityManager->flush();
	}

	/**
	 * @param EoExPersistable $persistable
	 * @param EoEx $eo
	 * @param array $nullable
	 */
	private function saveEo(EoExPersistable $persistable, EoEx $eo, array $nullable = [])
	{
		$this->transfer($persistable, $eo, [
			'ignore' => [
				'document',
				'question1Document'
			],
			'nullable' => $nullable
		]);


		if ($persistable->getDocument()){
			/**
			 * @var Document $document
			 */
			$document = $this->entityManager->getReference(Document::class, $persistable->getDocument()->getId());

			$eo->setDocument($document);
		}

		if ($persistable->getQuestion1Document()){
			/**
			 * @var Document $document
			 */
			$document = $this->entityManager->getReference(Document::class, $persistable->getQuestion1Document()->getId());
			$eo->setQuestion1Document($document);
		}

		if (in_array('question1Document', $nullable)){
			$eo->setQuestion1Document(null);
		}

		if ($eo->getId() === null){
			$this->entityManager->persist($eo);
		}

		$this->entityManager->flush();
	}

	/**
	 * @param QualificationsPersistable $persistable
	 * @param Qualifications $qualifications
	 * @param array $nullable
	 */
	private function saveQualifications(QualificationsPersistable $persistable, Qualifications $qualifications, array $nullable = [])
	{
		$this->transfer($persistable, $qualifications, [
			'ignore' => [
				'primaryLicense',
				'resume',
				'certifiedAt'
			],
			'nullable' => $nullable
		]);

		if ($persistable->getCertifiedAt() !== null){
			$qualifications->setCertifiedAt($persistable->getCertifiedAt());
		}

		if (in_array('certifiedAt', $nullable)){
			$qualifications->setCertifiedAt(null);
		}

		if ($persistable->getResume()){
			/**
			 * @var Document $resume
			 */
			$resume = $this->entityManager->getReference(Document::class, $persistable->getResume()->getId());
			$qualifications->setResume($resume);
		}

		if (in_array('resume', $nullable)){
			$qualifications->setResume(null);
		}

		if ($qualifications->getId() === null){
			$this->entityManager->persist($qualifications);
		}

		$this->entityManager->flush();
	}

    /**
     * @param string $number
     * @param string $state
     * @return bool
     */
    public function existsWithLicenseNumberInState($number, $state)
    {
		return $this->entityManager
			->getRepository(License::class)
			->exists(['number' => ['like', $number], 'state' => $state]);
    }

    /**
     * @param int $appraiserId
     * @param int $licenseId
     * @return bool
     */
    public function hasLicense($appraiserId, $licenseId)
    {
        return $this->entityManager
			->getRepository(License::class)
			->exists(['appraiser' => $appraiserId, 'id' => $licenseId]);
    }

	/**
	 * @param int $appraiserId
	 * @param string $state
	 * @return bool
	 */
	public function hasLicenseInState($appraiserId, $state)
	{
		return $this->entityManager
			->getRepository(License::class)
			->exists(['appraiser' => $appraiserId, 'state' => $state]);
	}

	/**
	 * @param int $appraiserId
	 * @param int $invitationId
	 * @return bool
	 */
	public function hasInvitation($appraiserId, $invitationId)
	{
		return $this->entityManager
			->getRepository(Invitation::class)
			->exists(['id' => $invitationId, 'appraiser' => $appraiserId]);
	}

    /**
     * @param int $appraiserId
     * @param int $invitationId
     * @return bool
     */
    public function hasCompanyInvitation($appraiserId, $invitationId)
    {
        /**
         * @var AscAppraiser[] $ascAppraisers
         */
        $ascAppraisers = $this->entityManager
            ->getRepository(AscAppraiser::class)
            ->findBy(['appraiser' => $appraiserId]);

        return $this->entityManager
            ->getRepository(CompanyInvitation::class)
            ->exists(['id' => $invitationId, 'ascAppraiser' => ['in', $ascAppraisers]]);
    }

	/**
	 * @param int $appraiserId
	 * @param int $customerId
	 * @return bool
	 */
	public function hasPendingInvitationFromCustomer($appraiserId, $customerId)
	{
		return $this->entityManager
			->getRepository(Invitation::class)
			->exists(['customer' => $customerId, 'appraiser' => $appraiserId, 'status' => Status::PENDING]);
	}

	/**
	 * @param int $customerId
	 * @param int $appraiserId
	 * @return bool
	 */
	public function isRelatedWithCustomer($appraiserId, $customerId)
	{
		return $this->entityManager
			->getRepository(Appraiser::class)
			->exists(['customers' => ['HAVE MEMBER', $customerId], 'id' => $appraiserId]);
	}

	/**
	 * @param int $appraiserId
	 * @param int $feeId
	 * @return bool
	 */
	public function hasDefaultFee($appraiserId, $feeId)
	{
		return $this->entityManager
			->getRepository(DefaultFee::class)
			->exists(['id' => $feeId, 'appraiser' => $appraiserId]);
	}

	/**
	 * @param int $appraiserId
	 * @param int $jobTypeId
	 * @return bool
	 */
	public function hasDefaultFeeWithJobType($appraiserId, $jobTypeId)
	{
		return $this->entityManager
			->getRepository(DefaultFee::class)
			->exists(['jobType' => $jobTypeId, 'appraiser' => $appraiserId]);
	}

	/**
	 * @param int $appraiserId
	 * @param array $jobTypeIds
	 * @return bool
	 */
	public function hasDefaultFeesWithJobTypes($appraiserId, array $jobTypeIds)
	{
		return $this->entityManager
			->getRepository(DefaultFee::class)
			->exists(['jobType' => ['in', $jobTypeIds], 'appraiser' => $appraiserId]);
	}

	/**
	 * @param int $appraiserId
	 * @return bool
	 */
	public function hasAch($appraiserId)
	{
	    return $this->get($appraiserId)->getAch() !== null;
	}

	/**
	 * Marks all appraisers who return today from vacation as available
	 */
	public function markAllReturnedAsAvailable()
	{
		$builder = $this->entityManager->createQueryBuilder();

		$result = $builder
			->from(Appraiser::class, 'a')
			->select('a')
			->leftJoin('a.availability', 'v')
			->where($builder->expr()->lte('v.to', ':current'))
			->setParameter('current', new DateTime())
			->andWhere($builder->expr()->eq('v.isOnVacation', true))
			->getQuery()
			->iterate();

		foreach ($tracker = new Tracker($result, 100) as $item){
			/**
			 * @var Appraiser $appraiser
			 */
			$appraiser = $item[0];

			$appraiser->getAvailability()->setOnVacation(false);
			$this->notify(new UpdateAppraiserNotification($appraiser));

			if ($tracker->isTime()){
				$this->entityManager->flush();
				$this->entityManager->clear();
			}
		}

		$this->entityManager->flush();
	}

    /**
     * @param int $appraiserId
     * @param int $companyId
     * @return bool
     */
    public function isInCompany($appraiserId, $companyId)
    {
        return $this->entityManager
            ->getRepository(Staff::class)
            ->exists(['user' => $appraiserId, 'company' => $companyId]);
    }
}