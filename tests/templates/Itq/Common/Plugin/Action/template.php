<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Plugin\Action;

use Itq\Common\Plugin\Action\{{className}};
use Itq\Common\Tests\Plugin\Action\Base\AbstractActionTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group plugins
 * @group plugins/actions
 * @group plugins/actions/{{sluggedShortName}}
 */
class {{className}}Test extends AbstractActionTestCase
{
    /**
     * @return {{className}}
     */
    public function a()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::a();
    }
}
