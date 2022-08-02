<?php
return [
	'listeners' => [
		RealEstate\Push\Support\CustomerNotifier::class,
		RealEstate\Push\Support\AmcNotifier::class,
		RealEstate\Letter\Support\Notifier::class,
		RealEstate\Log\Support\Notifier::class,
		RealEstate\Live\Support\Notifier::class,
		RealEstate\Mobile\Support\Notifier::class
	],
	'push' => [
		'handlers' => [
			'customer' => [
                RealEstate\Core\Invitation\Notifications\AcceptInvitationNotification::class =>
                    RealEstate\Push\Handlers\Customer\Invitation\AcceptInvitationHandler::class,

                RealEstate\Core\Invitation\Notifications\DeclineInvitationNotification::class =>
                    RealEstate\Push\Handlers\Customer\Invitation\DeclineInvitationHandler::class,

                RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\UpdateProcessStatusHandler::class,

                RealEstate\Core\Appraisal\Notifications\AcceptOrderWithConditionsNotification::class =>
                    \RealEstate\Push\Handlers\Customer\Appraisal\AcceptOrderWithConditionsHandler::class,

                RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\CreateAdditionalDocumentHandler::class,

                RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\CreateDocumentHandler::class,

                RealEstate\Core\Appraisal\Notifications\DeclineOrderNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\DeclineOrderHandler::class,

                RealEstate\Core\Appraisal\Notifications\SendMessageNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\SendMessageHandler::class,

                RealEstate\Core\Appraisal\Notifications\SubmitBidNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\SubmitBidHandler::class,

                RealEstate\Core\Appraisal\Notifications\UpdateDocumentNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\UpdateDocumentHandler::class,

                RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\ChangeAdditionalStatusHandler::class,

                RealEstate\Core\Appraisal\Notifications\PayTechFeeNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraisal\PayTechFeeHandler::class,

                RealEstate\Core\Appraiser\Notifications\UpdateAppraiserNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraiser\UpdateAppraiserHandler::class,

                RealEstate\Core\Appraiser\Notifications\CreateLicenseNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraiser\LicenseHandler::class,

                RealEstate\Core\Appraiser\Notifications\UpdateLicenseNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraiser\LicenseHandler::class,

                RealEstate\Core\Appraiser\Notifications\DeleteLicenseNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraiser\LicenseHandler::class,

                RealEstate\Core\Appraiser\Notifications\UpdateAchNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraiser\UpdateAchHandler::class,

                RealEstate\Core\Amc\Notifications\ChangeCustomerFeesNotification::class =>
                    RealEstate\Push\Handlers\Customer\Amc\ChangeCustomerFeesHandler::class,

                RealEstate\Core\Appraiser\Notifications\ChangeCustomerFeesNotification::class =>
                    RealEstate\Push\Handlers\Customer\Appraiser\ChangeCustomerFeesHandler::class

            ],
            'amc' => [
                RealEstate\Core\Appraisal\Notifications\AwardOrderNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\AwardOrderHandler::class,

                RealEstate\Core\Appraisal\Notifications\BidRequestNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\BidRequestHandler::class,

                RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\ChangeAdditionalStatusHandler::class,

                RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\CreateAdditionalDocumentHandler::class,

                RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\CreateDocumentHandler::class,

                RealEstate\Core\Log\Notifications\CreateLogNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\CreateLogHandler::class,

                RealEstate\Core\Appraisal\Notifications\CreateOrderNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\CreateOrderHandler::class,

                RealEstate\Core\Appraisal\Notifications\DeleteAdditionalDocumentNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\DeleteAdditionalDocumentHandler::class,

                RealEstate\Core\Appraisal\Notifications\DeleteDocumentNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\DeleteDocumentHandler::class,

                RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\DeleteOrderHandler::class,

                RealEstate\Core\Appraisal\Notifications\SendMessageNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\SendMessageHandler::class,

                RealEstate\Core\Appraisal\Notifications\UpdateDocumentNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\UpdateDocumentHandler::class,

                RealEstate\Core\Appraisal\Notifications\UpdateOrderNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\UpdateOrderHandler::class,

                RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\UpdateProcessStatusHandler::class,

                RealEstate\Core\Appraisal\Notifications\ReconsiderationRequestNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\ReconsiderationRequestHandler::class,

                RealEstate\Core\Appraisal\Notifications\RevisionRequestNotification::class =>
                    RealEstate\Push\Handlers\Amc\Appraisal\RevisionRequestHandler::class,
            ]
		]
	],
	'letter' => [
		'handlers' => [
			RealEstate\Core\Appraisal\Notifications\UpdateOrderNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\UpdateOrderHandler::class,

			RealEstate\Core\Appraisal\Notifications\CreateOrderNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\CreateOrderHandler::class,

			RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\DeleteOrderHandler::class,

			RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\UpdateProcessStatusHandler::class,

			RealEstate\Core\Appraisal\Notifications\BidRequestNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\BidRequestHandler::class,

			RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\ChangeAdditionalStatusHandler::class,

			RealEstate\Core\Appraisal\Notifications\SendMessageNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\SendMessageHandler::class,

			RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\CreateDocumentHandler::class,

			RealEstate\Core\Appraisal\Notifications\DeleteDocumentNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\DeleteDocumentHandler::class,

			RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\CreateAdditionalDocumentHandler::class,

			RealEstate\Core\Appraisal\Notifications\DeleteAdditionalDocumentNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\DeleteAdditionalDocumentHandler::class,

			RealEstate\Core\Appraisal\Notifications\RevisionRequestNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\RevisionRequestHandler::class,

			RealEstate\Core\Appraisal\Notifications\ReconsiderationRequestNotification::class =>
				RealEstate\Letter\Handlers\Appraisal\ReconsiderationRequestHandler::class,

			RealEstate\Core\Amc\Notifications\CreateAmcNotification::class =>
				RealEstate\Letter\Handlers\Amc\CreateAmcHandler::class,

			RealEstate\Core\Amc\Notifications\ApproveAmcNotification::class =>
				RealEstate\Letter\Handlers\Amc\ApproveAmcHandler::class,

			RealEstate\Core\Amc\Notifications\DeclineAmcNotification::class =>
				RealEstate\Letter\Handlers\Amc\DeclineAmcHandler::class,

            RealEstate\Core\Appraisal\Notifications\AwardOrderNotification::class =>
                RealEstate\Letter\Handlers\Appraisal\AwardOrderHandler::class,

            RealEstate\Core\Company\Notifications\CreateStaffNotification::class =>
                RealEstate\Letter\Handlers\Company\CreateStaffHandler::class,

            RealEstate\Core\Company\Notifications\CreateCompanyInvitationNotification::class =>
                RealEstate\Letter\Handlers\Company\CreateCompanyInvitationHandler::class,

            RealEstate\Core\Appraisal\Notifications\AcceptOrderWithConditionsNotification::class =>
                RealEstate\Letter\Handlers\Appraisal\AcceptOrderWithConditionsHandler::class,

            RealEstate\Core\Appraisal\Notifications\DeclineOrderNotification::class =>
                RealEstate\Letter\Handlers\Appraisal\DeclineOrderHandler::class,

            RealEstate\Core\Appraisal\Notifications\SubmitBidNotification::class =>
                RealEstate\Letter\Handlers\Appraisal\SubmitBidHandler::class
		]
	],
	'live' => [
		'handlers' => [
			RealEstate\Core\Log\Notifications\CreateLogNotification::class =>
				RealEstate\Live\Handlers\CreateLogHandler::class,

			RealEstate\Core\Appraisal\Notifications\SendMessageNotification::class =>
				RealEstate\Live\Handlers\SendMessageHandler::class,

			RealEstate\Core\Appraisal\Notifications\CreateOrderNotification::class =>
				RealEstate\Live\Handlers\CreateOrderHandler::class,

			RealEstate\Core\Appraisal\Notifications\UpdateOrderNotification::class =>
				RealEstate\Live\Handlers\UpdateOrderHandler::class,

			RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification::class =>
				RealEstate\Live\Handlers\UpdateProcessStatusHandler::class,

			RealEstate\Core\Appraisal\Notifications\RevisionRequestNotification::class =>
				RealEstate\Live\Handlers\UpdateProcessStatusHandler::class,

			RealEstate\Core\Appraisal\Notifications\ReconsiderationRequestNotification::class =>
				RealEstate\Live\Handlers\UpdateProcessStatusHandler::class,

			RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification::class =>
				RealEstate\Live\Handlers\DeleteOrderHandler::class,

			RealEstate\Core\Appraisal\Notifications\BidRequestNotification::class =>
				RealEstate\Live\Handlers\BidRequestHandler::class,

			RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification::class =>
				RealEstate\Live\Handlers\ChangeAdditionalStatusHandler::class,

			RealEstate\Core\Appraisal\Notifications\AcceptOrderWithConditionsNotification::class =>
				RealEstate\Live\Handlers\AcceptOrderWithConditionsHandler::class,

			RealEstate\Core\Appraisal\Notifications\DeclineOrderNotification::class =>
				RealEstate\Live\Handlers\DeclineOrderHandler::class,

            RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification::class =>
                RealEstate\Live\Handlers\CreateOrderDocumentHandler::class,

            RealEstate\Core\Appraisal\Notifications\UpdateDocumentNotification::class =>
                RealEstate\Live\Handlers\UpdateOrderDocumentHandler::class,

            RealEstate\Core\Appraisal\Notifications\DeleteDocumentNotification::class =>
                RealEstate\Live\Handlers\DeleteOrderDocumentHandler::class,

            RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification::class =>
                RealEstate\Live\Handlers\CreateOrderAdditionalDocumentHandler::class,

            RealEstate\Core\Appraisal\Notifications\DeleteAdditionalDocumentNotification::class =>
                RealEstate\Live\Handlers\DeleteOrderAdditionalDocumentHandler::class,

            RealEstate\Core\Appraisal\Notifications\AwardOrderNotification::class =>
                RealEstate\Live\Handlers\AwardOrderHandler::class,

            RealEstate\Core\Appraisal\Notifications\SubmitBidNotification::class =>
                RealEstate\Live\Handlers\SubmitBidHandler::class

		]
	],
	'mobile' => [
		'handlers' => [
			RealEstate\Core\Log\Notifications\CreateLogNotification::class =>
				RealEstate\Mobile\Handlers\CreateLogHandler::class,

			RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification::class =>
				RealEstate\Mobile\Handlers\DeleteOrderHandler::class,

			RealEstate\Core\Appraisal\Notifications\SendMessageNotification::class =>
				RealEstate\Mobile\Handlers\SendMessageHandler::class,

            RealEstate\Core\Appraisal\Notifications\AcceptOrderWithConditionsNotification::class =>
                RealEstate\Mobile\Handlers\AcceptOrderWithConditionsHandler::class,

            RealEstate\Core\Appraisal\Notifications\DeclineOrderNotification::class =>
                RealEstate\Mobile\Handlers\DeclineOrderHandler::class,

            RealEstate\Core\Appraisal\Notifications\SubmitBidNotification::class =>
                RealEstate\Mobile\Handlers\SubmitBidHandler::class
		]
	]
];
