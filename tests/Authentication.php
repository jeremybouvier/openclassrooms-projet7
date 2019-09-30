<?php


namespace App\Tests;


trait Authentication
{
    use RequestTrait;

    protected function getToken($user = 'user0', $password = 'pass0')
    {
        $response = $this->request(
            static::createClient(),
            'POST',
            '/api/login_check',
            ['username' => $user, 'password' => $password]
        );

        $json = json_decode($response->getContent(), true);
        return 'Bearer '. $json['token'];
    }
}