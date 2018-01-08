<?php

namespace Swoft\Http\Server\Bean;

use Swoft\Bean\CollectorInterface;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;

/**
 * the collector of controller
 *
 * @uses      ControllerCollector
 * @version   2018年01月07日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class ControllerCollector implements CollectorInterface
{
    /**
     * @var array
     */
    private static $requestMapping = [];

    /**
     * @param string $className
     * @param object   $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null   $propertyValue
     */
    public static function collect(string $className, $objectAnnotation = null, string $propertyName = "", string $methodName = "", $propertyValue = null)
    {
        if($objectAnnotation instanceof Controller){
            $prefix = $objectAnnotation->getPrefix();
            self::$requestMapping[$className]['prefix'] = $prefix;
            return ;
        }

        if($objectAnnotation instanceof RequestMapping){
            $route = $objectAnnotation->getRoute();
            $httpMethod = $objectAnnotation->getMethod();
            self::$requestMapping[$className]['routes'][] = [
                'route'  => $route,
                'method' => $httpMethod,
                'action' => $methodName
            ];
            return ;
        }
    }

    /**
     * @return array
     */
    public static function getCollector()
    {
        return self::$requestMapping;
    }

}