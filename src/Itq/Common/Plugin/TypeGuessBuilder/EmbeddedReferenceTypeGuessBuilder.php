<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Plugin\TypeGuessBuilder;

use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class EmbeddedReferenceTypeGuessBuilder extends Base\AbstractTypeGuessBuilder
{
    /**
     * @param array $definition
     * @param array $options
     *
     * @return TypeGuess
     */
    public function build(array $definition, array $options = [])
    {
        return new TypeGuess(
            'text',
            ['constraints' => new Length(['min' => 1, 'max' => 50, 'groups' => ['create', 'update']])],
            Guess::HIGH_CONFIDENCE
        );
    }
}
