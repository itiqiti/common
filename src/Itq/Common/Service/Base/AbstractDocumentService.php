<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Service\Base;

use Itq\Common\Event;

/**
 * Abstract Document Service.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
abstract class AbstractDocumentService extends AbstractDocService
{
    /**
     * @return int
     */
    public function getExpectedTypeCount()
    {
        return 1;
    }
    /**
     * Trigger the specified document event if listener are registered.
     *
     * @param string $event
     * @param mixed  $data
     *
     * @return $this
     */
    protected function event($event, $data = null)
    {
        return $this->dispatch($this->buildEventName($event), new Event\DocumentEvent($data, ['event' => $event]));
    }
    /**
     * @param string $operation
     * @param mixed  $model
     * @param array  $options
     *
     * @return $this
     */
    protected function applyBusinessRules($operation, $model, array $options = [])
    {
        $this->getBusinessRuleService()->executeBusinessRulesForModelOperation(
            $this->getModelName(),
            $operation,
            $model,
            $options
        );

        return $this;
    }
    /**
     * @param mixed $model
     * @param array $options
     *
     * @return bool
     */
    protected function hasActiveWorkflows($model, array $options = [])
    {
        foreach ($this->getMetaDataService()->getModelWorkflows($model) as $property => $definition) {
            if (!isset($model->$property)) {
                continue;
            }

            return true;
        }

        unset($options);

        return false;
    }
    /**
     * @param mixed $model
     * @param array $options
     *
     * @return bool
     */
    protected function getActiveWorkflowsRequiredFields($model, array $options = [])
    {
        $requiredFields = [];

        foreach ($this->getMetaDataService()->getModelWorkflows($model) as $property => $definition) {
            if (!isset($model->$property)) {
                continue;
            }

            if (isset($definition['requiredFields'])) {
                if (!is_array($definition['requiredFields'])) {
                    $definition['requiredFields'] = [$definition['requiredFields']];
                }
                $requiredFields = array_merge($requiredFields, $definition['requiredFields']);
            }
        }

        $requiredFields = array_unique($requiredFields);

        sort($requiredFields);

        unset($options);

        return $requiredFields;
    }
    /**
     * @param mixed $model
     * @param mixed $previousModel
     * @param array $options
     *
     * @return array
     */
    protected function applyActiveWorkflows($model, $previousModel, array $options = [])
    {
        $transitions = [];

        foreach ($this->getMetaDataService()->getModelWorkflows($model) as $property => $definition) {
            if (!isset($model->$property)) {
                continue;
            }
            $transitions = array_merge(
                $transitions,
                $this->getWorkflowService()->transitionModelProperty(
                    $this->getModelName(),
                    $model,
                    $property,
                    $previousModel,
                    $definition['id'],
                    $options
                )
            );
        }

        return $transitions;
    }
}
