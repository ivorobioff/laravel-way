<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

use RealEstate\Tests\Integrations\Support\Runtime\Runtime;
use Restate\QA\Integrations\Checkers\Dynamic;
use RealEstate\Core\User\Enums\Status;

$amc = uniqid('amc');

return [
    'createAmc:init' => [
        'request' => [
            'url' => 'POST /amcs',
            'auth' => 'guest',
            'body' => [
                'username' => $amc,
                'password' => 'password',
                'email' => 'bestamc@ever.org',
                'companyName' => 'Best AMC Ever!',
                'address1' => '123 Wall Str.',
                'address2' => '124B Wall Str.',
                'city' => 'New York',
                'zip' => '44211',
                'state' => 'NY',
                'lenders' => 'VMX, TTT, abc',
                'phone' => '(423) 553-1211',
                'fax' => '(423) 553-1212'
            ]
        ],
    ],

    'approveAmc:init' => function(Runtime $runtime){
        return [
            'request' => [
                'url' => 'PATCH /amcs/'.$runtime->getCapture()->get('createAmc.id'),
                'auth' => 'admin',
                'body' => [
                    'status' => Status::APPROVED
                ]
            ]
        ];
    },

    'signinAmc:init' => [
        'request' => [
            'url' => 'POST /sessions',
            'body' => [
                'username' => $amc,
                'password' => 'password'
            ]
        ]
    ],


    'syncFee:init' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $capture = $runtime->getCapture();

        return [
            'request' => [
                'url' => 'PUT /amcs/'.$amc['id'].'/fees',
                'auth' => 'guest',
                'headers' => [
                    'token' => $capture->get('signinAmc.token')
                ],
                'body' => [
                    'data' => [
                        [
                            'jobType' => 1,
                            'amount' => 100,
                        ],
                        [
                            'jobType' => 2,
                            'amount' => 56,
                        ],
                    ]
                ]
            ],
        ];
    },

    'validate1' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'PUT /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/NV/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
                'body' => [
                    'data' => [
                        [
                            'county' => $runtime->getHelper()->county('CLARK', 'NV'),
                            'amount' => -12,
                        ]
                    ]
                ]
            ],
            'response' => [
                'errors' => [
                    'data' => [
                        'identifier' => 'collection',
                        'message' => new Dynamic(Dynamic::STRING),
                        'extra' => [
                            [
                                'identifier' => 'dataset',
                                'message' => new Dynamic(Dynamic::STRING),
                                'extra' => [
                                    'amount' => [
                                        'identifier' => 'greater',
                                        'message' => new Dynamic(Dynamic::STRING),
                                        'extra' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    },

    'validate2' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'PUT /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/NV/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
                'body' => [
                    'data' => [
                       [
                            'county' => $runtime->getHelper()->county('CLARK', 'NV'),
                            'amount' => 55,
                       ],
                        [
                            'county' => $runtime->getHelper()->county('ORANGE', 'CA'),
                            'amount' => 100,
                        ]
                    ]
                ]
            ],
            'response' => [
                'errors' => [
                    'data' => [
                        'identifier' => 'exists',
                        'message' => new Dynamic(Dynamic::STRING),
                        'extra' => []
                    ]
                ]
            ]
        ];
    },

    'validate3' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'PUT /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/NV/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
                'body' => [
                    'data' => [
                        [
                            'county' => $runtime->getHelper()->county('CLARK', 'NV'),
                            'amount' => 55,
                        ],
                        [
                            'county' => $runtime->getHelper()->county('CLARK', 'NV'),
                            'amount' => 5555,
                        ],
                    ]
                ]
            ],
            'response' => [
                'errors' => [
                    'data' => [
                        'identifier' => 'unique',
                        'message' => new Dynamic(Dynamic::STRING),
                        'extra' => []
                    ]
                ]
            ]
        ];
    },

    'sync1' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'PUT /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/CA/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
                'body' => [
                    'data' => [
                        [
                            'county' => $runtime->getHelper()->county('ORANGE', 'CA'),
                            'amount' => 100,
                        ],
                        [
                            'county' => $runtime->getHelper()->county('CALAVERAS', 'CA'),
                            'amount' => 56,
                        ],
                    ]
                ]
            ],
            'response' => [
                'body' => [
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'ORANGE'
                        ],
                        'amount' => 100,
                    ],
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'CALAVERAS'
                        ],
                        'amount' => 56,
                    ],
                ]
            ]
        ];
    },

    'sync2' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'PUT /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/TX/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
                'body' => [
                    'data' => [
                        [
                            'county' => $runtime->getHelper()->county('ELLIS', 'TX'),
                            'amount' => 100,
                        ],
                        [
                            'county' => $runtime->getHelper()->county('DALLAS', 'TX'),
                            'amount' => 56,
                        ],
                    ]
                ]
            ],
            'response' => [
                'body' => [
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'ELLIS'
                        ],
                        'amount' => 100,
                    ],
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'DALLAS'
                        ],
                        'amount' => 56,
                    ],
                ]
            ]
        ];
    },
    'syncForeign' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.1');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'PUT /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/CA/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
                'body' => [
                    'data' => [
                        [
                            'county' => $runtime->getHelper()->county('SAN FRANCISCO', 'CA'),
                            'amount' => 100,
                        ],
                    ]
                ]
            ]
        ];
    },

    'getAll1' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'GET /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/CA/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
            ],
            'response' => [
                'body' => [
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'ORANGE'
                        ],
                        'amount' => 100,
                    ],
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'CALAVERAS'
                        ],
                        'amount' => 56,
                    ],
                ]
            ]
        ];
    },

    'getAll2' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'GET /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/TX/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
            ],
            'response' => [
                'body' => [
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'ELLIS'
                        ],
                        'amount' => 100,
                    ],
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'DALLAS'
                        ],
                        'amount' => 56,
                    ],
                ]
            ]
        ];
    },

    'sync3' => function(Runtime $runtime) {
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'PUT /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/TX/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
                'body' => [
                    'data' => [
                        [
                            'county' => $runtime->getHelper()->county('DALLAS', 'TX'),
                            'amount' => 552,
                        ],
                    ]
                ]
            ]
        ];
    },
    'getAll3' => function(Runtime $runtime){
        $amc = $runtime->getCapture()->get('createAmc');
        $fee = $runtime->getCapture()->get('syncFee.0');
        $session = $runtime->getCapture()->get('signinAmc');

        return [
            'request' => [
                'url' => 'GET /amcs/'.$amc['id'].'/fees/'.$fee['jobType']['id'].'/states/TX/counties',
                'auth' => 'guest',
                'headers' => [
                    'token' => $session['token']
                ],
            ],
            'response' => [
                'body' => [
                    [
                        'county' => [
                            'id' => new Dynamic(Dynamic::INT),
                            'title' => 'DALLAS'
                        ],
                        'amount' => 552,
                    ],
                ]
            ]
        ];
    },
];