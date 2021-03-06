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

use Itq\Common\Service\JobCreatorServiceInterface;

/**
 * JobCreatorServiceAware trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait JobCreatorServiceAwareTrait
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
     * @param string $key
     *
     * @return bool
     */
    protected abstract function hasService($key);
    /**
     * @return JobCreatorServiceInterface
     */
    public function getJobCreatorService()
    {
        return $this->getService('jobCreatorService');
    }
    /**
     * @return bool
     */
    public function hasJobCreatorService()
    {
        return $this->hasService('jobCreatorService');
    }
    /**
     * @param JobCreatorServiceInterface $service
     *
     * @return $this
     */
    public function setJobCreatorService(JobCreatorServiceInterface $service)
    {
        return $this->setService('jobCreatorService', $service);
    }
}
