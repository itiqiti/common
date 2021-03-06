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

use Itq\Common\Service\RuleEngineService;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait RuleEngineServiceAwareTrait
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
     * @return RuleEngineService
     */
    public function getRuleEngineService()
    {
        return $this->getService('ruleEngineService');
    }
    /**
     * @param RuleEngineService $service
     *
     * @return $this
     */
    public function setRuleEngineService(RuleEngineService $service)
    {
        return $this->setService('ruleEngineService', $service);
    }
}
