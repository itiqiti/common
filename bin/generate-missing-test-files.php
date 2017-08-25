#!/usr/bin/env php
<?php

/**
 * @param string $template
 * @param array  $params
 *
 * @return string
 */
function render_template($template, array $params)
{
    $content = file_get_contents(sprintf(__DIR__.'/../tests/templates/%s', $template));
    $matches = null;

    if (0 < preg_match_all('/\{\{\s*([^\}]+)\s*\}\}/', $content, $matches)) {
        foreach ($matches[1] as $i => $match) {
            $content = str_replace($matches[0][$i], isset($params[$match]) ? $params[$match] : null, $content);
        }
    }

    return $content;
}

function generate_missings(array $map)
{
    $srcDir  = 'src';
    $testDir = 'tests';

    foreach ($map as $definition) {
        $definition += ['params' => [], 'ignores' => []];
        $f = new \Symfony\Component\Finder\Finder();
        $f->in(sprintf('%s/%s', $srcDir, $definition['dir']))->depth(0);
        if (isset($definition['ignores']) && is_array($definition['ignores']) && count($definition['ignores'])) {
            foreach ($definition['ignores'] as $ignore) {
                $f->notName($ignore);
            }
        }
        foreach ($f->files() as $file) {
            /** @var \Symfony\Component\Finder\SplFileInfo $file */
            $name = preg_replace('/\.php$/', '', $file->getFilename());
            $shortName = preg_replace(sprintf('/%s$/', $definition['suffix']), '', $name);
            $sluggedShortName = strtolower($shortName);
            $testFile = sprintf('%s/%s/%sTest.php', $testDir, $definition['dir'], $name);
            if (!is_file($testFile)) {
                $parentDir = dirname($testFile);
                if (!is_dir($parentDir)) {
                    mkdir($parentDir, 0777, true);
                }
                file_put_contents(
                    $testFile,
                    render_template(
                        sprintf('%s/%s', $definition['dir'], $definition['template']),
                        [
                            'name'             => $name,
                            'shortName'        => $shortName,
                            'sluggedShortName' => $sluggedShortName,
                            'className'        => $name,
                            'fullClassName'    => str_replace('/', '\\', $definition['dir']).'\\'.$name,
                        ] + $definition['params']
                    )
                );
                echo $testFile.PHP_EOL;
            }
        }
    }

}
require __DIR__.'/../vendor/autoload.php';


$map = [
    'annotations'     => ['dir' => 'Itq/Common/Annotation', 'suffix' => 'Annotation', 'template' => 'template.php'],
    'services'        => ['dir' => 'Itq/Common/Service', 'suffix' => 'Service', 'template' => 'template.php', 'ignores' => ['/Interface\.php$/']],
    'plugins/actions' => ['dir' => 'Itq/Common/Plugin/Action', 'suffix' => 'Action', 'template' => 'template.php'],
];

generate_missings($map);