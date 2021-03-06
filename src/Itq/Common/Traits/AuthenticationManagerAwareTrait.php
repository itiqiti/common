<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Traits;

use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;

/**
 * AuthenticationManagerAware trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait AuthenticationManagerAwareTrait
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
     * @param AuthenticationManagerInterface $authenticationManagerInterface
     *
     * @return $this
     */
    public function setAuthenticationManager(AuthenticationManagerInterface $authenticationManagerInterface)
    {
        return $this->setService('authenticationManager', $authenticationManagerInterface);
    }
    /**
     * @return AuthenticationManagerInterface
     */
    public function getAuthenticationManager()
    {
        return $this->getService('authenticationManager');
    }
}
