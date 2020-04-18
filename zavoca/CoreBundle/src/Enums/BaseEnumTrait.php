<?php

namespace Zavoca\CoreBundle\Enums;

trait BaseEnumTrait {
    static function getConstants()
    {
        return array_keys(self::getList());
    }

    static function getLabel($key)
    {
        $list = self::getList();
        if (array_key_exists($key, $list)) {
            return $list[$key];
        }
        return '';
    }

    static function isExist($key)
    {
        $list = self::getList();
        if (array_key_exists($key, $list)) {
            return true;
        }
        return false;
    }
}