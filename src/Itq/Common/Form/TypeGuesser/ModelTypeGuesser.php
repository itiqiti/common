<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Form\TypeGuesser;

use Itq\Common\Traits;
use Itq\Common\Service;

use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Form\Guess\ValueGuess;
use Symfony\Component\Form\FormTypeGuesserInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class ModelTypeGuesser implements FormTypeGuesserInterface
{
    use Traits\ServiceTrait;
    use Traits\ServiceAware\MetaDataServiceAwareTrait;
    use Traits\ServiceAware\TypeGuessServiceAwareTrait;
    /**
     * @param Service\MetaDataService  $metaDataService
     * @param Service\TypeGuessService $typeGuessService
     */
    public function __construct(Service\MetaDataService $metaDataService, Service\TypeGuessService $typeGuessService)
    {
        $this->setMetaDataService($metaDataService);
        $this->setTypeGuessService($typeGuessService);
    }
    /**
     * @param string $class
     * @param string $property
     *
     * @return TypeGuess
     */
    public function guessType($class, $property)
    {
        if (!$this->getMetaDataService()->isModel($class)) {
            return null;
        }

        $options      = ['operation' => 'create', 'class' => $class, 'property' => $property];
        $propertyType = $this->getMetaDataService()->getModelPropertyType($class, $property);
        $type         = 'unknown';

        if (null !== $propertyType) {
            $type = isset($propertyType['modelType']) ? $propertyType['modelType'] : $propertyType['type'];
        }

        return $this->getTypeGuessService()->create($type, $propertyType, $options);
    }
    /**
     * @param string $class
     * @param string $property
     *
     * @return ValueGuess
     */
    public function guessRequired($class, $property)
    {
        if (!$this->getMetaDataService()->isModel($class)) {
            return null;
        }

        return new ValueGuess(true, Guess::LOW_CONFIDENCE);
    }
    /**
     * @param string $class
     * @param string $property
     *
     * @return ValueGuess
     */
    public function guessMaxLength($class, $property)
    {
        if (!$this->getMetaDataService()->isModel($class)) {
            return null;
        }

        return new ValueGuess(null, Guess::LOW_CONFIDENCE);
    }
    /**
     * @param string $class
     * @param string $property
     *
     * @return ValueGuess
     */
    public function guessPattern($class, $property)
    {
        if (!$this->getMetaDataService()->isModel($class)) {
            return null;
        }

        return new ValueGuess(null, Guess::LOW_CONFIDENCE);
    }
}
