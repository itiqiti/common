<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Itq\Common;

use Itq\Common\Document;
use Itq\Common\Tests\Base\AbstractTestCase;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 *
 * @group objects
 * @group objects/document
 */
class DocumentTest extends AbstractTestCase
{
    /**
     * @return Document
     */
    public function d()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::o();
    }
    /**
     * @return array
     */
    public function constructor()
    {
        return [
            '<a></a>',
            'application/xml',
            'x.xml',
        ];
    }
    /**
     * @group unit
     */
    public function testConstructGetters()
    {
        $this->assertEquals('<a></a>', $this->d()->getContent());
        $this->assertEquals('application/xml', $this->d()->getContentType());
        $this->assertEquals('x.xml', $this->d()->getFileName());
    }
}
