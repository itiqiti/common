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

use Itq\Common\Bag;
use Itq\Common\Event;
use Itq\Common\Traits;
use Itq\Common\Service;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\Event as BaseEvent;

/**
 * Event Service.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class EventService
{
    use Traits\ServiceTrait;
    use Traits\ServiceAware\ActionServiceAwareTrait;
    use Traits\ServiceAware\ContextServiceAwareTrait;
    /**
     * @param Service\ActionService  $actionService
     * @param Service\ContextService $contextService
     */
    public function __construct(Service\ActionService $actionService, Service\ContextService $contextService)
    {
        $this->setActionService($actionService);
        $this->setContextService($contextService);
    }
    /**
     * @param string $eventName
     * @param string $name
     * @param array  $params
     * @param array  $options
     *
     * @return $this
     */
    public function register($eventName, $name, array $params = [], array $options = [])
    {
        $this->pushArrayParameterKeyItem('sequences', $eventName, ['name' => $name, 'params' => $params, 'options' => $options]);

        return $this;
    }
    /**
     * @param string $eventName
     *
     * @return array
     */
    public function getSequence($eventName)
    {
        return $this->getArrayParameterListKey('sequences', $eventName);
    }
    /**
     * @return array
     */
    public function getSequences()
    {
        return $this->getArrayParameter('sequences');
    }
    /**
     * @param BaseEvent $event
     * @param string    $eventName
     *
     * @return void
     */
    public function consume(BaseEvent $event, $eventName)
    {
        $params  = new Bag();
        $context = new Bag(['eventName' => $eventName, 'event' => $event, 'globalContext' => $this->getContextService()]);

        if ($event instanceof Event\DocumentEvent) {
            $context->set('doc', $event->getData());
        } elseif ($event instanceof GenericEvent) {
            $context->set('doc', $event->getSubject());
        }

        $this->getActionService()->executeBulk($this->getSequence($eventName), $params, $context);
    }
}
