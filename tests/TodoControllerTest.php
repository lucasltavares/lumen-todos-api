<?php

class TodoControllerTest extends TestCase
{
    use \Laravel\Lumen\Testing\DatabaseMigrations;

    public function testUserCanCreateTodo()
    {
        // Prepare
        $payload = [
          'title' => 'Eat food',
          'description' => 'Eat some fresh food.'
        ];

        // Act
        $result = $this->post('/todos', $payload);

        // Assert
        $result->assertResponseStatus(201);

        $result->seeInDatabase('todos', $payload); // Check payload data on database.
    }

    public function testUserShouldSendData()
    {
        // Prepare
        $payload = [
            'alotof' => 'nothing'
        ];

        // Act
        $response = $this->post('/todos', $payload);

        // Assert
        $response->assertResponseStatus(422); // UNPROCESSABLE ENTITY.
    }

    public function testUserCanRetrieveData()
    {

        // Prepare
        $todo = \App\Models\Todo::factory()->create();

        // Act
        $uri = '/todos/' . $todo->id;
        $response = $this->get($uri);

        // Assert
        $response->assertResponseOk();
        $response->seeJsonContains(['title' => $todo->title]);
    }
}
