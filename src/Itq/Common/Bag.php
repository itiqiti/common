<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common;

use Exception;
use Itq\Common\Traits;

/**
 * Bag
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class Bag
{
    use Traits\ExceptionThrowerTrait;
    use Traits\MissingMethodCatcherTrait;
    /**
     * @var array
     */
    protected $vars;
    /**
     * @param array $vars
     */
    public function __construct(array $vars = [])
    {
        $this
            ->reset()
            ->set($vars)
        ;
    }
    /**
     * @return array
     */
    public function all()
    {
        return $this->vars;
    }
    /**
     * @param string|array $key
     * @param mixed        $value
     *
     * @return $this
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $this->vars = $key + $this->vars;

            return $this;
        }

        $this->vars[$key] = $value;

        return $this;
    }
    /**
     * @param string|array $key
     * @param mixed        $value
     *
     * @return $this
     */
    public function setDefault($key, $value = null)
    {
        if (!is_array($key)) {
            $key = [$key => $value];
        }

        foreach ($key as $k => $v) {
            if (array_key_exists($k, $this->vars)) {
                continue;
            }
            $this->vars[$k] = $v;
        }

        return $this;
    }
    /**
     * @return $this
     */
    public function reset()
    {
        $this->vars = [];

        return $this;
    }
    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->vars[$key]);
    }
    /**
     * @param string $key
     * @param array  ...$vars
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function get($key, ...$vars)
    {
        if (!isset($this->vars[$key])) {
            if (!count($vars)) {
                throw $this->createRequiredException("Missing '%s'", $key);
            }

            return array_shift($vars);
        }

        return $this->vars[$key];
    }
    /**
     * @param array|string $keys
     * @param array        ...$vars
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getFirstOf($keys, ...$vars)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        foreach ($keys as $k) {
            if ($this->has($k)) {
                return $this->get($k);
            }
        }

        if (count($vars)) {
            return array_shift($vars);
        }

        throw $this->createRequiredException("Missing '%s'", join(' or ', $keys));
    }
}
