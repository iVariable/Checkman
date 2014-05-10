<?php
/**
 * Created by PhpStorm.
 * User: vladimirsavenkov
 * Date: 03/05/14
 * Time: 17:33
 */
namespace Checkman\RESTCheckmanBundle\Tests\Controller;


class EmployeeControllerTest extends AbstractWebTestCase
{

    public function testGetAllAction()
    {
        $answer = '[{"id":1,"firstName":"1","secondName":"orn1","salary":10000,"notes":"","status":1,"projects":[1,2],"region_id":1,"occupations":[1]},{"id":2,"firstName":"2","secondName":"orn2","salary":20000,"notes":"","status":1,"projects":[3],"region_id":1,"occupations":[1]},{"id":3,"firstName":"1","secondName":"tgn1","salary":30000,"notes":"","status":1,"projects":[4,5,6],"region_id":2,"occupations":[1]},{"id":4,"firstName":"2","secondName":"tgn2","salary":40000,"notes":"","status":1,"projects":[7],"region_id":2,"occupations":[1]},{"id":5,"firstName":"2","secondName":"tgn3","salary":40000,"notes":"","status":1,"projects":[8,9],"region_id":2,"occupations":[1]},{"id":6,"firstName":"2","secondName":"tgn4","salary":50000,"notes":"","status":1,"projects":[10],"region_id":2,"occupations":[1]},{"id":7,"firstName":"1","secondName":"nsk","salary":60000,"notes":"","status":1,"projects":[11,12,13],"region_id":3,"occupations":[1]},{"id":8,"firstName":"2","secondName":"nsk","salary":13,"notes":"","status":1,"projects":[14],"region_id":3,"occupations":[1]}]';
        $route = $this->getUrl('api_v1_get_employees', array('_format' => 'json'));
        $this->simpleResponseTest($route, $answer, 'Got correct users');
    }

    public function testGetEmployeeAction()
    {
        $answer = '{"id":1,"firstName":"1","secondName":"orn1","salary":10000,"notes":"","status":1,"projects":[1,2],"region_id":1,"occupations":[1]}';
        $route = $this->getUrl('api_v1_get_employee', array('id' => 1, '_format' => 'json'));
        $this->simpleResponseTest($route, $answer, 'Got correct user');
    }

    public function testGetProjectHistoryAction()
    {
        $answer = '[{"id":"1","title":"yandex.ru","dates":[{"start":"'.date('Y-m-d').'","end":false}]},{"id":"2","title":"google.com","dates":[{"start":"'.date('Y-m-d').'","end":false}]}]';
        $route = $this->getUrl('api_v1_get_employee_projectshistory', array('id' => 1, '_format' => 'json'));
        $this->simpleResponseTest($route, $answer, 'Got correct project history');
    }

    public function testPostEmployeeAction()
    {
        $answer = '{"id":9,"firstName":"Test","secondName":"Test","salary":9999,"notes":"Notes","status":1,"projects":[],"region_id":1,"occupations":[1]}';
        $route = $this->getUrl('api_v1_post_employees', array('_format' => 'json'));

        $this->logInAsAdmin();

        $this->client->request(
            'POST',
            $route,
            [
                "firstName" => "Test",
                "notes" => "Notes",
                "occupations" => [1],
                "region_id" => "1",
                "salary" => "9999",
                "secondName" => "Test",
                "status" => "1",
            ]
        );
        $response = $this->client->getResponse();
        $content = $response->getContent();

        $this->assertJsonResponse($response, 200);

        $this->assertEquals($answer, $content, 'New employee created');
    }

    public function testPutEmployeeAction()
    {
        $answer = '{"id":9,"firstName":"Test2","secondName":"Test","salary":9999,"notes":"Notes2","status":1,"projects":[],"region_id":1,"occupations":[2]}';
        $route = $this->getUrl('api_v1_put_employee', array("id" => 9, '_format' => 'json'));

        $this->logInAsAdmin();

        $this->client->request(
            'PUT',
            $route,
            [
                "id" => 9,
                "firstName" => "Test2",
                "notes" => "Notes2",
                "occupations" => [2],
                "region_id" => "1",
                "salary" => "9999",
                "secondName" => "Test",
                "status" => "1",
            ]
        );
        $response = $this->client->getResponse();
        $content = $response->getContent();

        $this->assertJsonResponse($response, 200);

        $this->assertEquals($answer, $content, 'Employee modified');
    }

    public function testDeleteEmployeeAction()
    {
        $answer = '{"firstName":"Test2","secondName":"Test","salary":9999,"notes":"Notes2","status":1,"projects":[],"region_id":1,"occupations":[]}';
        $route = $this->getUrl('api_v1_delete_employee', array("id" => 9, '_format' => 'json'));

        $this->logInAsAdmin();

        $this->client->request(
            'DELETE',
            $route
        );
        $response = $this->client->getResponse();
        $content = $response->getContent();

        $this->assertJsonResponse($response, 200);

        $this->assertEquals($answer, $content, 'Employee deleted');

        $route = $this->getUrl('api_v1_get_employee', array('id' => 9, '_format' => 'json'));
        $this->client->request(
            'GET',
            $route
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();

        $this->assertJsonResponse($response, 204);
    }

}