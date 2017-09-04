<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Plugin;

/**
 * Incoming Pollable Source Interface.
 *
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
interface IncomingPollableSourceInterface extends PollableSourceInterface
{
    /**
     * @return mixed
     */
    public function receive();
}
