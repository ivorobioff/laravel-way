<?php
use RealEstate\Tests\Integrations\Support\Runtime\Runtime;
use RealEstate\Tests\Integrations\Fixtures\OrdersFixture;
use Restate\QA\Integrations\Checkers\Dynamic;
use Restate\QA\Support\Filters\FirstFilter;
use Restate\QA\Support\Response;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Log\Enums\Action;

return [
	'createOrder1:init' => function(Runtime $runtime){
		$customerSession = $runtime->getSession('customer');
		$appraiserSession = $runtime->getSession('appraiser');

		$data = OrdersFixture::get($runtime->getHelper(), [
			'client' => 1,
			'clientDisplayedOnReport' => 2
		]);
		$data['techFee'] = 10.02;

		return [
			'request' => [
				'url' => 'POST /customers/'
					.$customerSession->get('user.id').'/appraisers/'
					.$appraiserSession->get('user.id').'/orders',
				'auth' => 'customer',
				'body' => $data
			]
		];
	},
	'createOrder2:init' => function(Runtime $runtime){
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

	'createOrder3:init' => function(Runtime $runtime){
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

	'getAll' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders',
			],
			'response' => [
				'body' => [
					'id' => new Dynamic(Dynamic::INT),
					'fileNumber' => new Dynamic(Dynamic::STRING)
				],
				'filter' => new FirstFilter(function($k, $v) use ($capture) {
					return true;
				})
			]
		];
	},
	'get' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders/'.$capture->get('createOrder1.id'),
			],
			'response' => [
				'body' => [
					'id' => new Dynamic(Dynamic::INT),
					'fileNumber' => new Dynamic(Dynamic::STRING)
				]
			]
		];
	},
	'accept' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder1.id').'/accept',
			],
			'push' => [
				'body' => [
					'type' => 'order',
					'event' => 'update-process-status',
					'order' => $capture->get('createOrder1.id'),
					'oldProcessStatus' => ProcessStatus::FRESH,
					'newProcessStatus' => ProcessStatus::ACCEPTED
				],
				'single' => true
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
                            return $value['action'] == Action::UPDATE_PROCESS_STATUS;
                        })
                    ],
					[
                        'channels' => [
                            'private-user-'.$runtime->getSession('appraiser')->get('user.id'),
                            'private-user-'.$runtime->getSession('customer')->get('user.id').'-as-'.$runtime->getSession('appraiser')->get('user.id')
                        ],
						'event' => 'order:update-process-status',
						'data' => [
							'order' => new Dynamic(function($data) use ($capture){
								return $data['id'] == $capture->get('createOrder1.id');
							}),
							'oldProcessStatus' => ProcessStatus::FRESH,
							'newProcessStatus' => ProcessStatus::ACCEPTED,
						]
					]
				]
			],
			'emails' => [
				'body' => []
			],
			'mobile' => [
				'body' => []
			]
		];
	},

	'getAccepted' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders/'.$capture->get('createOrder1.id'),
				'includes' => ['processStatus', 'acceptedAt']
			],
			'response' => [
				'body' => [
					'id' => new Dynamic(Dynamic::INT),
					'fileNumber' => new Dynamic(Dynamic::STRING),
					'processStatus' => 'accepted',
					'acceptedAt' => new Dynamic(Dynamic::DATETIME)
				]
			]
		];
	},
	'acceptAgain' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder1.id').'/accept',
			]
		];
	},
	'tryDecline' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder1.id').'/decline',
				'body' => [
					'reason' => 'out-of-coverage-area'
				]
			],
			'response' => [
				'status' => Response::HTTP_BAD_REQUEST
			]
		];
	},
	'declineValidation' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder2.id').'/decline',
			],
			'response' => [
				'errors' => [
					'reason' => [
						'identifier' => 'required',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},
	'decline' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder2.id').'/decline',
				'body' => [
					'reason' => 'other',
					'message' => 'some message'
				]
			],
			'push' => [
				'body' => [
					'type' => 'order',
					'event' => 'decline',
					'order' => $capture->get('createOrder2.id'),
					'reason' => 'other',
					'message' => 'some message'
				],
				'single' => true
			],
			'live' => [
				'body' => [
					[
                        'channels' => [
                            'private-user-'.$runtime->getSession('appraiser')->get('user.id'),
                            'private-user-'.$runtime->getSession('customer')->get('user.id').'-as-'.$runtime->getSession('appraiser')->get('user.id')
                        ],
						'event' => 'order:decline',
						'data' => new Dynamic(function($data){
							return is_array($data);
						}),
					],
				]
			]
		];
	},
	'getDeclined' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders/'.$capture->get('createOrder2.id')
			],
			'response' => [
				'status' => Response::HTTP_NOT_FOUND
			]
		];
	},

	'validateAcceptWithConditions1' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createOrder3.id').'/accept-with-conditions',
				'body' => [
					'request' => 'fee-increase-and-due-date-extension',
					'fee' => -10.2,
					'dueDate' => (new DateTime('-2 years'))->format(DateTime::ATOM),
					'explanation' => 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
					dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
					ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
					dddddddddddddddd'
				],
			],
			'response' => [
				'errors' => [
					'fee' => [
						'identifier' => 'greater',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},
	'validateAcceptWithConditions2' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createOrder3.id').'/accept-with-conditions',
				'body' => [
					'request' => 'fee-increase',
					'dueDate' => (new DateTime('+2 years'))->format(DateTime::ATOM),
					'explanation' => 'test'
				],
			],
			'response' => [
				'errors' => [
					'fee' => [
						'identifier' => 'required',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},
	'validateAcceptWithConditions3' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createOrder3.id').'/accept-with-conditions',
				'body' => [
					'request' => 'due-date-extension',
					'fee' => 100,
					'explanation' => 'test'
				],
			],
			'response' => [
				'errors' => [
					'dueDate' => [
						'identifier' => 'required',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},
	'validateAcceptWithConditions4' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createOrder3.id').'/accept-with-conditions',
				'body' => [
					'request' => 'other',
				],
			],
			'response' => [
				'errors' => [
					'explanation' => [
						'identifier' => 'required',
						'message' => new Dynamic(Dynamic::STRING),
						'extra' => []
					]
				]
			]
		];
	},
	'acceptWithConditions' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		$dueDate = (new DateTime('+2 years'))->format(DateTime::ATOM);

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createOrder3.id').'/accept-with-conditions',
				'body' => [
					'request' => 'fee-increase-and-due-date-extension',
					'fee' => 100.01,
					'dueDate' => $dueDate,
					'explanation' => 'The project is too large.'
				],
			],
			'push' => [
				'body' => [
					'type' => 'order',
					'event' => 'accept-with-conditions',
					'order' => $capture->get('createOrder3.id'),
					'conditions' => [
						'request' => 'fee-increase-and-due-date-extension',
						'fee' => 100.01,
						'dueDate' => $dueDate,
						'explanation' => 'The project is too large.'
					]
				],
				'single' => true
			],
			'live' => [
				'body' => [
					[
                        'channels' => [
                            'private-user-'.$runtime->getSession('appraiser')->get('user.id'),
                            'private-user-'.$runtime->getSession('customer')->get('user.id').'-as-'.$runtime->getSession('appraiser')->get('user.id')
                        ],
						'event' => 'order:accept-with-conditions',
						'data' => new Dynamic(function($data){
							return is_array($data);
						}),
					],
				]
			]
		];
	},

	'getAcceptedWithConditions' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders/'.$capture->get('createOrder3.id'),
			],
			'response' => [
				'status' => Response::HTTP_NOT_FOUND
			]
		];
	},

	'createBidRequest' => function(Runtime $runtime){
		$customerSession = $runtime->getSession('customer');
		$appraiserSession = $runtime->getSession('appraiser');

		$requestBody = OrdersFixture::getAsBidRequest($runtime->getHelper(), ['client' => 1, 'clientDisplayedOnReport' => 2]);

		return [
			'request' => [
				'url' => 'POST /customers/'
					.$customerSession->get('user.id').'/appraisers/'
					.$appraiserSession->get('user.id').'/orders',
				'auth' => 'customer',
				'body' => $requestBody
			]
		];
	},

	'declineBidRequest' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createBidRequest.id').'/decline',
				'body' => [
					'reason' => 'other',
					'message' => 'some message'
				]
			],
			'push' => [
				'body' => [
					'type' => 'order',
					'event' => 'decline',
					'order' => $capture->get('createBidRequest.id'),
					'reason' => 'other',
					'message' => 'some message'
				],
				'single' => true
			],
			'live' => [
				'body' => [
					[
                        'channels' => [
                            'private-user-'.$runtime->getSession('appraiser')->get('user.id'),
                            'private-user-'.$runtime->getSession('customer')->get('user.id').'-as-'.$runtime->getSession('appraiser')->get('user.id')
                        ],
						'event' => 'order:decline',
						'data' => new Dynamic(function($data){
							return is_array($data);
						}),
					],
				]
			]
		];
	},

	'createPdf:init' => [
		'request' => [
			'url' => 'POST /documents',
			'files' => [
				'document' => __DIR__.'/test.pdf'
			]
		]
	],

	'getTechFeeNotPaid' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders/'.$capture->get('createOrder1.id'),
				'includes' => ['isTechFeePaid']
			],
			'response' => [
				'body' => [
					'id' => new Dynamic(Dynamic::INT),
					'fileNumber' => new Dynamic(Dynamic::STRING),
					'isTechFeePaid' => false
				]
			]
		];
	},

	'tryCompleteOrder1' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder1.id').'/document',
				'body' => [
					'primary' => [
						'id' => $capture->get('createPdf.id'),
						'token' => $capture->get('createPdf.token')
					]
				]
			],
			'response' => [
				'status' => Response::HTTP_BAD_REQUEST
			]
		];
	},
	'payTechFee' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder1.id').'/pay-tech-fee',
			],
			'push' => [
				'body' => [
					'type' => 'order',
					'event' => 'pay-tech-fee',
					'order' => $capture->get('createOrder1.id')
				],
				'single' => true
			]
		];
	},
	'completeOrder1' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder1.id').'/document',
				'body' => [
					'primary' => [
						'id' => $capture->get('createPdf.id'),
						'token' => $capture->get('createPdf.token')
					]
				]
			]
		];
	},
	'payTechFeeAgain' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'.$session->get('user.id').'/orders/'
					.$capture->get('createOrder1.id').'/pay-tech-fee',
			],
			'response' => [
				'status' => Response::HTTP_BAD_REQUEST
			]
		];
	},

	'getTechFeePaid' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'.$session->get('user.id').'/orders/'.$capture->get('createOrder1.id'),
				'includes' => ['isTechFeePaid']
			],
			'response' => [
				'body' => [
					'id' => new Dynamic(Dynamic::INT),
					'fileNumber' => new Dynamic(Dynamic::STRING),
					'isTechFeePaid' => true
				]
			]
		];
	},
];
