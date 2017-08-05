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

use Itq\Common\Service\DataService;

/**
 * @author Olivier Hoareau <olivier@itiqiti.com>
 */
trait DataServiceAwareTrait
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
     * @return DataService
     */
    public function getDataService()
    {
        return $this->getService('data');
    }
    /**
     * @param DataService $service
     *
     * @return $this
     */
    public function setDataService(DataService $service)
    {
        return $this->setService('data', $service);
    }
}
