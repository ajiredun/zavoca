<?php


namespace App\Enums\Core;

use Zavoca\CoreBundle\Enums\BaseEnumTrait;
use Zavoca\CoreBundle\Enums\UserStatus as ZavocaUserStatus;

class UserStatus
{
    use BaseEnumTrait;

    static function getList()
    {
        $list = [];

        return $list;
    }

    static function getClass()
    {
        $class = [];

        return $class;
    }
}