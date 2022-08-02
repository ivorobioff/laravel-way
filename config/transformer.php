<?php
$config = [
    'include' => [
        'default' => [
            RealEstate\Core\User\Entities\User::class => [
                'id', 'firstName', 'lastName', 'fullName', 'username', 'email', 'displayName', 'type'
            ],
			RealEstate\Core\Customer\Entities\Customer::class => [
				'name', 'companyType'
			],
			RealEstate\Core\User\Entities\System::class => [
				'name'
			],
			RealEstate\Core\Location\Entities\County::class => [
				'id', 'title'
			],
			RealEstate\Core\Appraisal\Entities\Order::class => [
				'id', 'fileNumber'
			],
			RealEstate\Core\Amc\Entities\Amc::class => [
				'companyName'
			],
			RealEstate\Core\Company\Entities\Company::class => [
				'id', 'name'
			],
			RealEstate\Core\Company\Entities\Branch::class => [
				'id', 'name'
			],
            RealEstate\Core\Company\Entities\Staff::class => [
                'id', 'user', 'email', 'phone', 'isAdmin', 'isManager', 'isRfpManager'
            ]
        ],
        'ignore' => [
            RealEstate\Core\User\Entities\User::class => [
                'password'
            ],
            RealEstate\Core\Document\Entities\Document::class => [
				'uri', 'isExternal'
            ],
			RealEstate\Core\Appraiser\Entities\License::class => [
				'appraiser'
			],
			RealEstate\Core\Amc\Entities\License::class => [
				'amc'
			],
			RealEstate\Core\Customer\Entities\Customer::class => [
				'appraisers', 'amcs'
			],
			RealEstate\Core\Appraiser\Entities\Appraiser::class => [
				'customers', 'licenses', 'ach'
			],
			RealEstate\Core\Amc\Entities\Amc::class => [
				'customers', 'settings'
			],
			RealEstate\Core\Assignee\Entities\CustomerFee::class => [
				'assignee', 'customer'
			],
			RealEstate\Core\Appraiser\Entities\DefaultFee::class => [
				'appraiser'
			],
			RealEstate\Core\Appraisal\Entities\Order::class => [
				'workflow',
				'hasAdditionalDocuments',
				'hasInstructionDocuments',
				'borrower',
                'supportingDetails',
                'staff'
			],
			RealEstate\Core\Customer\Entities\JobType::class => [
				'customer', 'isHidden'
			],
			RealEstate\Core\Customer\Entities\DocumentSupportedFormats::class => [
				'customer'
			],
			RealEstate\Core\Appraisal\Entities\Document::class => [
				'order'
			],
			RealEstate\Core\Appraisal\Entities\AdditionalDocument::class => [
				'order'
			],
			RealEstate\Core\Appraisal\Entities\Revision::class => [
				'order'
			],
			RealEstate\Core\Appraisal\Entities\Reconsideration::class => [
				'order'
			],
			RealEstate\Core\Appraisal\Entities\Property::class => [
				'id', 'hasContacts'
			],
			RealEstate\Core\Appraiser\Entities\EoEx::class => [
				'id'
			],
			RealEstate\Core\Appraiser\Entities\Qualifications::class => [
				'id'
			],
			RealEstate\Core\Appraiser\Entities\Ach::class => [
				'id', 'appraiser'
			],
			RealEstate\Core\Appraisal\Entities\Bid::class => [
				'id', 'order'
			],
			RealEstate\Core\Log\Entities\Log::class => [
				'assignee', 'customer'
			],
			RealEstate\Core\Appraisal\Entities\Message::class => [
				'readers'
			],
			RealEstate\Core\Customer\Entities\AdditionalStatus::class => [
				'customer', 'isActive'
			],
			RealEstate\Core\Appraiser\Entities\Availability::class => [
				'id'
			],
			RealEstate\Core\Assignee\Entities\NotificationSubscription::class => [
				'assignee', 'id'
			],
			RealEstate\Core\Customer\Entities\Settings::class => [
				'customer'
			],
			RealEstate\Core\Appraisal\Entities\AcceptedConditions::class => [
				'id'
			],
			RealEstate\Core\User\Entities\Device::class => [
				'user'
			],
			RealEstate\Core\Customer\Entities\Client::class => [
				'customer'
			],
			RealEstate\Core\Customer\Entities\Ruleset::class => [
				'customer'
			],
			RealEstate\Core\Amc\Entities\Fee::class => [
				'amc', 'isEnabled', 'id'
			],
			RealEstate\Core\Amc\Entities\FeeByState::class => [
				'fee', 'id'
			],
			RealEstate\Core\Amc\Entities\FeeByCounty::class => [
				'fee', 'id'
			],
			RealEstate\Core\Amc\Entities\FeeByZip::class => [
				'fee', 'id'
			],
			RealEstate\Core\Amc\Entities\CustomerFeeByState::class => [
				'fee', 'id'
			],
			RealEstate\Core\Amc\Entities\CustomerFeeByCounty::class => [
				'fee', 'id'
			],
			RealEstate\Core\Amc\Entities\CustomerFeeByZip::class => [
				'fee', 'id'
			],
            RealEstate\Core\Amc\Entities\Invoice::class => [
                'amc'
            ],
            RealEstate\Core\Amc\Entities\Item::class => [
                'invoice', 'order'
            ],
            RealEstate\Core\Amc\Entities\Settings::class => [
                'amc', 'id'
            ],
            RealEstate\Core\Appraisal\Entities\Fdic::class => [
                'id'
            ],
            RealEstate\Core\Company\Entities\Fee::class => [
                'company'
            ]
        ]
    ],

	'specifications' => [
		RealEstate\Core\Location\Entities\County::class => [
			'zips' => RealEstate\Api\Location\V2_0\Support\CountySpecification::class
		]
	],

    'calculatedProperties' => [
        RealEstate\Core\Document\Entities\Document::class => [
            'url' => RealEstate\Api\Document\V2_0\Support\UrlCalculatedProperty::class,
            'urlEncoded' => RealEstate\Api\Document\V2_0\Support\UrlEncodedCalculatedProperty::class,
        ],
		RealEstate\Core\Appraisal\Entities\Message::class => [
			'isRead' => RealEstate\Api\Appraisal\V2_0\Support\IsMessageReadCalculatedProperty::class
		],
		RealEstate\Core\Customer\Entities\Settings::class => [
			'canAppraiserChangeJobTypeFees' =>
				RealEstate\Api\Appraiser\V2_0\Support\CanAppraiserChangeJobTypeFeesCalculatedProperty::class
		],
        RealEstate\Core\Company\Entities\Company::class => [
            'staff' => RealEstate\Api\Company\V2_0\Transformers\StaffCalculatedProperty::class
        ],
        RealEstate\Core\User\Entities\User::class => [
            'type' => RealEstate\Api\User\V2_0\Transformers\TypeCalculatedProperty::class,
            'isBoss' => RealEstate\Api\User\V2_0\Transformers\IsBossCalculatedProperty::class
        ]
    ],

	'modifiers' => [
		RealEstate\Core\Appraisal\Entities\Message::class => [
			'after' => [
				'content' => ['purifier']
			]
		],
		RealEstate\Core\Appraisal\Entities\Order::class => [
			'after' => [
				'instruction' => ['purifier'],
				'comment' => ['purifier'],
				'additionalStatusComment' => ['purifier']
			]
		],
		RealEstate\Core\Appraisal\Objects\Conditions::class => [
			'after' => [
				'explanation' => ['purifier']
			]
		],
		RealEstate\Core\Appraisal\Entities\AcceptedConditions::class => [
			'after' => [
				'additionalComments' => ['purifier']
			]
		],
		RealEstate\Core\Appraisal\Entities\Bid::class => [
			'after' => [
				'comments' => ['purifier']
			]
		],
		RealEstate\Core\Appraiser\Entities\Availability::class => [
			'after' => [
				'message' => ['purifier']
			]
		],
		RealEstate\Core\Customer\Entities\AdditionalStatus::class => [
			'after' => [
				'comment' => ['purifier']
			]
		],
		RealEstate\Core\Appraisal\Entities\Property::class => [
			'after' => [
				'additionalComments' => ['purifier']
			]
		],
		RealEstate\Core\Appraisal\Entities\Reconsideration::class => [
			'after' => [
				'comment' => ['purifier']
			]
		],
		RealEstate\Core\Appraisal\Objects\Comparable::class => [
			'after' => [
				'comment' => ['purifier']
			]
		],
		RealEstate\Core\Appraisal\Entities\Revision::class => [
			'after' => [
				'message' => ['purifier']
			]
		],
        RealEstate\Core\Appraiser\Entities\Ach::class => [
            'after' => [
                'accountNumber' => ['mask'],
                'routing' => ['mask']
            ]
        ]
	],

    'stringable' => [
        RealEstate\Core\Appraiser\Entities\Appraiser::class => 'appraiser',
		RealEstate\Core\Customer\Entities\Customer::class => 'customer',
		RealEstate\Core\User\Entities\System::class => 'system',
		RealEstate\Core\Back\Entities\Admin::class => 'admin',
		RealEstate\Core\Amc\Entities\Amc::class => 'amc',
		RealEstate\Core\Company\Entities\Manager::class => 'manager'
    ],

	'filter' => RealEstate\Api\Support\Converter\Extractor\FilterWithinContext::class,

	'filters' => [
		RealEstate\Core\Appraiser\Entities\Appraiser::class =>
			RealEstate\Api\Support\Converter\Extractor\Filters\AppraiserFilter::class,

		RealEstate\Core\Appraisal\Entities\Document::class =>
				RealEstate\Api\Support\Converter\Extractor\Filters\AppraisalFilter::class,
		
		RealEstate\Core\Document\Entities\Document::class =>
			RealEstate\Api\Support\Converter\Extractor\Filters\DocumentFilter::class,

		RealEstate\Core\Appraisal\Entities\Order::class =>
			RealEstate\Api\Support\Converter\Extractor\Filters\OrderFilter::class,

		RealEstate\Core\Customer\Entities\Settings::class =>
			RealEstate\Api\Support\Converter\Extractor\Filters\CustomerSettingsFilter::class,

		RealEstate\Core\Customer\Entities\Customer::class =>
			RealEstate\Api\Support\Converter\Extractor\Filters\CustomerFilter::class,

		RealEstate\Core\Company\Entities\Company::class =>
			RealEstate\Api\Support\Converter\Extractor\Filters\CompanyFilter::class,
	]

];

for ($i = 1; $i <= 7; $i ++){
	$config['modifiers'][RealEstate\Core\Appraiser\Entities\EoEx::class]['after']['question'.$i.'Explanation'] = ['purifier'];
}


return $config;