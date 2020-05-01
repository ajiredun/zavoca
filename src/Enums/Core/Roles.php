<?php

namespace App\Enums\Core;

use Zavoca\CoreBundle\Enums\BaseEnumTrait;
use Zavoca\CoreBundle\Enums\Roles as ZavocaRoles;

class Roles
{

    use BaseEnumTrait;

    const ROLE_OVERRIDE = 'ROLE_OVERRIDE';

    static function getList()
    {
        return [
            self::ROLE_OVERRIDE => "Override Label" ,
        ];
    }

    static function getConfigurableList()
    {
        return [
            Roles::ROLE_OVERRIDE => ZavocaRoles::getLabel(self::ROLE_OVERRIDE),
        ];
    }

    static function getFOList()
    {
        return [
            Roles::ROLE_OVERRIDE => ZavocaRoles::getLabel(self::ROLE_OVERRIDE),
        ];
    }
}