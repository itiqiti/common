<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Service\Model;

use Itq\Common\Aware\ModelPropertyAuthorizationCheckerAwareInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
interface ModelPropertyAuthorizationCheckerServiceInterface extends ModelPropertyAuthorizationCheckerAwareInterface
{
    /**
     * @param object $doc
     * @param string $property
     * @param string $operation
     * @param array  $options
     *
     * @return bool
     */
    public function isPropertyOperationAllowed($doc, $property, $operation, array $options = []);
}
