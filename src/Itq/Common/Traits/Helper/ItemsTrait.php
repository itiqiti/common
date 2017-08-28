<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Traits\Helper;

/**
 * Items trait.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
trait ItemsTrait
{
    use Items\SortTrait;
    use Items\FilterTrait;
    use Items\PaginateTrait;
}