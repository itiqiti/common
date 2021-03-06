<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Traits\Controller\ServiceAware;

use Itq\Common\Service;

/**
 * Request Service Aware Controller trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait RequestServiceAwareControllerTrait
{
    /**
     * @param string $id
     *
     * @return object
     */
    abstract public function get($id);
    /**
     * @return Service\RequestService
     */
    public function getRequestService()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return $this->get('app.request');
    }
}
