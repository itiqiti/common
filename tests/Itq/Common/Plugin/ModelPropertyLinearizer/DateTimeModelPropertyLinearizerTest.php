<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Plugin\ModelPropertyLinearizer;

use Itq\Common\Plugin\ModelPropertyLinearizer\DateTimeModelPropertyLinearizer;
use Itq\Common\Tests\Plugin\ModelPropertyLinearizer\Base\AbstractModelPropertyLinearizerTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group plugins
 * @group plugins/models
 * @group plugins/models/property-linearizers
 * @group plugins/models/property-linearizers/date-time
 */
class DateTimeModelPropertyLinearizerTest extends AbstractModelPropertyLinearizerTestCase
{
    /**
     * @return DateTimeModelPropertyLinearizer
     */
    public function l()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::l();
    }
}
