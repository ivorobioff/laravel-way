<?php
use RealEstate\Tests\Integrations\Support\Runtime\Runtime;
use RealEstate\Tests\Integrations\Fixtures\OrdersFixture;
use RealEstate\Tests\Integrations\Support\Filters\MessageAndExtraFilter;
use Restate\QA\Support\Response;
use Restate\QA\Integrations\Checkers\Dynamic;

return [
	'createOrder:init' => function(Runtime $runtime){
		$customerSession = $runtime->getSession('customer');
		$appraiserSession = $runtime->getSession('appraiser');

		return [
			'request' => [
				'url' => 'POST /customers/'
					.$customerSession->get('user.id').'/appraisers/'
					.$appraiserSession->get('user.id').'/orders',
				'auth' => 'customer',
				'body' => OrdersFixture::get($runtime->getHelper(), ['client' => 1, 'clientDisplayedOnReport' => 2])
			]
		];
	},

	'createBidRequest:init' => function(Runtime $runtime){
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
	'validateRequired' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createBidRequest.id').'/bid',
				'body' => [
					'comments' => 'test message'
				]
			],
			'response' => [
				'errors' => [
					'amount' => [
						'identifier' => 'required',
					],
					'estimatedCompletionDate' => [
						'identifier' => 'required',
					]
				],
				'filter' => new MessageAndExtraFilter()
			]
		];
	},
	'validate' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		$ecd = (new DateTime('-1 month'))->format(DateTime::ATOM);

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createBidRequest.id').'/bid',
				'body' => [
					'amount' => -10,
					'estimatedCompletionDate' => $ecd,
					'comments' => 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
					dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
					ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
					dddddddddddddddd'
				]
			],
			'response' => [
				'errors' => [
					'amount' => [
						'identifier' => 'greater',
					],
					'estimatedCompletionDate' => [
						'identifier' => 'greater',
					],
					'comments' => [
						'identifier' => 'length'
					]
				],
				'filter' => new MessageAndExtraFilter()
			]
		];
	},
	'tryCreateWithWrongOrder' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createOrder.id').'/bid',
				'body' => [
					'amount' => 1000,
					'estimatedCompletionDate' => (new DateTime('+1 month'))->format(DateTime::ATOM),
					'comments' => 'Some comments'
				]
			],
			'response' => [
				'status' => Response::HTTP_BAD_REQUEST
			]
		];
	},
	'create' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		$ecd = (new DateTime('+1 month'))->format(DateTime::ATOM);

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createBidRequest.id').'/bid',
				'body' => [
					'amount' => 1000,
					'estimatedCompletionDate' => $ecd,
					'comments' => 'Some comments'
				]
			],
			'response' => [
				'body' => [
					'amount' => 1000,
					'estimatedCompletionDate' => $ecd,
					'comments' => 'Some comments'
				]
			],
			'push' => [
				'body' => [
					'type' => 'order',
					'event' => 'submit-bid',
					'order' => $capture->get('createBidRequest.id')
				],
				'single' => true
			]
		];
	},
	'get' => function(Runtime $runtime) {
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		return [
			'request' => [
				'url' => 'GET /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createBidRequest.id').'/bid',
			],
			'response' => [
				'body' => [
					'amount' => 1000,
					'estimatedCompletionDate' => new Dynamic(Dynamic::DATETIME),
					'comments' => 'Some comments'
				]
			]
		];
	},
	'tryCreateAgain' => function(Runtime $runtime){
		$session = $runtime->getSession('appraiser');
		$capture = $runtime->getCapture();

		$ecd = (new DateTime('+1 month'))->format(DateTime::ATOM);

		return [
			'request' => [
				'url' => 'POST /appraisers/'
					.$session->get('user.id').'/orders/'
					.$capture->get('createBidRequest.id').'/bid',
				'body' => [
					'amount' => 1000,
					'estimatedCompletionDate' => $ecd,
					'comments' => 'Some comments'
				]
			],
			'response' => [
				'status' => Response::HTTP_BAD_REQUEST
			]
		];
	},
];