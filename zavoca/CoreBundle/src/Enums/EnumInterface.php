<?php


namespace Zavoca\CoreBundle\Enums;


interface EnumInterface
{
    static function getConstants();

    static function getLabel($key);

    static function isExist($key);

    static function getList();
}