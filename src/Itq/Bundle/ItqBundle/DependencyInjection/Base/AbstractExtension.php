<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Bundle\ItqBundle\DependencyInjection\Base;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use ReflectionClass;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
abstract class AbstractExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->createConfiguration(), $configs);

        $this->preApply($config, $container);
        $this->apply($config, $container);
        $this->postApply($config, $container);
        $this->finishApply($config, $container);
    }
    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function preApply(/** @noinspection PhpUnusedParameterInspection */ array $config, ContainerBuilder $container)
    {
    }
    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function apply(/** @noinspection PhpUnusedParameterInspection */ array $config, ContainerBuilder $container)
    {
    }
    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function postApply(/** @noinspection PhpUnusedParameterInspection */ array $config, ContainerBuilder $container)
    {
        $dir = realpath(dirname((new ReflectionClass($this))->getFileName()).'/../../Resources/config');

        if ($dir && is_dir($dir)) {
            if (is_file($dir.'/services.yml')) {
                $loader = new Loader\YamlFileLoader($container, new FileLocator($dir));
                $loader->load('services.yml');
            }
            if (is_file($dir.'/error-mapping.yml')) {
                $this->registerErrorMappingFile($dir.'/error-mapping.yml', $container);
            }
        }
    }
    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function finishApply(/** @noinspection PhpUnusedParameterInspection */ array $config, ContainerBuilder $container)
    {
    }
    /**
     * @param string           $path
     * @param ContainerBuilder $container
     *
     * @return $this
     */
    protected function registerErrorMappingFile($path, ContainerBuilder $container)
    {
        $container
            ->getDefinition('app.errormanager')
            ->addMethodCall('addKeyCodeMapping', [Yaml::parse(file_get_contents($path))])
        ;

        return $this;
    }
    /**
     * @return ConfigurationInterface
     */
    protected function createConfiguration()
    {
        $class = $this->getConfigurationClass();

        return new $class();
    }
    /**
     * @return string
     */
    protected function getConfigurationClass()
    {
        return str_replace('/', '\\', dirname(str_replace('\\', '/', get_class($this)))).'\\Configuration';
    }
}
