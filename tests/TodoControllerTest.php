<?php

use App\Models\Todo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
class TodoControllerTest extends TestCase
{
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
        $todo = Todo::factory()->create();

        // Act
        $uri = '/todos/' . $todo->id;
        $response = $this->get($uri);

        // Assert
        $response->assertResponseStatus(200);
        $response->seeJsonContains(['title' => $todo->title]);
    }

    public function testUserShouldReceive404() {
        //Prepare


        //Act
        $response = $this->get('/todos/1');

        //Assert
        $response->assertResponseStatus(404);
        $response->seeJsonContains(["message" => "Record not found"]);
    }

    public function testUserCanDelete() {
        // Prepare
        $todo = Todo::factory()->create();

        // Act
        $uri = '/todos/' . $todo->id;
        $response = $this->delete($uri);

        // Assert
        $response->assertResponseStatus(204);
    }

    public function testUserCanSetTodoDone() {
        // Prepare
        $todo = Todo::factory()->create();

        // Act
        $uri = '/todos/' . $todo->id . '/status/done';
        $response = $this->post($uri);

        // Assert
        $response->assertResponseStatus(200);
        $response->seeInDatabase('todos', [
            'id' => $todo->id,
            'done' => true
        ]);
    }
}
