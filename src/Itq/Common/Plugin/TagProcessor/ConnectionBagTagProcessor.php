<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Plugin\TagProcessor;

use Itq\Common\Plugin\TagProcessor\Base\AbstractTagProcessor;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class ConnectionBagTagProcessor extends AbstractTagProcessor
{
    /**
     * @return string
     */
    public function getTag()
    {
        return 'app.connection_bag';
    }
    /**
     * @param string           $tag
     * @param array            $params
     * @param string           $id
     * @param Definition       $d
     * @param ContainerBuilder $container
     * @param object           $ctx
     *
     * @return void
     *
     * @throws \Exception
     */
    public function process($tag, array $params, $id, Definition $d, ContainerBuilder $container, $ctx)
    {
        if (!isset($params['type'])) {
            throw $this->createRequiredException("Missing type for connection bag service '%s'", $id);
        }

        $type = $params['type'];

        unset($params['type']);

        $this->addCall($container, 'app.connection', 'register', [$type, new Reference($id), $params]);
    }
}