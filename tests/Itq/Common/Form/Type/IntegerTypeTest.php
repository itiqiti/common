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

use Itq\Common\Form\Type\IntegerType;
use Itq\Common\Tests\Form\Type\Base\AbstractTypeFormTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group forms
 * @group forms/types
 * @group forms/types/integer
 */
class IntegerTypeTest extends AbstractTypeFormTestCase
{
    /**
     * @return IntegerType
     */
    public function t()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::t();
    }
    /**
     * @group unit
     */
    public function testGetName()
    {
        $this->assertEquals('app_integer', $this->t()->getName());
    }
}
