<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Plugin\TagProcessor;

use Itq\Common\Plugin\TagProcessor\ProviderNotificationModeTagProcessor;
use Itq\Common\Tests\Plugin\TagProcessor\Base\AbstractTagProcessorTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group plugins
 * @group plugins/processors
 * @group plugins/processors/tags
 * @group plugins/processors/tags/provider-notification-mode
 */
class ProviderNotificationModeTagProcessorTest extends AbstractTagProcessorTestCase
{
    /**
     * @return ProviderNotificationModeTagProcessor
     */
    public function p()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::p();
    }
}
