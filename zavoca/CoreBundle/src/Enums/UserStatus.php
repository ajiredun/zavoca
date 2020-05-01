<?php


namespace Zavoca\CoreBundle\Enums;

class UserStatus extends \App\Enums\Core\UserStatus
{

    const INACTIVE = 'inactive';
    const ACTIVE = 'active';
    const BLOCKED = 'blocked';
    const ARCHIVED = 'archived';

    static function getList()
    {
        $list = [
            UserStatus::INACTIVE => 'Inactive',
            UserStatus::ACTIVE => 'Active',
            UserStatus::BLOCKED => 'Blocked',
            UserStatus::ARCHIVED => 'Archived'
        ];

        return array_merge(parent::getList(),$list);
    }

    static function getClass()
    {
        $list = [
            UserStatus::INACTIVE => 'primary',
            UserStatus::ACTIVE => 'success',
            UserStatus::BLOCKED => 'danger',
            UserStatus::ARCHIVED => 'warning'
        ];

        return array_merge(parent::getList(),$list);
    }

    static function getClassByKey($key)
    {
        $class = static::getClass();
        if (array_key_exists($key, $class)) {
            return $class[$key];
        }
        return '';
    }
}