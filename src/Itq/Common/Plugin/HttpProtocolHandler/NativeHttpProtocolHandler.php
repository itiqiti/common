<?php

/*
 * This file is part of the COMMON package.
 *
 * (c) itiQiti SAS <opensource@itiqiti.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itq\Common\Plugin\HttpProtocolHandler;

use Itq\Common\Plugin\Base\AbstractPlugin;
use Itq\Common\Plugin\HttpProtocolHandlerInterface;

/**
 * @author itiQiti Dev Team <opensource@itiqiti.com>
 */
class NativeHttpProtocolHandler extends AbstractPlugin implements HttpProtocolHandlerInterface
{
    /**
     * @param string $protocol
     * @param string $domain
     * @param string $uri
     * @param string $data
     * @param array  $headers
     * @param array  $options
     *
     * @return array
     *
     * @throws \Exception
     */
    public function request($protocol, $domain, $uri, $data, array $headers = [], array $options = [])
    {
        if (!count($headers)) {
            throw $this->createNotYetImplementedException(sprintf('request headers (%s)', json_encode($headers)));
        }

        $result = file_get_contents(sprintf('%s://%s%s', $protocol, $domain, $uri));

        return ['statusCode' => 200, 'statusMessage' => 'OK', 'content' => $result];
    }
}