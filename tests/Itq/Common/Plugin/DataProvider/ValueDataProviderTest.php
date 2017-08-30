<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Plugin\DataProvider;

use Itq\Common\Plugin\DataProvider\ValueDataProvider;
use Itq\Common\Tests\Plugin\DataProvider\Base\AbstractDataProviderTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group plugins
 * @group plugins/data-providers
 * @group plugins/data-providers/value
 */
class ValueDataProviderTest extends AbstractDataProviderTestCase
{
    /**
     * @return ValueDataProvider
     */
    public function p()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::p();
    }
    /**
     * @return array
     */
    public function constructor()
    {
        return [];
    }
}
