<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Service;

use Exception;
use Itq\Common\Traits;
use Itq\Common\DocumentInterface;

/**
 * Document Builder Service.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class DocumentBuilderService
{
    use Traits\ServiceTrait;
    use Traits\CallableBagTrait;
    /**
     * Register a document builder for the specified name (replace if exist).
     *
     * @param string   $name
     * @param callable $callable
     * @param array    $options
     *
     * @return $this
     *
     * @throws Exception
     */
    public function register($name, $callable, array $options = [])
    {
        return $this->registerCallableByType('documentBuilder', $name, $callable, $options);
    }
    /**
     * Return the document builder registered for the specified name.
     *
     * @param string $name
     *
     * @return callable
     *
     * @throws Exception if no document builder registered for this name
     */
    public function get($name)
    {
        return $this->getCallableByType('documentBuilder', $name);
    }
    /**
     * @param string $name
     * @param array  $data
     * @param array  $metas
     * @param array  $options
     *
     * @return DocumentInterface
     *
     * @throws Exception
     */
    public function build($name, array $data = [], array $metas = [], array $options = [])
    {
        return $this->executeCallableByType('documentBuilder', $name, [$data, $metas, $options]);
    }
}
