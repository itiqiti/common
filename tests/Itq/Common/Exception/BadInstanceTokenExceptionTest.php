<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Exception;

use Itq\Common\Exception\BadInstanceTokenException;
use Itq\Common\Tests\Exception\Base\AbstractExceptionTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group exceptions
 * @group exceptions/bad-instance-token
 */
class BadInstanceTokenExceptionTest extends AbstractExceptionTestCase
{
    /**
     * @return BadInstanceTokenException
     */
    public function e()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::e();
    }
    /**
     * @return array
     */
    public function constructor()
    {
        return [];
    }
    /**
     * @group unit
     */
    public function testGetters()
    {
        $this->assertEquals('Instance re-authentication required', $this->e()->getMessage());
        $this->assertEquals(401, $this->e()->getCode());
    }
}
