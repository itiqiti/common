<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Traits\ServiceAware;

use Itq\Common\Traits\ServiceAware\ActionServiceAwareTrait;
use Itq\Common\Tests\Traits\ServiceAware\Base\AbstractServiceAwareTraitTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group traits
 * @group traits/service-aware
 * @group traits/service-aware/action
 */
class ActionServiceAwareTraitTest extends AbstractServiceAwareTraitTestCase
{
    /**
     * @return ActionServiceAwareTrait
     */
    public function t()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::t();
    }
}
