<?php


namespace Zavoca\CoreBundle\Enums;


class Modules extends \App\Enums\Core\Modules
{
    use BaseEnumTrait;

    const USER_AUTH = 'USER_AUTH';
    const ROLES_MANAGEMENT = 'ROLES_MANAGEMENT';


    static function getList()
    {
        $list = [
            Modules::USER_AUTH => 'Login, Password and Account Management',
            Modules::ROLES_MANAGEMENT => 'Roles Management',
        ];

        return array_merge(parent::getList(),$list);
    }
}