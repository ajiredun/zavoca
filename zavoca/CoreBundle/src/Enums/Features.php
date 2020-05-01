<?php


namespace Zavoca\CoreBundle\Enums;


class Features extends \App\Enums\Core\Features
{

    const USER_AUTH_FORGET_PASSWORD = 'USER_AUTH_FORGET_PASSWORD';
    const USER_AUTH_ACCOUNT_CREATION = 'USER_AUTH_ACCOUNT_CREATION';
    const USER_AUTH_LOGIN = 'USER_AUTH_LOGIN';

    static function getList()
    {
        $list = [
            Features::USER_AUTH_FORGET_PASSWORD => 'Password Management',
            Features::USER_AUTH_ACCOUNT_CREATION => 'Account Management',
            Features::USER_AUTH_LOGIN => 'User Login',
        ];

        return array_merge(parent::getList(),$list);
    }

    static function getCategories()
    {
        $list = [
            'USER_AUTH' => [
                'label' => 'User Account/Login Management',
                'features' => [
                    Features::USER_AUTH_ACCOUNT_CREATION,
                    Features::USER_AUTH_FORGET_PASSWORD,
                    Features::USER_AUTH_LOGIN,
                ]
            ],
        ];

        return array_merge(parent::getCategories(),$list);
    }
}