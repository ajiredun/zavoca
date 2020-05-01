<?php


namespace Zavoca\CoreBundle\Enums;


class Boolean
{
    const YES = 1;
    const NO = 0;
    
    
    static function getList()
    {
        $list = [
            Boolean::YES => 'Yes',
            Boolean::NO => 'No',
        ];

        return $list;
    }

    static function getFOList()
    {
        return array_flip(Boolean::getList());
    }
}