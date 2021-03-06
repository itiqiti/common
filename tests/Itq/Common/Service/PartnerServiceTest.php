<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Service;

use Itq\Common\Service;
use Itq\Common\Tests\Service\Base\AbstractServiceTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group services
 * @group services/partner
 */
class PartnerServiceTest extends AbstractServiceTestCase
{
    /**
     * @return Service\PartnerService
     */
    public function s()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::s();
    }
    /**
     * @group unit
     */
    public function testRegister()
    {
        $testPartner = $this->getMockBuilder('stdClass')->getMock();

        $this->s()->registerType('a');

        $this->s()->register('a', 'test', $testPartner);

        $this->assertEquals(['service' => $testPartner], $this->s()->getByType('a', 'test'));
    }
    /**
     * @group unit
     */
    public function testExecuteOperation()
    {
        $testPartner = $this->getMockBuilder('Tests\\Itq\\Common\\Plugin\\Partner\\TestPartnerInterface')->setMethods(['operation1'])->getMock();
        $testPartner->method('operation1')->willReturn(27);

        $this->s()->registerType('b');

        $this->s()->register('b', 'test2', $testPartner);

        $this->assertEquals(27, $this->s()->executeOperation('b', 'test2', 'operation1'));
    }
    /**
     * @group unit
     */
    public function testExecuteOperationThrowExceptionIfOperationNotSupported()
    {
        $testPartner = $this->getMockBuilder('stdClass')->getMock();

        $this->s()->registerType('b');

        $this->s()->register('b', 'test2', $testPartner);

        $this->setExpectedException('RuntimeException', "Operation 'operation1' is not provided by b partner 'test2'", 412);

        $this->s()->executeOperation('b', 'test2', 'operation1');
    }
}
