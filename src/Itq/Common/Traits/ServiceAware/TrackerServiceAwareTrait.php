<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Traits\ServiceAware;

use Itq\Common\Service\TrackerService;

/**
 * TrackerServiceAware trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait TrackerServiceAwareTrait
{
    /**
     * @param string $key
     * @param mixed  $service
     *
     * @return $this
     */
    protected abstract function setService($key, $service);
    /**
     * @param string $key
     *
     * @return mixed
     */
    protected abstract function getService($key);
    /**
     * @return TrackerService
     */
    public function getTrackerService()
    {
        return $this->getService('trackerService');
    }
    /**
     * @param TrackerService $service
     *
     * @return $this
     */
    public function setTrackerService(TrackerService $service)
    {
        return $this->setService('trackerService', $service);
    }
}
