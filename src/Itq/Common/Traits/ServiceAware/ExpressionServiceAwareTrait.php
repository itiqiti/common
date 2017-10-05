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

use Itq\Common\Service\ExpressionService;

/**
 * ExpressionServiceAware trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait ExpressionServiceAwareTrait
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
     * @return ExpressionService
     */
    public function getExpressionService()
    {
        return $this->getService('expressionService');
    }
    /**
     * @param ExpressionService $service
     *
     * @return $this
     */
    public function setExpressionService(ExpressionService $service)
    {
        return $this->setService('expressionService', $service);
    }
}
