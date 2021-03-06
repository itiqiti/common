<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Traits\ServiceAware\Model;

use Itq\Common\Service\Model\ModelRestricterServiceInterface;

/**
 * ModelRestricterServiceAware trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait ModelRestricterServiceAwareTrait
{
    /**
     * @return ModelRestricterServiceInterface
     */
    public function getModelRestricterService()
    {
        return $this->getService('modelRestricterService');
    }
    /**
     * @param ModelRestricterServiceInterface $service
     *
     * @return $this
     */
    public function setModelRestricterService(ModelRestricterServiceInterface $service)
    {
        return $this->setService('modelRestricterService', $service);
    }
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
}
