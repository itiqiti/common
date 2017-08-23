<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Plugin\CriteriumType;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class ValueCriteriumType extends Base\AbstractCriteriumType
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }
    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        return $this->setParameter('value', $value);
    }
    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->getParameter('value');
    }
    /**
     * @param string $v
     * @param string $k
     * @param array  $options
     *
     * @return array
     */
    public function build($v, $k, array $options = [])
    {
        $value = $this->getValue();

        if (is_callable($value)) {
            $value = $value($v, $k, $options);
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        return $value;
    }
}
