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

use Itq\Common\Service\UserProviderService;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait UserProviderServiceAwareTrait
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
     * @return UserProviderService
     */
    public function getUserProviderService()
    {
        return $this->getService('userProviderService');
    }
    /**
     * @param UserProviderService $service
     *
     * @return $this
     */
    public function setUserProviderService(UserProviderService $service)
    {
        return $this->setService('userProviderService', $service);
    }
}
