<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

trait RequestTrait
{
    /**
     * création de la requète http avec les paramètres serveur souhaités
     * @param string|array|null $content
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @return Response
     */
    protected function request($client, string $method, string $uri, $content = null, array $headers = []): Response
    {
        $server = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'content-type') {
                $server['CONTENT_TYPE'] = $value;
                $server['HTTP_ACCEPT'] = $value;

                continue;
            }
            $server['HTTP_'.strtoupper(str_replace('-', '_', $key))] = $value;
        }

        if (is_array($content) && false !== preg_match('#^application/(?:.+\+)?json$#', $server['CONTENT_TYPE'])) {
            $content = json_encode($content);
        }

        $client->request($method, $uri, [], [], $server, $content);

        return $client->getResponse();
    }
}
