<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Service\Model;

use Itq\Common\Plugin;
use Itq\Common\Service\Model\ModelRefresherService;
use Itq\Common\Tests\Service\Base\AbstractServiceTestCase;
use Itq\Common\Service\Model\ModelRestricterServiceInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group services/model
 * @group services/model/refresher
 */
class ModelRefresherServiceTest extends AbstractServiceTestCase
{
    /**
     * @return ModelRefresherService
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
        return [
            $this->mockedMetaDataService(),
            $this->mocked('restricter', ModelRestricterServiceInterface::class),
        ];
    }
    /**
     * @param string $type
     * @param string $pluginClass
     * @param array  $methods
     * @param string $getter
     * @param string $adder
     * @param string $optionalTypeForAdder
     * @param string $optionalSingleGetter
     *
     * @group unit
     *
     * @dataProvider getPluginsData
     */
    public function testPlugins($type, $pluginClass, array $methods, $getter, $adder, $optionalTypeForAdder = null, $optionalSingleGetter = null)
    {
        $this->handleTestPlugins($type, $pluginClass, $methods, $getter, $adder, $optionalTypeForAdder, $optionalSingleGetter);
    }
    /**
     * @return array
     */
    public function getPluginsData()
    {
        return [
            ['refresher', Plugin\ModelRefresherInterface::class, ['refresh'], 'getModelRefreshers', 'addModelRefresher'],
        ];
    }
}
