<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends WebTestCase
{
    use RequestTrait;
    use Authentication;

    /**
     * test de l'Authentification réussi
     */
    public function testGoodAuthentication()
    {
        $response = $this->request(
            static::createClient(),
            'POST',
            '/api/login_check',
            ['username'=>'user0', 'password'=>'pass0']
        );
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * test d'une erreur lors de l'Authentification
     */
    public function testBadAuthentication()
    {
        $response = $this->request(
            static::createClient(),
            'POST',
            '/api/login_check',
            ['username'=>'user', 'password'=>'pass']
        );
        $this->assertEquals(401, $response->getStatusCode());
    }

    /**
     * test recupération de la liste des utilisateurs
     */
    public function testRetrieveCustomerList()
    {
        $response = $this->request(
            static::createClient(),
            'GET',
            '/api/customers',
            [],
            ['Authorization' => $this->getToken(), 'content-type' => 'application/hal+json']
        );

        $json = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/hal+json; charset=utf-8', $response->headers->get('Content-Type'));
        $this->assertEquals(50, $json['totalItems']);
        $this->assertEquals(20, $json['itemsPerPage']);
    }

    /**
     * test récupération d'un utilisateur
     */
    public function testRetrieveCustomer()
    {
        $response = $this->request(
            static::createClient(),
            'GET',
            '/api/customers/1',
            [],
            ['Authorization' => $this->getToken(), 'content-type' => 'application/hal+json']
        );

        $json = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/hal+json; charset=utf-8', $response->headers->get('Content-Type'));
        $this->assertArrayHasKey('_links', $json);
        $this->assertArrayNotHasKey('totalItems', $json);
        $this->assertArrayHasKey('firstName', $json);
        $this->assertArrayHasKey('lastName', $json);
        $this->assertArrayHasKey('email', $json);
        $this->assertArrayHasKey('address', $json);
        $this->assertArrayHasKey('city', $json);
        $this->assertArrayHasKey('zipCode', $json);
    }

    /**
     * test récupération d'un utilisateur après filtrage
     */
    public function testRetrieveFilteredCustomer()
    {
        $response = $this->request(
            static::createClient(),
            'GET',
            '/api/customers?firstName=customer0&zipCode=20290',
            [],
            ['Authorization' => $this->getToken(), 'content-type' => 'application/hal+json']
        );

        $json = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/hal+json; charset=utf-8', $response->headers->get('Content-Type'));
        $this->assertEquals(1, $json['totalItems']);
    }

    /**
     * test d'ajout d'un utilisateur
     */
    public function testAddCustomer()
    {
        $response = $this->request(
            static::createClient(),
            'POST',
            '/api/customers',
            [
                'firstName' => 'testFirstName',
                'lastName' => 'testLastName',
                'email' => 'test@email.com',
                'address' => 'testaddress',
                'city' => 'testCity',
                'zipCode' => 1111
            ],
            ['Authorization' => $this->getToken(), 'content-type' => 'application/ld+json']
        );

        $this->assertEquals(201, $response->getStatusCode());
        $response = $this->request(
            static::createClient(),
            'GET',
            '/api/customers?firstName=testFirstName',
            [],
            ['Authorization' => $this->getToken(), 'content-type' => 'application/hal+json']
        );
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->getContent(), true);
        $this->assertEquals('application/hal+json; charset=utf-8', $response->headers->get('Content-Type'));
        $this->assertEquals(1, $json['totalItems']);
    }

    /**
     * test de suppression d'un utilisateur
     */
    public function testDeleteCustomer()
    {
        $response = $this->request(
            static::createClient(),
            'DELETE',
            '/api/customers/50',
            [],
            ['Authorization' => $this->getToken(), 'content-type' => 'application/ld+json']
        );
        $this->assertEquals(204, $response->getStatusCode());
    }

}