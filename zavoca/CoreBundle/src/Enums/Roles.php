<?php


namespace Zavoca\CoreBundle\Enums;


class Roles
{
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


    static function getLabel($role)
    {
        $list = Roles::getList();
        if (array_key_exists($role, $list)) {
            return $list[$role];
        }
        return '';
    }

    static function roleExist($role)
    {
        $list = Roles::getList();
        if (array_key_exists($role, $list)) {
            return true;
        }
        return false;
    }

    static function getList()
    {
        return [
            Roles::ROLE_ADMIN => "Admin" ,
            Roles::ROLE_USER => 'Website User',
            Roles::ROLE_VIEWER => 'Back Office User',
            Roles::ROLE_USER_MANAGEMENT_VIEWER => "User Manager - View Only",
            Roles::ROLE_USER_MANAGEMENT_EDITOR => "User Manager",
            Roles::ROLE_ROLES_MANAGEMENT => "Role Manager",
            Roles::ROLE_BO_SETTINGS => "Back Office Settings",
            Roles::ROLE_API_USER => "Anonymous Web User",
        ];
    }

    static function getConfigurableList()
    {
        return [
            Roles::ROLE_ADMIN => "Admin" ,
            Roles::ROLE_VIEWER => 'Back Office User',
            Roles::ROLE_USER_MANAGEMENT_EDITOR => "User Manager",
            Roles::ROLE_ROLES_MANAGEMENT => "Role Manager",
            Roles::ROLE_BO_SETTINGS => "Back Office Settings",
        ];
    }

    static function getFOList()
    {
        return [
            Roles::ROLE_USER => 'Website User'
        ];
    }

    static function getFOListForm()
    {
        return array_flip(Roles::getFOList());
    }
}