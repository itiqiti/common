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

use Itq\Common\Service\PartnerService;

/**
 * PartnerServiceAware trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait PartnerServiceAwareTrait
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
     * @return PartnerService
     */
    public function getPartnerService()
    {
        return $this->getService('partnerService');
    }
    /**
     * @param PartnerService $service
     *
     * @return $this
     */
    public function setPartnerService(PartnerService $service)
    {
        return $this->setService('partnerService', $service);
    }
}
