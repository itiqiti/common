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

use Itq\Common\Service\VolatileSubDocumentService;
use Itq\Common\Tests\Service\Base\AbstractServiceTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group services
 * @group services/volatile-sub-document
 */
class VolatileSubDocumentServiceTest extends AbstractServiceTestCase
{
    /**
     * @return VolatileSubDocumentService
     */
    public function s()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::s();
    }
    /**
     * @group unit
     * @group document
     */
    public function testGetTypes()
    {
        $this->s()->setTypes(['a', 'b']);
        $this->assertEquals(['a', 'b'], $this->s()->getTypes());
    }
    /**
     * @group unit
     * @group document
     */
    public function testFullType()
    {
        $this->s()->setTypes(['a', 'b']);
        $this->assertEquals('a.b', $this->s()->getFullType());

        $this->s()->setTypes(['a', 'b']);
        $this->assertEquals('a b', $this->s()->getFullType(' '));
    }
    /**
     * @group unit
     */
    public function testSaveCreate()
    {
        $m = $this->accessible($this->s(), 'saveCreate');
        $m->invoke($this->s(), 'parent_id', []);
    }
    /**
     * @group unit
     */
    public function testSaveCreateBulk()
    {
        $bulk = [
            [
                'id_1' => 'obj1',
            ]
        ];

        $m = $this->accessible($this->s(), 'saveCreateBulk');
        $this->assertEquals($bulk, $m->invoke($this->s(), 'parent_id', $bulk));
    }
    /**
     * @group unit
     */
    public function testPushCreateBulk()
    {
        $reference = [];
        $m = $this->accessible($this->s(), 'pushCreateInBulk');
        $m->invokeArgs($this->s(),  [&$reference, []]);
    }
}
