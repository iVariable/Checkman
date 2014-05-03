<?php
/**
 * Created by PhpStorm.
 * User: vladimirsavenkov
 * Date: 03/05/14
 * Time: 17:33
 */
namespace Checkman\RESTCheckmanBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AbstractWebTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client $client
     */
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();

//        $fixtures = array('Checkman\CheckmanBundle\DataFixtures\Test\LoadTestData');
//        $this->loadFixtures($fixtures);
    }

    protected function simpleResponseTest($route, $answer, $description = '')
    {
        $this->logInAsAdmin();

        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $content = $response->getContent();

        $this->assertJsonResponse($response, 200);

        $this->assertEquals($answer, $content, $description);
    }

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode,
            $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    protected function logInAsAdmin()
    {
        $this->client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => 'Admin',
                'PHP_AUTH_PW' => 'Admin',
            ]
        );
    }
}