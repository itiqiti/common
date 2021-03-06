<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Service;

use Exception;
use Itq\Common\Traits;
use Itq\Common\Adapter;
use Itq\Common\Service;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Filesystem Service.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class FilesystemService
{
    use Traits\ServiceTrait;
    use Traits\ServiceAware\SystemServiceAwareTrait;
    use Traits\AdapterAware\FilesystemAdapterAwareTrait;
    /**
     * @param Service\SystemService              $systemService
     * @param Adapter\FilesystemAdapterInterface $adapter
     */
    public function __construct(Service\SystemService $systemService, Adapter\FilesystemAdapterInterface $adapter)
    {
        $this->setSystemService($systemService);
        $this->setFilesystemAdapter($adapter);
    }
    /**
     * @param string $content
     * @param string $suffix
     *
     * @return string
     *
     * @throws Exception
     */
    public function createTempFile($content, $suffix = null)
    {
        if (null !== $suffix) {
            if (false !== strpos($suffix, '~')) {
                throw $this->createMalformedException('Temp file suffix are not allowed to have "~" chars');
            }
        }

        $internalPath = $this->getFilesystemAdapter()->tempnam(
            $this->getSystemService()->getTempDirectory(),
            'cl-fs-'.md5(__DIR__).'-'
        );

        $realPath = $internalPath.'~'.$suffix;

        $this->writeFile($realPath, $content);

        return $realPath;
    }
    /**
     * @param string|array $path
     *
     * @return $this
     *
     * @throws Exception
     */
    public function cleanTempFile($path)
    {
        if (is_array($path)) {
            foreach ($path as $p) {
                $this->cleanTempFile($p);
            }

            return $this;
        }

        if (false === strpos($path, '~')) {
            throw $this->createMalformedException('The temp file name is not supported');
        }

        list($internalPath) = explode('~', $path);

        $this
            ->deleteFile($path)
            ->deleteFile($internalPath)
        ;

        return $this;
    }
    /**
     * @param string $path
     *
     * @return $this
     */
    public function deleteFile($path)
    {
        if ($this->isReadableFile($path)) {
            $this->getFilesystemAdapter()->unlink($path);
        }

        return $this;
    }
    /**
     * @param string $path
     * @param string $content
     *
     * @return $this
     */
    public function writeFile($path, $content)
    {
        $this->getFilesystemAdapter()->filePutContents($path, $content);

        return $this;
    }
    /**
     * @param string $path
     *
     * @return $this
     *
     * @throws Exception
     */
    public function ensureDirectory($path)
    {
        if ($this->isReadableDirectory($path)) {
            return $this;
        }

        if (!$this->getFilesystemAdapter()->mkdir($path, 0777, true)) {
            throw $this->createFailedException("Unable to create directory '%s'", $path);
        }

        return $this;
    }
    /**
     * @param string $path
     *
     * @return string
     */
    public function readFile($path)
    {
        $this->checkReadableFile($path);

        return $this->getFilesystemAdapter()->fileGetContents($path);
    }
    /**
     * @param string $path
     * @param mixed  $defaultValue
     *
     * @return mixed
     */
    public function readFileIfExist($path, $defaultValue = null)
    {
        if (!$this->isReadableFile($path)) {
            return $defaultValue;
        }

        return $this->readFile($path);
    }
    /**
     * @param string $path
     *
     * @return $this
     *
     * @throws Exception
     */
    public function checkReadableFile($path)
    {
        if ($this->isReadableFile($path)) {
            return $this;
        }

        throw $this->createRequiredException(
            "File '%s' is not readable (permissions problem or file missing)",
            $path
        );
    }
    /**
     * @param string $path
     *
     * @return $this
     *
     * @throws Exception
     */
    public function checkReadableDirectory($path)
    {
        if ($this->isReadableDirectory($path)) {
            return $this;
        }

        throw $this->createRequiredException(
            "Directory '%s' is not readable (permissions problem or directory missing)",
            $path
        );
    }
    /**
     * @param string $path
     *
     * @return bool
     */
    public function isReadableFile($path)
    {
        return true === $this->getFilesystemAdapter()->isFile($path);
    }
    /**
     * @param string $path
     *
     * @return bool
     */
    public function isReadableDirectory($path)
    {
        return true === $this->getFilesystemAdapter()->isDir($path);
    }
    /**
     * @param string $path
     * @return string
     */
    public function readAndDeleteFile($path)
    {
        $content = $this->readFile($path);

        $this->deleteFile($path);

        return $content;
    }
    /**
     * @param string $path
     * @param string $extension
     *
     * @return Finder|SplFileInfo[]
     */
    public function findFilesByExtension($path, $extension)
    {
        return (new Finder())->files()->in($path.'/*')->name('*.'.$extension);
    }
}
