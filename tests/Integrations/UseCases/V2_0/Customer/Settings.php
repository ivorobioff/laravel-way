<?php
use RealEstate\Tests\Integrations\Support\Runtime\Runtime;
use RealEstate\Tests\Integrations\Support\Filters\MessageAndExtraFilter;
use Restate\QA\Support\Filters\ItemFieldsFilter;
use RealEstate\Core\Customer\Enums\Criticality;

return [
	'createCustomer:init' => [
		'request' => [
			'url' => 'POST /customers',
			'body' => [
				'username' => 'settingscustomertest1',
				'password' => 'password',
				'name' => 'settingscustomertest1'
			]
		]
	],
	'signinCustomer:init' => [
		'request' => [
			'url' => 'POST /sessions',
			'body' => [
				'username' => 'settingscustomertest1',
				'password' => 'password'
			]
		]
	],

	'get1' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /customers/'.$capture->get('createCustomer.id').'/settings',
				'auth' => 'guest',
				'headers' => ['Token' => $capture->get('signinCustomer.token')]
			],
			'response' => [
				'body' => [
					'pushUrl' => null,
					'daysPriorInspectionDate' => 1,
					'daysPriorEstimatedCompletionDate' => 1,
					'preventViolationOfDateRestrictions' => Criticality::DISABLED,
					'disallowChangeJobTypeFees' => false,
					'showClientToAppraiser' => true,
					'showDocumentsToAppraiser' => true,
					'isSmsEnabled' => false,
                    'unacceptedReminder' => null
				]
			]
		];
	},

	'validate' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'PATCH /customers/'.$capture->get('createCustomer.id').'/settings',
				'body' => [
					'pushUrl' => ' ',
					'daysPriorInspectionDate' => -1,
					'daysPriorEstimatedCompletionDate' => -20,
					'preventViolationOfDateRestrictions' => null,
					'disallowChangeJobTypeFees' => null,
					'showClientToAppraiser' => null,
					'showDocumentsToAppraiser' => null,
					'isSmsEnabled' => null
				],
				'auth' => 'guest',
				'headers' => ['Token' => $capture->get('signinCustomer.token')]
			],
			'response' => [
				'errors' => [
					'pushUrl' => [
						'identifier' => 'empty'
					],
					'daysPriorInspectionDate' => [
						'identifier' => 'greater'
					],
					'daysPriorEstimatedCompletionDate' => [
						'identifier' => 'greater'
					],
					'preventViolationOfDateRestrictions' => [
						'identifier' => 'required'
					],
					'disallowChangeJobTypeFees' => [
						'identifier' => 'required'
					],
					'showClientToAppraiser' => [
						'identifier' => 'required'
					],
					'showDocumentsToAppraiser' => [
						'identifier' => 'required'
					],
					'isSmsEnabled' => [
						'identifier' => 'required'
					]
				],
				'filter' => new MessageAndExtraFilter()
			]
		];
	},

	'update1' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'PATCH /customers/'.$capture->get('createCustomer.id').'/settings',
				'body' => [
					'pushUrl' => 'http://blog.igorvorobiov.com',
					'daysPriorInspectionDate' => 2,
					'daysPriorEstimatedCompletionDate' => 0,
					'preventViolationOfDateRestrictions' => Criticality::HARDSTOP,
					'disallowChangeJobTypeFees' => true,
					'showClientToAppraiser' => false,
					'showDocumentsToAppraiser' => false,
					'isSmsEnabled' => true,
                    'unacceptedReminder' => 2
				],
				'auth' => 'guest',
				'headers' => ['Token' => $capture->get('signinCustomer.token')]
			]
		];
	},

	'get2' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /customers/'.$capture->get('createCustomer.id').'/settings',
				'auth' => 'guest',
				'headers' => ['Token' => $capture->get('signinCustomer.token')]
			],
			'response' => [
				'body' => [
					'pushUrl' => 'http://blog.igorvorobiov.com',
					'daysPriorInspectionDate' => 2,
					'daysPriorEstimatedCompletionDate' => 0,
					'preventViolationOfDateRestrictions' => Criticality::HARDSTOP,
					'disallowChangeJobTypeFees' => true,
					'showClientToAppraiser' => false,
					'showDocumentsToAppraiser' => false,
					'isSmsEnabled' => true,
                    'unacceptedReminder' => 2
				]
			]
		];
	},

	'update2' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'PATCH /customers/'.$capture->get('createCustomer.id').'/settings',
				'body' => [
					'pushUrl' => null,
                    'unacceptedReminder' => null
				],
				'auth' => 'guest',
				'headers' => ['Token' => $capture->get('signinCustomer.token')]
			]
		];
	},

	'get3' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /customers/'.$capture->get('createCustomer.id').'/settings',
				'auth' => 'guest',
				'headers' => ['Token' => $capture->get('signinCustomer.token')]
			],
			'response' => [
				'body' => [
					'pushUrl' => null,
                    'unacceptedReminder' => null
				],
				'filter' => new ItemFieldsFilter(['pushUrl', 'unacceptedReminder'], true)
			]
		];
	},
];
