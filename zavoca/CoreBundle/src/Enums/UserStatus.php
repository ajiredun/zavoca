<?php


namespace Zavoca\CoreBundle\Enums;

class UserStatus extends \App\Enums\Core\UserStatus
{
    use BaseEnumTrait;


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
}