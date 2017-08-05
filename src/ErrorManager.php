<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common;

use Itq\Common\Exception\ErrorException;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Translation\TranslatorBagInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class ErrorManager implements ErrorManagerInterface
{
    /**
     * @var TranslatorInterface|null
     */
    protected $translator;
    /**
     * @var string
     */
    protected $locale;
    /**
     * @var array
     */
    protected $keyCodeMapping;
    /**
     * @param TranslatorInterface|null $translator
     * @param string                   $locale
     * @param array                    $keyCodeMapping
     */
    public function __construct(TranslatorInterface $translator = null, $locale = null, array $keyCodeMapping = [])
    {
        if ($translator) {
            $this->setTranslator($translator);
        }
        if ($locale) {
            $this->setLocale($locale);
        }

        $this->setKeyCodeMapping($keyCodeMapping);
    }
    /**
     * @param array $keyCodeMapping
     *
     * @return $this
     */
    public function setKeyCodeMapping(array $keyCodeMapping)
    {
        $that = $this;

        $this->keyCodeMapping = array_map(
            function ($a) use ($that) {
                return $that->buildKeyCodeData($a);
            },
            $keyCodeMapping
        );

        return $this;
    }
    /**
     * @param array $keyCodeMapping
     *
     * @return $this
     */
    public function addKeyCodeMapping(array $keyCodeMapping)
    {
        $that = $this;

        $this->keyCodeMapping = array_map(
            function ($a) use ($that) {
                return $that->buildKeyCodeData($a);
            },
            $keyCodeMapping
        ) + $this->keyCodeMapping;

        return $this;
    }
    /**
     * @return array
     */
    public function getKeyCodeMapping()
    {
        return $this->keyCodeMapping;
    }
    /**
     * @param string $key
     * @param array  $code
     *
     * @return $this
     */
    public function setKeyCode($key, $code)
    {
        $this->keyCodeMapping[$key] = $this->buildKeyCodeData($code);

        return $this;
    }
    /**
     * @param string $key
     *
     * @return null|array
     */
    public function findOneKeyCode($key)
    {
        if (!isset($this->keyCodeMapping[$key])) {
            return null;
        }

        return $this->keyCodeMapping[$key];
    }
    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     *
     * @return $this
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;

        return $this;
    }
    /**
     * @return TranslatorInterface|null
     */
    public function getTranslator()
    {
        return $this->translator;
    }
    /**
     * @param string $key
     * @param array  $params
     * @param array  $options
     *
     * @return \Exception
     */
    public function createException($key, array $params = [], array $options = [])
    {
        $options    += ['locale' => $this->getLocale()];
        $code        = null;
        $codeData    = [];
        $originalKey = $key;

        if ('#' === substr($key, 0, 1) && false !== strpos($key, ':')) {
            list ($code, $key) = explode(':', substr($key, 1), 2);
        }

        $metaData = isset($options['metaData']) ? $options['metaData'] : [];
        $realKey  = $key;

        if (false !== strpos($key, '/')) {
            list ($key, $context) = explode('/', $key, 2);
            $metaData['context'] = $context;
        }
        if (null === $code) {
            $_codeData = $this->findOneKeyCode($key);
            if (null === $_codeData) {
                $_codeData = [];
            }
            $codeData = $_codeData + $codeData + ['code' => 0];
        } else {
            $codeData['code'] = (int) $code;
        }

        $translator = $this->getTranslator();
        $tries      = [$realKey];

        if ($realKey !== $key) {
            $tries[] = $key;
        }

        $replaceParams          = [];
        $paramsAlreadyProcessed = false;

        if (is_array($params) && 1 === count($params) && is_array($params[0])) {
            $ignore = false;
            foreach (array_keys($params[0]) as $k) {
                if (!preg_match('/^\%.+\%$/', $k)) {
                    $ignore = true;
                    break;
                }
            }
            if (!$ignore) {
                $replaceParams = $params[0];
                $params = [];
                foreach ($replaceParams as $k => $v) {
                    $params[substr($k, 1, strlen($k) - 2)] = $v;
                }
                $paramsAlreadyProcessed = true;
            }
        }
        if (!$paramsAlreadyProcessed) {
            foreach ($params as $k => $v) {
                $replaceParams['%'.$k.'%'] = $v;
            }
        }

        $message     = $key;
        $selectedKey = $key;

        if ($translator) {
            if ($translator instanceof TranslatorBagInterface) {
                foreach ($tries as $try) {
                    $catalog = $translator->getCatalogue($options['locale']);
                    if ($catalog->has($try, 'errors')) {
                        $selectedKey = $try;
                        $metaData['selectedPattern'] = $catalog->get($try, 'errors');
                        $metaData['locale'] = $catalog->getLocale();
                        break;
                    }
                }
            }
            $message = $translator->trans($selectedKey, $replaceParams, 'errors', $options['locale']);
        }

        $metaData['selectedKey'] = $selectedKey;
        $metaData['originalKey'] = $originalKey;

        return new ErrorException(
            $message,
            isset($options['exceptionCode']) ? $options['exceptionCode'] : 500,
            $realKey,
            $params,
            $codeData['code'],
            $metaData,
            isset($options['previousException']) ? $options['previousException'] : null
        );
    }
    /**
     * @param array $options
     *
     * @return array
     */
    public function getErrorCodes(array $options = [])
    {
        /** @var TranslatorBagInterface $translator */
        $errorCodes      = [];
        $translator      = $this->getTranslator();
        $translatorIsBag = $translator instanceof TranslatorBagInterface;

        foreach ($this->getKeyCodeMapping() as $key => $map) {
            $code = isset($map['code']) ? $map['code'] : 0;
            $code = (int) $code;
            if (!isset($errorCodes[$code])) {
                $errorCodes[$code] = ['errors' => []];
            }
            unset($map['code']);
            $map['messages'] = [];
            if ($translatorIsBag) {
                $catalogue = $translator->getCatalogue($this->getLocale());
                $map['messages'][$catalogue->getLocale()] = $catalogue->get($key, 'errors');
            }
            $errorCodes[$code]['errors'][$key] = $map;
        }

        return $errorCodes;
    }
    /**
     * @param int   $code
     * @param array $options
     *
     * @return array
     */
    public function getErrorCode($code, array $options = [])
    {
        /** @var TranslatorBagInterface $translator */
        $translator      = $this->getTranslator();
        $translatorIsBag = $translator instanceof TranslatorBagInterface;
        $errorCode       = ['errors' => []];

        foreach ($this->getKeyCodeMapping() as $key => $map) {
            $_code = isset($map['code']) ? $map['code'] : 0;
            if ($_code !== $code) {
                continue;
            }
            unset($map['code']);
            $map['messages'] = [];
            if ($translatorIsBag) {
                $catalogue = $translator->getCatalogue($this->getLocale());
                $map['messages'][$catalogue->getLocale()] = $catalogue->get($key, 'errors');
            }
            $errorCode['errors'][$key] = $map;
        }

        return $errorCode;
    }
    /**
     * @param array|int $data
     *
     * @return array
     */
    protected function buildKeyCodeData($data)
    {
        if (!is_array($data)) {
            $data = ['code' => $data];
        }
        if (!isset($data['code'])) {
            $data['code'] = 0;
        }

        $data['code'] = (int) $data['code'];

        return $data;
    }
}
