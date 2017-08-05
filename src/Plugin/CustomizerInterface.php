<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <cto@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Plugin;

use Itq\Common\Bag;

/**
 * Customizer Interface.
 *
 * @author Olivier Hoareau <olivier@itiqiti.com>
 */
interface CustomizerInterface
{
    /**
     * @param string $type
     * @param string $key
     * @param Bag    $data
     *
     * @return void
     */
    public function customize($type, $key, Bag $data);
}
