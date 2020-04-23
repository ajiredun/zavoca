<?php


namespace Zavoca\CoreBundle\Utils;


class ZavocaUtil
{

    static function generateCodeByClass($class)
    {
        return str_replace('\\','_',$class);
    }

    static function generateParameterNameByObject($object, $parameterName)
    {
        $class = get_class($object);
        $className = ZavocaUtil::generateCodeByClass($class);
        if (!is_null($parameterName)) {
            $className = $className.".".$parameterName;
        }

        return $className;
    }

    static function generateParameterNameByString($className, $parameterName)
    {
        $className = ZavocaUtil::generateCodeByClass($className);
        if (!is_null($parameterName)) {
            $className = $className.".".$parameterName;
        }

        return $className;
    }
}