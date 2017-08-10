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

use Itq\Common\Service\BusinessRuleService;

/**
 * BusinessRuleServiceAware trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait BusinessRuleServiceAwareTrait
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
     * @return BusinessRuleService
     */
    public function getBusinessRuleService()
    {
        return $this->getService('businessRule');
    }
    /**
     * @param BusinessRuleService $service
     *
     * @return $this
     */
    public function setBusinessRuleService(BusinessRuleService $service)
    {
        return $this->setService('businessRule', $service);
    }
}
