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

use DateTime;
use DateTimeZone;
use Itq\Common\Service\DateService;
use Itq\Common\Tests\Service\Base\AbstractServiceTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group services
 * @group services/date
 */
class DateServiceTest extends AbstractServiceTestCase
{
    /**
     * @return DateService
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
        return [$this->mockedSystemService()];
    }
    /**
     * @group unit
     */
    public function testGetPeriodLabel()
    {
        $d1 = new DateTime('2016-06-27T01:00:00+02:00');
        $d2 = new DateTime('2017-09-02T18:12:25+02:00');

        $this->assertEquals('2016', $this->s()->getPeriodLabel($d1, 'year'));
        $this->assertEquals('2017', $this->s()->getPeriodLabel($d2, 'year'));
        $this->assertEquals('2016-S1', $this->s()->getPeriodLabel($d1, 'half'));
        $this->assertEquals('2017-S2', $this->s()->getPeriodLabel($d2, 'half'));
        $this->assertEquals('2016-Q2', $this->s()->getPeriodLabel($d1, 'quarter'));
        $this->assertEquals('2017-Q3', $this->s()->getPeriodLabel($d2, 'quarter'));
        $this->assertEquals('2016-06', $this->s()->getPeriodLabel($d1, 'month'));
        $this->assertEquals('2017-09', $this->s()->getPeriodLabel($d2, 'month'));
        $this->assertEquals('2016-W26', $this->s()->getPeriodLabel($d1, 'week'));
        $this->assertEquals('2017-W35', $this->s()->getPeriodLabel($d2, 'week'));
        $this->assertEquals('2016-06-27', $this->s()->getPeriodLabel($d1, 'day'));
        $this->assertEquals('2017-09-02', $this->s()->getPeriodLabel($d2, 'day'));
        $this->assertEquals('2016-06-27_01', $this->s()->getPeriodLabel($d1, 'hour'));
        $this->assertEquals('2017-09-02_18', $this->s()->getPeriodLabel($d2, 'hour'));
        $this->assertEquals('2016-06-27_01-00', $this->s()->getPeriodLabel($d1, 'minute'));
        $this->assertEquals('2017-09-02_18-12', $this->s()->getPeriodLabel($d2, 'minute'));
        $this->assertEquals('2016-06-27_01-00-00', $this->s()->getPeriodLabel($d1, 'second'));
        $this->assertEquals('2017-09-02_18-12-25', $this->s()->getPeriodLabel($d2, 'second'));
    }
    /**
     * @group unit
     */
    public function testGetCurrentDate()
    {
        $this->mockedSystemService()->expects($this->any())->method('getCurrentTimeZone')->willReturn(new DateTimeZone('Europe/Paris'));
        $this->mockedSystemService()->expects($this->any())->method('getCurrentTime')->willReturn(123.0, 0.0, 124.0);

        $this->assertEquals(new DateTime('@123'), $this->s()->getCurrentDate());
        $this->assertEquals(new DateTime('@0'), $this->s()->getCurrentDate());
        $this->assertEquals(new DateTime('@124'), $this->s()->getCurrentDate());
    }
    /**
     *
     */
    public function testSetCurrentDate()
    {
        $this->s()->setCurrentDate(new DateTime('2017-09-30T15:34:00+02:00'));
    }
    /**
     * @param \Exception|null $exception
     * @param string          $date
     *
     * @group unit
     *
     * @dataProvider getCheckDateStringFormatData
     */
    public function testCheckDateStringFormat($exception, $date)
    {
        if ($exception instanceof \Exception) {
            $this->expectExceptionThrown($exception);
        }

        $this->assertEquals($this->s(), $this->s()->checkDateStringFormat($date));
    }
    /**
     * @return array
     */
    public function getCheckDateStringFormatData()
    {
        return [
            [null, '2017-09-30T15:34:00+02:00'],
            [null, '2017-09-30T15:34:00Z'],
            [null, '2017-09-30T15:34:00.000-01:00'],
            [new \RuntimeException('date.malformed', 412), '2017-09-30T15:34:00+02:0'],
            [new \RuntimeException('date.malformed', 412), '2017'],
            [new \RuntimeException('date.malformed', 412), ''],
            [new \RuntimeException('date.malformed', 412), null],
            [new \RuntimeException('date.malformed', 412), []],
        ];
    }
}
