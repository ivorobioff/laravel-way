<?php
return [
    'db' => env('DOCTRINE_DB', 'default'),

    'connections' => [
        'default' => [
            'driver' => 'pdo_mysql',
            'user' => env('DOCTRINE_DEFAULT_USER'),
            'password' => env('DOCTRINE_DEFAULT_PASSWORD'),
            'dbname' => env('DOCTRINE_DEFAULT_DBNAME'),
			'charset' => 'utf8',
            'host' => env('DOCTRINE_DEFAULT_HOST')
        ],
        'lite' => [
            'driver' => 'pdo_sqlite',
            'path' => storage_path(env('DOCTRINE_LITE_PATH'))
        ]
    ],

    'cache' => env('APP_DEBUG', false)
        ? Doctrine\Common\Cache\ArrayCache::class
        : Doctrine\Common\Cache\ApcuCache::class,

    'proxy' => [
        'auto' => env('APP_DEBUG', false)
            ? Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_ALWAYS
            : Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_NEVER,
        'dir' => storage_path('proxies'),
        'namespace' => 'RealEstate\Temp\Proxies'
    ],
    'migrations' => [
        'dir' => database_path('migrations'),
        'namespace' => 'RealEstate\Migrations',
        'table' => 'doctrine_migrations'
    ],
	'entities' => [
        RealEstate\DAL\Location\Support\Place::class =>
            RealEstate\DAL\Location\Support\PlaceMetadata::class,

        RealEstate\Letter\Support\Frequency::class =>
            RealEstate\Letter\Support\FrequencyMetadata::class,

        RealEstate\Support\Chance\Attempt::class =>
            RealEstate\Support\Chance\AttemptMetadata::class,

        RealEstate\Push\Support\Story::class =>
            RealEstate\Push\Support\StoryMetadata::class
	],

    'types' => [
        RealEstate\DAL\Location\Support\ErrorType::class
    ]
];
