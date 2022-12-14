<?php
use RealEstate\Tests\Integrations\Support\Runtime\Runtime;
use RealEstate\Tests\Integrations\Fixtures\OrdersFixture;
use Restate\QA\Integrations\Checkers\Dynamic;
use Restate\QA\Support\Filters\FirstFilter;
use RealEstate\Core\Log\Enums\Action;

$customer = uniqid('customer');

return [
	'createPdf1:init' => [
		'request' => [
			'url' => 'POST /documents',
			'files' => [
				'document' => __DIR__.'/test.pdf'
			]
		]
	],
	'createPdf2:init' => [
		'request' => [
			'url' => 'POST /documents',
			'files' => [
				'document' => __DIR__.'/test.pdf'
			]
		]
	],
	'createOrder:init' => function(Runtime $runtime){
		$customerSession = $runtime->getSession('customer');
		$appraiserSession = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'POST /customers/'
					.$customerSession->get('user.id').'/appraisers/'
					.$appraiserSession->get('user.id').'/orders',
				'auth' => 'customer',
				'body' => OrdersFixture::get($runtime->getHelper(), [
					'client' => 1,
					'clientDisplayedOnReport' => 2
				])
			]
		];
	},
	'createCustomer:init' => [
		'request' => [
			'url' => 'POST /customers',
			'body' => [
				'username' => $customer,
				'password' => 'password',
				'name' => $customer
			]
		]
	],
	'signinCustomer:init' => [
		'request' => [
			'url' => 'POST /sessions',
			'body' => [
				'username' => $customer,
				'password' => 'password'
			]
		]
	],
	'addJobType:init' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /customers/'.$capture->get('createCustomer.id').'/job-types',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('signinCustomer.token')
				],
				'body' => [
					'title' => 'Test 1'
				]
			]
		];
	},
	'addClient:init' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /customers/'.$capture->get('createCustomer.id').'/clients',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('signinCustomer.token')
				],
				'body' => [
					'name' => 'Wonderful World'
				]
			]
		];
	},
	'invite:init' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /customers/'.$capture->get('createCustomer.id').'/invitations',
				'body' => [
					'ascAppraiser' => 4
				],
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('signinCustomer.token')
				]
			]
		];

	},
	'acceptInvitation:init' => function(Runtime $runtime){
		$capture = $runtime->getCapture();
		$session = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/invitations/'
					.$capture->get('invite.id').'/accept',
			]
		];
	},
	'createOrder2:init' => function(Runtime $runtime){
		$capture = $runtime->getCapture();
		$appraiserSession = $runtime->getSession('appraiser');

		$data =  OrdersFixture::get($runtime->getHelper(), [
			'client' => $capture->get('addClient.id'),
			'clientDisplayedOnReport' => $capture->get('addClient.id')
		]);

		$data['jobType'] = $capture->get('addJobType.id');

		return [
			'request' => [
				'url' => 'POST /customers/'
					.$capture->get('createCustomer.id').'/appraisers/'
					.$appraiserSession->get('user.id').'/orders',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('signinCustomer.token')
				],
				'body' => $data
			]
		];
	},
	'addType1:init' => function(Runtime $runtime){
		$session = $runtime->getSession('customer');

		return [
			'request' => [
				'url' => 'POST /customers/'.$session->get('user.id')
					.'/settings/additional-documents/types',
				'auth' => 'customer',
				'body' => [
					'title' => 'Test type'
				]
			]
		];
	},
	'addType2:init' => function(Runtime $runtime){
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /customers/'.$capture->get('createCustomer.id')
					.'/settings/additional-documents/types',
				'auth' => 'guest',
				'headers' => [
					'Token' => $capture->get('signinCustomer.token')
				],
				'body' => [
					'title' => 'Test type'
				]
			]
		];
	},
	'createWithWrongType' => function(Runtime $runtime){
		$capture = $runtime->getCapture();
		$session = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder.id').'/additional-documents',
				'body' => [
					'type' => $capture->get('addType2.id'),
					'document' => [
						'id' => $capture->get('createPdf1.id'),
						'token' => $capture->get('createPdf1.token')
					]
				]
			],
			'response' => [
				'errors' => [
					'type' => [
						'identifier' => 'exists',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},
	'create' => function(Runtime $runtime){
		$capture = $runtime->getCapture();
		$session = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder.id').'/additional-documents',
				'body' => [
					'type' => $capture->get('addType1.id'),
					'document' => [
						'id' => $capture->get('createPdf1.id'),
						'token' => $capture->get('createPdf1.token')
					]
				]
			],
			'response' => [
				'body' => [
					'id' => new Dynamic(Dynamic::INT),
					'type' => $capture->get('addType1'),
					'document' => $capture->get('createPdf1'),
					'createdAt' => new Dynamic(Dynamic::DATETIME),
					'label' => null
				]
			],
			'push' => [
				'body' => [
					[
						'type' => 'order',
						'event' => 'create-additional-document',
						'order' => $capture->get('createOrder.id'),
						'additionalDocument' => new Dynamic(Dynamic::INT)
					]
				]
			],
			'emails' => [
				'body' => [],
			],
			'mobile' => [
				'body' => []
			],
            'live' => [
                'body' => [
                    [
                        'channels' => [
                            'private-user-'.$runtime->getSession('appraiser')->get('user.id'),
                            'private-user-'.$runtime->getSession('customer')->get('user.id').'-as-'.$runtime->getSession('appraiser')->get('user.id')
                        ],
                        'event' => 'order:create-log',
                        'data' => new Dynamic(function($value){
                            return $value['action'] == Action::CREATE_ADDITIONAL_DOCUMENT;
                        })
                    ],
                    [
                        'event' => 'order:create-additional-document',
                        'channels' => [
                            'private-user-'.$runtime->getSession('appraiser')->get('user.id'),
                            'private-user-'.$runtime->getSession('customer')->get('user.id').'-as-'.$runtime->getSession('appraiser')->get('user.id')
                        ],
                        'data' => [
                           'order' => [
                               'id' => $capture->get('createOrder.id'),
                               'fileNumber' => $capture->get('createOrder.fileNumber')
                           ],
                           'additionalDocument' => [
                               'id' => new Dynamic(Dynamic::INT),
                               'type' => $capture->get('addType1'),
                               'document' => $capture->get('createPdf1'),
                               'createdAt' => new Dynamic(Dynamic::DATETIME),
                               'label' => null
                           ]
                        ]
                    ]
                ]
            ]
		];
	},

	'email' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder.id').'/additional-documents/'
					.$capture->get('create.id').'/email',
				'body' => [
					'email' => 'igor.vorobioff@gmail.com'
				]
			],
			'emails' => [
				'body' => [
					[
						'from' => [
							'no-reply@realestate.com' => $session->get('user.firstName').' '.$session->get('user.lastName')
						],
						'to' => [
							'igor.vorobioff@gmail.com' => null,
						],
						'subject' => 'Documents - Order#: '.$capture->get('createOrder.fileNumber'),
						'contents' => new Dynamic(function($value) use ($session, $capture){
							return str_contains($value, $session->get('user.firstName').' '.$session->get('user.lastName'))
							&& str_contains($value, $capture->get('createOrder.fileNumber'))
							&& str_contains($value, $capture->get('createPdf1.name'))
							&& str_contains($value, $capture->get('createPdf1.url'));
						})
					]
				]
			]
		];
	},

	'getAll' => function(Runtime $runtime){
		$capture = $runtime->getCapture();
		$session = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder.id').'/additional-documents'
			],
			'response' => [
				'body' => [$capture->get('create')]
			]
		];
	},
	'tryCreateWithDefaultType' => function(Runtime $runtime){
		$capture = $runtime->getCapture();
		$session = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder.id').'/additional-documents',
				'body' => [
					'document' => [
						'id' => $capture->get('createPdf2.id'),
						'token' => $capture->get('createPdf2.token')
					]
				]
			],
			'response' => [
				'errors' => [
					'label' => [
						'identifier' => 'required',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},
	'createWithDefaultType' => function(Runtime $runtime){
		$capture = $runtime->getCapture();
		$session = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder.id').'/additional-documents',
				'body' => [
					'label' => 'Test Label',
					'document' => [
						'id' => $capture->get('createPdf2.id'),
						'token' => $capture->get('createPdf2.token')
					]
				]
			],
			'response' => [
				'body' => [
					'id' => new Dynamic(Dynamic::INT),
					'type' => null,
					'label' => 'Test Label',
					'document' => $capture->get('createPdf2'),
					'createdAt' => new Dynamic(Dynamic::DATETIME)
				]
			]
		];
	},
	'getAllWithDefault' => function(Runtime $runtime){
		$capture = $runtime->getCapture();
		$session = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder.id').'/additional-documents'
			],
			'response' => [
				'body' => $capture->get('createWithDefaultType'),
				'filter' => new FirstFilter(function($k, $v) use ($capture){
					return $capture->get('createWithDefaultType.id') == $v['id'];
				})
			]
		];
	},
];