<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Service;

use Itq\Common\Plugin;
use Itq\Common\Service\TrackerService;
use PHPUnit_Framework_MockObject_MockObject;
use Itq\Common\Tests\Service\Base\AbstractServiceTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group services
 * @group services/tracker
 */
class TrackerServiceTest extends AbstractServiceTestCase
{
    /**
     * @return TrackerService
     */
    public function s()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::s();
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
            ['tracker', Plugin\TrackerInterface::class, ['track'], 'getTrackers', 'addTracker', 'thetracker', 'getTracker'],
        ];
    }
    /**
     * @group unit
     */
    public function testTrack()
    {
        /** @var Plugin\TrackerInterface|PHPUnit_Framework_MockObject_MockObject $mockedTracker */
        $this->mocked('tracker', Plugin\TrackerInterface::class);
        $this->mocked('tracker')->expects($this->once())->method('track');
        $this->s()->addTracker('type', $this->mocked('tracker'));

        $this->s()->track('type', ['definition' => ''], ['data' => '']);
    }
}
