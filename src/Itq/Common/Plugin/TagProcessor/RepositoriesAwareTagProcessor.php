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
class RepositoriesAwareTagProcessor extends AbstractTagProcessor
{
    /**
     * @return string
     */
    public function getTag()
    {
        return 'app.repositories_aware';
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
        $params += ['method' => 'addRepository'];

        foreach ($ctx->repositoryIds as $repoAlias => $repoId) {
            $d->addMethodCall($params['method'], [$repoAlias, new Reference($repoId)]);
        }
    }
}
