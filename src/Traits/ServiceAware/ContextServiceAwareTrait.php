<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <cto@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Traits\ServiceAware;

use Itq\Common\Service\ContextService;

/**
 * @author Olivier Hoareau <olivier@itiqiti.com>
 */
trait ContextServiceAwareTrait
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
     * @return ContextService
     */
    public function getContextService()
    {
        return $this->getService('context');
    }
    /**
     * @param ContextService $service
     *
     * @return $this
     */
    public function setContextService(ContextService $service)
    {
        return $this->setService('context', $service);
    }
}
