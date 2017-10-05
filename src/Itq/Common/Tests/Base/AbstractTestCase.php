<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Tests\Base;

use StdClass;

use Exception;
use ReflectionClass;
use ReflectionMethod;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
abstract class AbstractTestCase extends AbstractBasicTestCase
{
    /**
     * @var object
     */
    protected $o;
    /**
     * @return array
     */
    public function constructor()
    {
        return [];
    }
    /**
     *
     */
    public function setUp()
    {
        $this->setObject($this->instantiate());

        $this->initializer();
    }
    /**
     *
     */
    public function initializer()
    {
    }
    /**
     * @return object
     */
    public function o()
    {
        return $this->getObject();
    }
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $this->assertNotNull($this->o());
    }
    /**
     * @param object $object
     *
     * @return $this
     */
    protected function setObject($object)
    {
        $this->o = $object;

        return $this;
    }
    /**
     * @return object
     */
    protected function getObject()
    {
        $this->checkObjectExist();

        return $this->o;
    }
    /**
     * @return $this
     *
     * @throws Exception
     */
    protected function checkObjectExist()
    {
        if (!$this->hasObject()) {
            throw $this->createRequiredException('[Test] No object set');
        }

        return $this;
    }
    /**
     * @return bool
     */
    protected function hasObject()
    {
        return isset($this->o);
    }
    /**
     * @param null|array $args
     *
     * @return object
     */
    protected function instantiate($args = null)
    {
        $rClass = new ReflectionClass($this->getObjectClass());

        return $rClass->newInstanceArgs($args ?: $this->getConstructorArguments());
    }
    /**
     * @return string
     */
    protected function getObjectClass()
    {
        return preg_replace('/Test$/', '', preg_replace('/Tests\\\/', '', get_class($this)));
    }
    /**
     * @return array
     */
    protected function getConstructorArguments()
    {
        return $this->constructor();
    }
    /**
     * @param mixed  $object
     * @param string $method
     *
     * @return ReflectionMethod
     */
    protected function accessible($object, $method)
    {
        $method = new ReflectionMethod(get_class($object), $method);
        $method->setAccessible(true);

        return $method;
    }
}
