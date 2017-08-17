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

use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
abstract class AbstractBundleTestCase extends AbstractTestCase
{
    /**
     * @return BundleInterface
     */
    public function b()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::o();
    }
}