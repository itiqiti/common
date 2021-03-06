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
use Itq\Common\Service;
use Itq\Common\Exception as CommonException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class UserProviderService implements UserProviderInterface
{
    use Traits\ServiceTrait;
    use Traits\ServiceAware\ConverterServiceAwareTrait;
    /**
     * @param Service\ConverterService $converterService
     * @param string                   $userClass
     */
    public function __construct(ConverterService $converterService, $userClass)
    {
        $this->setConverterService($converterService);
        $this->setUserClass($userClass);
    }
    /**
     * @param string $userClass
     *
     * @return $this
     */
    public function setUserClass($userClass)
    {
        return $this->setParameter('userClass', $userClass);
    }
    /**
     * @return string
     *
     * @throws Exception
     */
    public function getUserClass()
    {
        return $this->getParameter('userClass');
    }
    /**
     * @param mixed      $accountProvider
     * @param string     $type
     * @param string     $method
     * @param string     $format
     * @param bool       $alreadyAuthentified
     * @param null|array $usernameKeys
     *
     * @return $this
     *
     * @throws Exception
     */
    public function setAccountProvider($accountProvider, $type = 'default', $method = 'get', $format = 'plain', $alreadyAuthentified = false, $usernameKeys = null)
    {
        return $this->setArrayParameterKey(
            'accountProviders',
            $type,
            [
                'method'       => $method,
                'format'       => $format,
                'provider'     => $accountProvider,
                'authentified' => $alreadyAuthentified,
                'usernameKeys' => is_array($usernameKeys) ? $usernameKeys : ['id'],
            ]
        );
    }
    /**
     * @param string $username
     *
     * @return UserInterface
     *
     * @throws Exception
     */
    public function loadUserByUsername($username)
    {
        $account = null;

        try {
            $account = $this->getAccount($username);
        } catch (Exception $e) {
            if (404 === $e->getCode()) {
                throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
            }
            if (412 === $e->getCode()) {
                throw new AuthenticationException(sprintf("Unable to retrieve username '%s': %s", $username, $e->getMessage()), 412);
            }
            throw $e;
        }

        $class = $this->getUserClass();

        return new $class($account);
    }
    /**
     * @param string $username
     *
     * @return array
     *
     * @throws Exception
     */
    public function getAccount($username)
    {
        $realUsername = $username;
        $type         = 'default';

        if (false !== strpos($username, '/')) {
            list($type, $realUsername) = explode('/', $username, 2);
        }
        if (!$this->hasArrayParameterKey('accountProviders', $type)) {
            throw new CommonException\UnsupportedAccountTypeException($type);
        }

        $accountProviderDescription = $this->getArrayParameterKey('accountProviders', $type);
        $accountProvider            = $accountProviderDescription['provider'];
        $method                     = $accountProviderDescription['method'];
        $format                     = $accountProviderDescription['format'];
        $alreadyAuthentified        = true === $accountProviderDescription['authentified'];
        $usernameKeys               = (array) $accountProviderDescription['usernameKeys'];

        if (!$this->hasPhpMethod($accountProvider, $method)) {
            throw $this->createNotFoundException(
                "Unable to retrieve account from account provider '%s' (method: %s)",
                $this->getClass($accountProvider),
                $method
            );
        }

        $a = $this->callPhpMethod($accountProvider, $method, [$this->unformat($realUsername, $format)]);

        if (is_object($a)) {
            $a = $this->toArray($a);
        }

        foreach ($usernameKeys as $usernameKey) {
            if (isset($a[$usernameKey])) {
                $a['username'] = $a[$usernameKey];
                break;
            }
        }

        return ['*alreadyAuthentified*' => (bool) $alreadyAuthentified] + $a;
    }
    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws Exception
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }
    /**
     * @param string $class
     *
     * @return bool
     *
     * @throws Exception
     */
    public function supportsClass($class)
    {
        return $class === $this->getUserClass();
    }
    /**
     * @param string $value
     * @param string $format
     *
     * @return string
     *
     * @throws Exception
     */
    protected function unformat($value, $format)
    {
        if (null !== $format && '' !== $format && 'plain' !== $format) {
            $value = $this->getConverterService()->convert($format.'_to_plain', $value);
        }

        return $value;
    }
}
