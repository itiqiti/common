<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Controller\Base;

use Itq\Common\Traits;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
abstract class AbstractController implements ContainerAwareInterface
{
    use Traits\RequestHelperTrait;
    use Traits\Thrower\BaseThrowerTrait;
    use Traits\Controller\LocaleControllerTrait;
    use Traits\Controller\SymfonyControllerTrait;
    use Traits\Controller\CallbackControllerTrait;
    use Traits\Thrower\MalformedExceptionThrowerTrait;
    use Traits\Controller\RequestStackAwareControllerTrait;
    use Traits\Controller\ServiceAware\RequestServiceAwareControllerTrait;
    use Traits\Controller\ServiceAware\ResponseServiceAwareControllerTrait;
    use Traits\Controller\ServiceAware\ExceptionServiceAwareControllerTrait;
    use Traits\Controller\ServiceAware\DataFilterServiceAwareControllerTrait;
}
