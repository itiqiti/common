<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Tests\Form\EventListener\Base;

use Itq\Common\Tests\Form\Base\AbstractFormTestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
abstract class AbstractEventListenerFormTestCase extends AbstractFormTestCase
{
    /**
     * @return EventSubscriberInterface
     */
    public function l()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return $this->o();
    }
}
