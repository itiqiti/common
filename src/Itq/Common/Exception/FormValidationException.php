<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Exception;

use RuntimeException;
use Itq\Common\Traits;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class FormValidationException extends RuntimeException
{
    use Traits\PhpEngineTrait;
    /**
     * @var FormInterface
     */
    protected $form;
    /**
     * Construct the exception
     *
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        parent::__construct('Malformed data', 412);

        $this->form = $form;
    }
    /**
     * Return the underlying form.
     *
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }
    /**
     * @return array
     */
    public function getErrors()
    {
        $errors = [];

        $this->populateFormErrors($this->getForm(), $errors);

        return $errors;
    }
    /**
     * @return string
     */
    public function getErrorsAsString()
    {
        $t = 'Data validation errors: '.PHP_EOL;
        foreach ($this->getErrors() as $key => $errors) {
            $t .= sprintf('  %s:', !$key ? 'general' : $key).PHP_EOL;
            foreach ($errors as $error) {
                $t .= sprintf('    - %s', $error).PHP_EOL;
            }
        }

        return $t;
    }
    /**
     * @param FormInterface $form
     * @param array         $errors
     * @param null|string   $prefix
     */
    protected function populateFormErrors(FormInterface $form, &$errors, $prefix = null)
    {
        if (null !== $prefix) {
            $currentPrefix = ($prefix ? ($prefix.'.') : '').$form->getName();
        } else {
            $currentPrefix = '';
        }

        if (null !== $prefix) {
            foreach ($form->getErrors() as $error) {
                if (false === isset($errors[$currentPrefix])) {
                    $errors[$currentPrefix] = [];
                }
                if ($error instanceof FormError) {
                    $message = (string) $error->getMessage();
                } else {
                    $message = (string) $error;
                }
                $errors[$currentPrefix][] = $message;
                unset($message);
            }
        }

        foreach ($form->all() as $child) {
            $this->populateFormErrors($child, $errors, $currentPrefix);
        }
    }
}
