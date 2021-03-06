<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Form\Type;

use Symfony\Component\Form\Forms;
use Itq\Common\Form\Type\BooleanType;
use Symfony\Component\Form\FormBuilder;
use Itq\Common\Tests\Form\Type\Base\AbstractTypeFormTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group forms
 * @group forms/types
 * @group forms/types/boolean
 */
class BooleanTypeTest extends AbstractTypeFormTestCase
{
    /**
     * @return BooleanType
     */
    public function t()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::t();
    }
    /**
     *
     */
    public function initializer()
    {
        $this->mocked('factory', Forms::createFormFactoryBuilder()->addExtensions([])->getFormFactory());
        $this->mockedEventDispatcher();
        $this->mocked('builder', new FormBuilder(null, null, $this->mockedEventDispatcher(), $this->mocked('factory')));
    }
    /**
     * @param mixed $value
     * @param mixed $expected
     *
     * @group unit
     * @dataProvider getTestData
     */
    public function testFormType($value, $expected)
    {
        $form = $this->mocked('factory')->create($this->getObjectClass());
        $form->submit($value);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $form->getData());
    }
    /**
     * @return array
     */
    public function getTestData()
    {
        return [
            ['1', true],
            [1, true],
            [true, true],
            ['0', false],
            [0, false],
            [false, false],
            ['yes', false],
            ['no', false],
            [null, null],
        ];
    }
    /**
     * @group unit
     */
    public function testGetName()
    {
        $this->assertEquals('app_boolean', $this->t()->getName());
    }
}
