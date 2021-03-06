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

use Itq\Common\Traits;
use Itq\Common\Plugin\StorageInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Storage Service.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class StorageService
{
    use Traits\ServiceTrait;
    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->setEventDispatcher($eventDispatcher);
    }
    /**
     * Register a backend for the specified prefix (replace if exist).
     *
     * @param string           $name
     * @param string           $mount
     * @param StorageInterface $backend
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function mount($name, $mount, StorageInterface $backend)
    {
        return $this->setArrayParameterKey('backends', $mount, ['name' => $name, 'backend' => $backend]);
    }
    /**
     * Unregister a backend for the specified prefix.
     *
     * @param string $mount
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function unmount($mount)
    {
        return $this
            ->checkArrayParameterKeyExist('backends', $mount)
            ->unsetArrayParameterKey('backends', $mount)
        ;
    }
    /**
     * @param string $location
     * @param mixed  $content
     * @param array  $options
     *
     * @return $this
     */
    public function save($location, $content, array $options = [])
    {
        $this->checkLocation($location);

        $options += ['separator' => '/'];

        if (is_array($content)) {
            foreach ($content as $file => $fileContent) {
                $this->save($location.$options['separator'].$file, $fileContent);
            }

            return $this;
        }

        list($storage, $relativePath) = $this->getBackendForLocation($location);

        $backend = $storage['backend'];

        /** @var StorageInterface $backend */
        $backend->set($relativePath, $content);

        $this->dispatch($storage['name'].'_object_saved', ['key' => $location, 'relativeKey' => $relativePath, 'value' => $content]);

        return $this;
    }
    /**
     * @param string $location
     * @param array  $options
     *
     * @return mixed
     */
    public function read($location, $options = [])
    {
        $this->checkLocation($location);

        list($storage, $relativePath) = $this->getBackendForLocation($location);

        $backend = $storage['backend'];

        /** @var StorageInterface $backend */

        if (array_key_exists('defaultValue', $options)) {
            if (!$backend->has($relativePath, $options)) {
                return $options['defaultValue'];
            }
        }
        $content = $backend->get($relativePath, $options);

        $this->dispatch($storage['name'].'_object_read', ['key' => $location, 'relativeKey' => $relativePath, 'value' => $content]);

        return $content;
    }
    /**
     * @param string $location
     * @param array  $options
     *
     * @return bool
     */
    public function has($location, $options = [])
    {
        $this->checkLocation($location);

        list($storage, $relativePath) = $this->getBackendForLocation($location);

        $backend = $storage['backend'];

        /** @var StorageInterface $backend */

        return $backend->has($relativePath, $options);
    }
    /**
     * @param string $location
     * @param array  $options
     *
     * @return $this
     */
    public function delete($location, $options = [])
    {
        $this->checkLocation($location);

        list($storage, $relativePath) = $this->getBackendForLocation($location);

        $old = null;
        $oldListened = false;

        $backend = $storage['backend'];

        if ($this->hasListeners($storage['name'].'_object_deleted_old')) {
            $old = $this->read($location, $options);
            $oldListened = true;
        }

        /** @var StorageInterface $backend */
        $backend->clear($relativePath);

        $this->dispatch($storage['name'].'_object_deleted', ['key' => $location, 'relativeKey' => $relativePath]);

        if ($oldListened) {
            $this->dispatch(
                $storage['name'].'_object_deleted_old',
                ['key' => $location, 'relativeKey' => $relativePath, 'value' => $old]
            );
        }

        unset($oldListened, $old);

        return $this;
    }
    /**
     * @param object $doc
     * @param array  $storages
     * @param array  $options
     *
     * @return $this
     */
    public function populate($doc, array $storages, array $options = [])
    {
        foreach (array_keys($storages) as $k) {
            if (!isset($doc->$k)) {
                continue;
            }
            $doc->$k = is_array($doc->$k) ? json_encode($doc->$k) : $this->read($doc->$k);
        }

        unset($options);

        return $this;
    }
    /**
     * @param string $location
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function getBackendForLocation($location)
    {
        $this->checkLocation($location);

        $backends = array_reverse($this->getArrayParameter('backends'), true);

        $found = null;

        foreach ($backends as $prefix => $backend) {
            $len = $this->getStringLength($prefix);
            if (substr($location, 0, $len) === $prefix) {
                $found = [$backend, substr($location, $len)];
                break;
            }
        }

        if (null === $found) {
            throw $this->createNotFoundException("No backend registered for location '%s'", $location);
        }

        return $found;
    }
    /**
     * @param string $location
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function checkLocation($location)
    {
        if (!is_string($location)) {
            throw $this->createMalformedException("Malformed location (must be a string)");
        }

        if (false === preg_match(',^[a-z0-9_\-\./]+$,', $location)) {
            throw $this->createMalformedException("Malformed location '%s'", $location);
        }

        return $this;
    }
}
