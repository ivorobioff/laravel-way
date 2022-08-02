<?php
return [
    'implementations' => [

        RealEstate\Core\Support\Service\ContainerInterface::class =>
            RealEstate\IoC\Container::class,

        RealEstate\Core\User\Interfaces\PasswordEncryptorInterface::class =>
            RealEstate\DAL\User\Support\PasswordEncryptor::class,

        RealEstate\Core\Session\Interfaces\SessionPreferenceInterface::class =>
            RealEstate\DAL\Session\Support\SessionPreference::class,

        RealEstate\Core\Document\Support\Storage\StorageInterface::class =>
            RealEstate\DAL\Document\Support\Storage::class,

        RealEstate\Core\Document\Interfaces\DocumentPreferenceInterface::class =>
           RealEstate\DAL\Document\Support\DocumentPreference::class,

        RealEstate\Core\Shared\Interfaces\TokenGeneratorInterface::class =>
            RealEstate\DAL\Shared\Support\TokenGenerator::class,

		RealEstate\Core\Invitation\Interfaces\ReferenceGeneratorInterface::class =>
			RealEstate\DAL\Invitation\Support\ReferenceGenerator::class,

		RealEstate\Core\Shared\Interfaces\NotifierInterface::class =>
			RealEstate\Support\Alert::class,

		RealEstate\Core\Asc\Interfaces\ImporterInterface::class =>
			RealEstate\DAL\Asc\Support\Import\Importer::class,

		RealEstate\Core\Shared\Interfaces\EnvironmentInterface::class =>
			RealEstate\DAL\Support\Environment::class,

		RealEstate\Core\User\Interfaces\ActorProviderInterface::class =>
			RealEstate\DAL\User\Support\ActorProvider::class,

		RealEstate\Core\Support\Letter\EmailerInterface::class =>
			RealEstate\Letter\Support\Emailer::class,

		RealEstate\Core\Support\Letter\LetterPreferenceInterface::class =>
			RealEstate\Letter\Support\LetterPreference::class,

		RealEstate\Core\Payment\Interfaces\PaymentSystemInterface::class =>
			RealEstate\DAL\Payment\Support\PaymentSystem::class,

		RealEstate\Core\User\Interfaces\PasswordPreferenceInterface::class =>
			RealEstate\DAL\User\Support\PasswordPreference::class,
		
		RealEstate\Core\Appraisal\Interfaces\ExtractorInterface::class =>
			RealEstate\DAL\Appraisal\Support\Extractor::class,

		RealEstate\Core\User\Interfaces\DevicePreferenceInterface::class =>
			RealEstate\DAL\User\Support\DevicePreference::class,

		RealEstate\Core\Location\Interfaces\GeocodingInterface::class =>
			RealEstate\DAL\Location\Support\Geocoding::class,
		
		RealEstate\Core\Amc\Interfaces\InvoiceTransformerInterface::class =>
			RealEstate\DAL\Amc\Support\InvoiceTransformer::class,

        RealEstate\Core\Customer\Interfaces\WalletInterface::class =>
            RealEstate\DAL\Customer\Support\Wallet::class
    ],

    'factories' => [

    ]
];