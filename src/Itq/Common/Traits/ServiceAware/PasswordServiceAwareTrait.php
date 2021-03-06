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

use Itq\Common\Service\PasswordService;

/**
 * PasswordServiceAware trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait PasswordServiceAwareTrait
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
     * @return PasswordService
     */
    public function getPasswordService()
    {
        return $this->getService('passwordService');
    }
    /**
     * @param PasswordService $service
     *
     * @return $this
     */
    public function setPasswordService(PasswordService $service)
    {
        return $this->setService('passwordService', $service);
    }
}
