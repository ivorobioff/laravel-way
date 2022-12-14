<?php
use RealEstate\Tests\Integrations\Support\Runtime\Runtime;
use RealEstate\Tests\Integrations\Fixtures\AppraisersFixture;
use Restate\QA\Support\Filters\ItemFieldsFilter;
use Restate\QA\Integrations\Checkers\Dynamic;

$appraiser = uniqid('appraiser');
$from = (new DateTime())->format(DateTime::ATOM);
$to = (new DateTime('+1 months'))->format(DateTime::ATOM);

return [

	'createW9:init' => [
		'request' => [
			'url' => 'POST /documents',
			'files' => [
				'document' => __DIR__.'/test.pdf'
			]
		]
	],

	'createEoDocument:init' => [
		'request' => [
			'url' => 'POST /documents',
			'files' => [
				'document' => __DIR__.'/test.txt'
			]
		]
	],

	'createAppraiser:init' => function(Runtime $runtime) use ($appraiser){

		$capture = $runtime->getCapture();

		$data = AppraisersFixture::get([
			'username' => $appraiser,
			'password' => 'password',
			'w9' => [
				'id' => $capture->get('createW9.id'),
				'token' => $capture->get('createW9.token')
			],
			'qualifications' => [
				'primaryLicense' => [
					'number' => 'dummy',
					'state' => 'TX'
				],
			],
			'eo' => [
				'document' => [
					'id' => $capture->get('createEoDocument.id'),
					'token' => $capture->get('createEoDocument.token')
				]
			]
		]);

		return [
			'request' => [
				'url' => 'POST /appraisers',
				'includes' => ['qualifications'],
				'body' => $data
			]
		];
	},

	'loginAppraiser:init' => [
		'request' => [
			'url' => 'POST /sessions',
			'body' => [
				'username' => $appraiser,
				'password' => 'password'
			]
		]
	],

	'tryUpdateAvailabilityWithRequired' => function(Runtime $runtime) use ($from, $to){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'PATCH /appraisers/'.$capture->get('createAppraiser.id').'/availability',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('loginAppraiser.token')
				],
				'body' => [
					'isOnVacation' => true,
					'message' => 'Test ...'
				]
			],
			'response' => [
				'errors' => [
					'from' => [
						'identifier' => 'required',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					],
					'to' => [
						'identifier' => 'required',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},


	'tryUpdateAvailability' => function(Runtime $runtime) use ($from, $to){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'PATCH /appraisers/'.$capture->get('createAppraiser.id').'/availability',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('loginAppraiser.token')
				],
				'body' => [
					'isOnVacation' => null,
					'from' => (new DateTime('+3 months'))->format(DateTime::ATOM),
					'to' => (new DateTime('+2 months'))->format(DateTime::ATOM),
					'message' => 'Test ...'
				]
			],
			'response' => [
				'errors' => [
					'isOnVacation' => [
						'identifier' => 'required',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					],
					'from' => [
						'identifier' => 'invalid',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},

	'updateAvailability' => function(Runtime $runtime) use ($from, $to){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'PATCH /appraisers/'.$capture->get('createAppraiser.id').'/availability',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('loginAppraiser.token')
				],
				'body' => [
					'isOnVacation' => true,
					'from' => $from,
					'to' => $to,
					'message' => 'Test ...'
				]
			]
		];
	},
	'getAppraiser' => function(Runtime $runtime) use ($from, $to){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$capture->get('createAppraiser.id'),
				'includes' => ['availability'],
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('loginAppraiser.token')
				],
			],
			'response' => [
				'body' => [
					'availability' => [
						'isOnVacation' => true,
						'from' => $from,
						'to' => $to,
						'message' => 'Test ...'
					]
				],
				'filter' => new ItemFieldsFilter(['availability'], true)
			]
		];
	},
	'updateAvailabilityNotOnVacation' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'PATCH /appraisers/'.$capture->get('createAppraiser.id').'/availability',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('loginAppraiser.token')
				],
				'body' => [
					'isOnVacation' => false
				]
			]
		];
	},
	'getAppraiserNotOnVacation' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$capture->get('createAppraiser.id'),
				'includes' => ['availability'],
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('loginAppraiser.token')
				],
			],
			'response' => [
				'body' => [
					'availability' => [
						'isOnVacation' => false,
					]
				],
				'filter' => new ItemFieldsFilter(['availability.isOnVacation'], true)
			]
		];
	},
	'updateAvailabilityOnVacation' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'PATCH /appraisers/'.$capture->get('createAppraiser.id').'/availability',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('loginAppraiser.token')
				],
				'body' => [
					'isOnVacation' => true
				]
			]
		];
	},
	'getAppraiserOnVacation' => function(Runtime $runtime) use ($from, $to){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$capture->get('createAppraiser.id'),
				'includes' => ['availability'],
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('loginAppraiser.token')
				],
			],
			'response' => [
				'body' => [
					'availability' => [
						'isOnVacation' => true,
						'from' => $from,
						'to' => $to,
						'message' => 'Test ...'
					]
				],
				'filter' => new ItemFieldsFilter(['availability'], true)
			]
		];
	},
];