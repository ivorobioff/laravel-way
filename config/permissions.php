<?php
return [
    'protectors' => [
        'all' => RealEstate\Api\Shared\Protectors\AllProtector::class,
        'auth' => RealEstate\Api\Shared\Protectors\AuthProtector::class,
        'guest' => RealEstate\Api\Shared\Protectors\GuestProtector::class,
        'owner' => RealEstate\Api\Shared\Protectors\OwnerProtector::class,
        'admin' => RealEstate\Api\Shared\Protectors\AdminProtector::class,
    ]
];
