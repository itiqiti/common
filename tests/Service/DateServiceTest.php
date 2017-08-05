<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <cto@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Service;

use Itq\Common\Service;

use PHPUnit_Framework_TestCase;

/**
 * @author Olivier Hoareau <olivier@itiqiti.com>
 *
 * @group date
 */
class DateServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Service\DateService
     */
    protected $s;
    /**
     *
     */
    public function setUp()
    {
        $this->s = new Service\DateService();
    }
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $this->assertNotNull($this->s);
    }
    /**
     * @group unit
     */
    public function testGetPeriodLabel()
    {
        $d1 = new \DateTime('2016-06-27T01:00:00+02:00');
        $d2 = new \DateTime('2017-09-02T18:12:25+02:00');

        $this->assertEquals('2016', $this->s->getPeriodLabel($d1, 'year'));
        $this->assertEquals('2017', $this->s->getPeriodLabel($d2, 'year'));
        $this->assertEquals('2016-S1', $this->s->getPeriodLabel($d1, 'half'));
        $this->assertEquals('2017-S2', $this->s->getPeriodLabel($d2, 'half'));
        $this->assertEquals('2016-Q2', $this->s->getPeriodLabel($d1, 'quarter'));
        $this->assertEquals('2017-Q3', $this->s->getPeriodLabel($d2, 'quarter'));
        $this->assertEquals('2016-06', $this->s->getPeriodLabel($d1, 'month'));
        $this->assertEquals('2017-09', $this->s->getPeriodLabel($d2, 'month'));
        $this->assertEquals('2016-W26', $this->s->getPeriodLabel($d1, 'week'));
        $this->assertEquals('2017-W35', $this->s->getPeriodLabel($d2, 'week'));
        $this->assertEquals('2016-06-27', $this->s->getPeriodLabel($d1, 'day'));
        $this->assertEquals('2017-09-02', $this->s->getPeriodLabel($d2, 'day'));
        $this->assertEquals('2016-06-27_01', $this->s->getPeriodLabel($d1, 'hour'));
        $this->assertEquals('2017-09-02_18', $this->s->getPeriodLabel($d2, 'hour'));
        $this->assertEquals('2016-06-27_01-00', $this->s->getPeriodLabel($d1, 'minute'));
        $this->assertEquals('2017-09-02_18-12', $this->s->getPeriodLabel($d2, 'minute'));
        $this->assertEquals('2016-06-27_01-00-00', $this->s->getPeriodLabel($d1, 'second'));
        $this->assertEquals('2017-09-02_18-12-25', $this->s->getPeriodLabel($d2, 'second'));
    }
}
