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

use Itq\Common\Service\DynamicUrlService;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait DynamicUrlServiceAwareTrait
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
     * @return DynamicUrlService
     */
    public function getDynamicUrlService()
    {
        return $this->getService('dynamicUrlService');
    }
    /**
     * @param DynamicUrlService $service
     *
     * @return $this
     */
    public function setDynamicUrlService(DynamicUrlService $service)
    {
        return $this->setService('dynamicUrlService', $service);
    }
}
