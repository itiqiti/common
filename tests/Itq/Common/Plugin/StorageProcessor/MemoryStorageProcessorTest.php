<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Plugin\StorageProcessor;

use Itq\Common\Plugin\StorageProcessor\MemoryStorageProcessor;
use Itq\Common\Tests\Plugin\StorageProcessor\Base\AbstractStorageProcessorTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group plugins
 * @group plugins/processors
 * @group plugins/processors/storages
 * @group plugins/processors/storages/memory
 */
class MemoryStorageProcessorTest extends AbstractStorageProcessorTestCase
{
    /**
     * @return MemoryStorageProcessor
     */
    public function p()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::p();
    }
}
