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

use Closure;
use Exception;
use Itq\Common\Event;
use Itq\Common\Traits;

/**
 * Abstract Sub Document Service.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
abstract class AbstractSubDocumentService extends AbstractDocService
{
    use Traits\ServiceAware\CollectionServiceAwareTrait;
    /**
     * @return int
     */
    public function getExpectedTypeCount()
    {
        return 2;
    }
    /**
     * Trigger the specified document event if listener are registered.
     *
     * @param mixed  $parentId
     * @param string $event
     * @param mixed  $data
     *
     * @return $this
     */
    protected function event($parentId, $event, $data = null)
    {
        return $this->dispatch(
            $this->buildEventName($event),
            new Event\DocumentEvent($data, $this->buildTypeVars([$parentId]))
        );
    }
    /**
     * @param string $parentId
     * @param string $operation
     * @param mixed  $model
     * @param array  $options
     *
     * @return $this
     */
    protected function applyBusinessRules($parentId, $operation, $model, array $options = [])
    {
        $this->getBusinessRuleService()->executeBusinessRulesForModelOperation(
            $this->getModelName(),
            $operation,
            $model,
            $this->buildTypeVars([$parentId]) + $options
        );

        return $this;
    }
    /**
     * @param string $parentId
     * @param mixed  $model
     * @param array  $options
     *
     * @return bool
     */
    protected function hasActiveWorkflows($parentId, $model, array $options = [])
    {
        foreach ($this->getMetaDataService()->getModelWorkflows($model) as $property => $definition) {
            if (!isset($model->$property)) {
                continue;
            }

            return true;
        }

        unset($parentId, $options);

        return false;
    }
    /**
     * @param string $parentId
     * @param mixed  $model
     * @param array  $options
     *
     * @return bool
     */
    protected function getActiveWorkflowsRequiredFields($parentId, $model, array $options = [])
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

        unset($options, $parentId);

        return $requiredFields;
    }
    /**
     * @param string $parentId
     * @param mixed  $model
     * @param mixed  $previousModel
     * @param array  $options
     *
     * @return array
     */
    protected function applyActiveWorkflows($parentId, $model, $previousModel, array $options = [])
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
                    $this->buildTypeVars([$parentId]) + $options
                )
            );
        }

        return $transitions;
    }
    /**
     * @param array   $items
     * @param array   $criteria
     * @param array   $fields
     * @param Closure $eachCallback
     * @param array   $options
     *
     * @return $this
     *
     * @throws Exception
     */
    protected function filterItems(&$items, $criteria = [], $fields = [], Closure $eachCallback = null, $options = [])
    {
        $this->getCollectionService()->filter($items, $criteria, $fields, $eachCallback, $options);

        return $this;
    }
    /**
     * @param array $items
     * @param int   $limit
     * @param int   $offset
     * @param array $options
     *
     * @return $this
     */
    protected function paginateItems(&$items, $limit, $offset, $options = [])
    {
        $this->getCollectionService()->paginate($items, $limit, $offset, $options);

        return $this;
    }
    /**
     * @param array $items
     * @param array $sorts
     * @param array $options
     *
     * @return $this
     */
    protected function sortItems(&$items, $sorts = [], $options = [])
    {
        $this->getCollectionService()->sort($items, $sorts, $options);

        return $this;
    }
}
