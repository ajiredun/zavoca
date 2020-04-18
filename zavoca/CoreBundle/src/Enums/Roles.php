<?php


namespace Zavoca\CoreBundle\Enums;


class Roles extends \App\Enums\Core\Roles
{
    use BaseEnumTrait;


    //BASIC
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_VIEWER = 'ROLE_VIEWER';

    // USER MANAGEMENT
    const ROLE_USER_MANAGEMENT_VIEWER = "ROLE_USER_MANAGEMENT_VIEWER";
    const ROLE_USER_MANAGEMENT_EDITOR = "ROLE_USER_MANAGEMENT_EDITOR";

    // ROLE MANAGEMENT
    const ROLE_ROLES_MANAGEMENT = "ROLE_ROLES_MANAGEMENT";

    //BACK OFFICE SETTINGS
    const ROLE_BO_SETTINGS = "ROLE_BO_SETTINGS";

    //API USER
    const ROLE_API_USER = "ROLE_API_USER";



    static function getList()
    {
        $list =  [
            Roles::ROLE_ADMIN => "Admin" ,
            Roles::ROLE_USER => 'Website User',
            Roles::ROLE_VIEWER => 'Back Office User',
            Roles::ROLE_USER_MANAGEMENT_VIEWER => "User Manager - View Only",
            Roles::ROLE_USER_MANAGEMENT_EDITOR => "User Manager",
            Roles::ROLE_ROLES_MANAGEMENT => "Role Manager",
            Roles::ROLE_BO_SETTINGS => "Back Office Settings",
            Roles::ROLE_API_USER => "Anonymous Web User",
        ];

        return array_merge(parent::getList(),$list);
    }

    static function getConfigurableList()
    {
        $list =  [
            Roles::ROLE_ADMIN => self::getLabel(Roles::ROLE_ADMIN) ,
            Roles::ROLE_VIEWER => self::getLabel(Roles::ROLE_VIEWER),
            Roles::ROLE_USER_MANAGEMENT_EDITOR => self::getLabel(Roles::ROLE_USER_MANAGEMENT_EDITOR),
            Roles::ROLE_ROLES_MANAGEMENT => self::getLabel(Roles::ROLE_ROLES_MANAGEMENT),
            Roles::ROLE_BO_SETTINGS => self::getLabel(Roles::ROLE_BO_SETTINGS),
        ];

        return array_merge(parent::getConfigurableList(),$list);
    }

    static function getFOList()
    {
        $list = [
            Roles::ROLE_USER => self::getLabel(Roles::ROLE_USER)
        ];

        return array_merge(parent::getFOList(),$list);
    }

    static function getFOListForm()
    {
        return array_flip(Roles::getFOList());
    }
}