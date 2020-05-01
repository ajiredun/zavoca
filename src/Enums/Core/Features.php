<?php


namespace App\Enums\Core;

use Zavoca\CoreBundle\Enums\BaseEnumTrait;
use Zavoca\CoreBundle\Enums\EnumInterface;
use Zavoca\CoreBundle\Enums\Features as ZavocaFeatures;

class Features implements EnumInterface
{
    use BaseEnumTrait;


    static function getList()
    {
        $list = [];

        return $list;
    }

    static function getCategories()
    {
        $list = [];

        return $list;
    }

}