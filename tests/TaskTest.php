<?php

namespace App\Tests;

use App\Entity\Status;
use App\Entity\Task;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @property \Faker\Generator $faker
 */
class TaskTest extends WebTestCase
{
    private $client;
    private $router;
    private $faker;
    protected static string $authToken;
    protected static int $taskId;
    protected function setUp(): void
    {
        $this->client = static::createClient(server: array(
            'CONTENT_TYPE' => 'application/json'
        ));

        $this->router = static::bootKernel()->getContainer()->get('router');
        $this->faker = Factory::create('fr_FR');

        self::ensureKernelShutdown();
    }

    public function testProtectedURL()
    {
        $this->client->request(method: 'GET', uri: $this->router->generate('app_task.index'));

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function testIncorrectAdmin()
    {
        $this->client->request(
            method: 'POST',
            uri: $this->router->generate('api_login_check'),
            content: json_encode([
                'username' => 'admin@admin.com',
                'password' => 'testpassword',
            ])
        );

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function testCorrectAdmin()
    {
        $this->client->request(
            method: 'POST',
            uri: $this->router->generate('api_login_check'),
            content: json_encode([
                'username' => 'admin@admin.com',
                'password' => 'password',
            ])
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        static::$authToken = sprintf('Bearer %s', json_decode($this->client->getResponse()->getContent(), true)['token']);
    }

    public function testAddTaskWithAdmin()
    {
        $this->client->setServerParameter('HTTP_AUTHORIZATION', static::$authToken);
        $this->client->request(
            method: 'POST',
            uri: $this->router->generate('app_task.new'),
            content: json_encode([
                'title' => $this->faker->jobTitle(),
                'description' => $this->faker->text(200),
                'status' => Status::PENDING,
                'user' => rand(1, 10),
            ])
        );

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        static::$taskId = json_decode($this->client->getResponse()->getContent(), true)['task_id'];
    }

    public function testUpdateTaskWithAdmin()
    {

        $this->client->setServerParameter('HTTP_AUTHORIZATION', static::$authToken);
        $this->client->request(
            method: 'PUT',
            uri: $this->router->generate('app_task.put', ['id' => static::$taskId]),
            content: json_encode([
                'title' => $this->faker->jobTitle(),
                'description' => $this->faker->text(200),
                'status' => Status::COMPLETED,
                'user' => rand(1, 10),
            ])
        );

        $this->assertEquals(202, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskWithAdmin()
    {

        $this->client->setServerParameter('HTTP_AUTHORIZATION', static::$authToken);
        $this->client->request(
            method: 'DELETE',
            uri: $this->router->generate('app_task.delete', ['id' => static::$taskId])
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::ensureKernelShutdown();
        $this->restoreExceptionHandler();
    }

    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn () => null);

            restore_exception_handler();

            if (null === $previousHandler) {
                break;
            }

            restore_exception_handler();
        }
    }
}
