<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common\Plugin\CriteriumType\Mongo;

use Itq\Common\Plugin\CriteriumType\Mongo\NearMongoCriteriumType;
use Itq\Common\Tests\Plugin\CriteriumType\Mongo\Base\AbstractMongoCriteriumTypeTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group plugins
 * @group plugins/criterium-types
 * @group plugins/criterium-types/mongo
 * @group plugins/criterium-types/mongo/near
 */
class NearMongoCriteriumTypeTest extends AbstractMongoCriteriumTypeTestCase
{
    /**
     * @return NearMongoCriteriumType
     */
    public function c()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::c();
    }
}
