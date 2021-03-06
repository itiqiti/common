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

use Itq\Common\Service\CollectionService;
use Itq\Common\Tests\Service\Base\AbstractServiceTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group services
 * @group services/collection
 */
class CollectionServiceTest extends AbstractServiceTestCase
{
    /**
     * @return CollectionService
     */
    public function s()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::s();
    }
    /**
     * @return array
     */
    public function constructor()
    {
        return [$this->mockedCriteriumService()];
    }
    /**
     * @group integ
     *
     * @dataProvider getFilterDataProvider
     *
     * @param array $items
     * @param array $criteria
     * @param array $builtCriteria
     * @param array $expectedItemKeys
     */
    public function testFilter($items, $criteria, $builtCriteria, $expectedItemKeys)
    {
        $this->mockedCriteriumService()
            ->expects($this->once())->method('buildSetQuery')
            ->with('collection', $criteria)
            ->willReturn($builtCriteria)
        ;

        $this->s()->filter($items, $criteria);

        $this->assertEquals($expectedItemKeys, array_keys($items));
    }
    /**
     * @group unit
     *
     * @dataProvider getFilterFieldsDataProvider
     *
     * @param array $items
     * @param array $criteria
     * @param array $builtCriteria
     * @param array $fields
     * @param array $expectedItems
     */
    public function testFilterFields($items, $criteria, $builtCriteria, $fields, $expectedItems)
    {
        $this->mockedCriteriumService()
            ->expects($this->once())->method('buildSetQuery')
            ->with('collection', $criteria)
            ->willReturn($builtCriteria)
        ;

        $this->s()->filter($items, $criteria, $fields);

        $this->assertEquals($expectedItems, $items);
    }
    /**
     * @return array
     */
    public function getFilterDataProvider()
    {
        return [
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['a' => 1],
                ['value' => ['a' => 1]],
                ['x', 'y'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['b' => 1],
                ['value' => ['b' => 1]],
                [],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['b' => 2],
                ['value' => ['b' => 2]],
                ['x', 'z'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['a' => 1, 'b' => 2],
                ['value' => ['a' => 1, 'b' => 2]],
                ['x'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['a' => '*notempty*'],
                ['exists' => ['a' => true]],
                ['x', 'y', 'z'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['c' => 2, 'b' => 2]],
                ['c' => '*empty*'],
                ['exists' => ['c' => false]],
                ['x', 'y'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['c' => 2, 'b' => 2]],
                ['a' => '*eq_int*:1'],
                ['equals_int' => ['a' => 1]],
                ['x', 'y'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['c' => 2, 'b' => 2]],
                ['a' => '*not_int*:1'],
                ['different_int' => ['a' => 1]],
                ['z'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['c' => 2, 'b' => 2]],
                ['b' => '*lt*:3'],
                ['less_than' => ['b' => (float) 3, ]],
                ['x', 'z'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['c' => 2, 'b' => 2]],
                ['b' => '*lte*:2'],
                ['less_than_equals' => ['b' => (float) 2, ]],
                ['x', 'z'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['c' => 2, 'b' => 2]],
                ['b' => '*gt*:2'],
                ['greater_than' => ['b' => (float) 2]],
                ['y'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['c' => 2, 'b' => 2]],
                ['b' => '*gte*:3'],
                ['greater_than_equals' => ['b' => (float) 3]],
                ['y'],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['c' => 2, 'b' => 2]],
                ['b' => '*gte*:3', 'a' => '*gt*:1'],
                ['greater_than' => ['b' => (float) 3], 'greater_than_equals' => ['a' => (float) 1]],
                [],
            ],
        ];
    }
    /**
     * @return array
     */
    public function getFilterFieldsDataProvider()
    {
        return [
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['a' => 1],
                ['value' => ['a' => 1]],
                [],
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3]],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['a' => 1],
                ['value' => ['a' => 1]],
                ['a', 'b'],
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3]],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['a' => 1],
                ['value' => ['a' => 1]],
                ['a'],
                ['x' => ['a' => 1], 'y' => ['a' => 1]],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['a' => 1],
                ['value' => ['a' => 1]],
                ['a' => true, 'b' => true],
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3]],
            ],
            [
                ['x' => ['a' => 1, 'b' => 2], 'y' => ['a' => 1, 'b' => 3], 'z' => ['a' => 2, 'b' => 2]],
                ['a' => 1],
                ['value' => ['a' => 1]],
                ['a' => true],
                ['x' => ['a' => 1], 'y' => ['a' => 1]],
            ],
        ];
    }
}
