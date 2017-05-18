<?php

//require_once (__DIR__.'/../phpunit-6.1.3.phar');
//require_once (__DIR__.'/../application/core/route.php');

//Execution phpunit --bootstrap application/core/route.php tests/RouteTest.php

use PHPUnit\Framework\TestCase;

final class RouteTest extends TestCase
{

    public function testDefaultAction(){
        $_SERVER['REQUEST_URI'] = '127.0.0.1/student';
        $controller_name = '';
        $action_name = '';
        $model_name = '';
        $data = [];

        Route::getControllerModelAndActionNames($controller_name, $action_name, $model_name, $data);

        $this->assertEquals('Controller_student', $controller_name);
        $this->assertEquals('Model_student', $model_name);
        $this->assertEquals('action_index', $action_name);
    }

    public function testAction(){
        $_SERVER['REQUEST_URI'] = '127.0.0.1/student/add';
        $controller_name = '';
        $action_name = '';
        $model_name = '';
        $data = [];

        Route::getControllerModelAndActionNames($controller_name, $action_name, $model_name, $data);

        $this->assertEquals('Controller_student', $controller_name);
        $this->assertEquals('Model_student', $model_name);
        $this->assertEquals('action_add', $action_name);
    }

    public function testActionWithOneParam(){
        $_SERVER['REQUEST_URI'] = '127.0.0.1/student/info/1';
        $controller_name = '';
        $action_name = '';
        $model_name = '';
        $data = [];

        Route::getControllerModelAndActionNames($controller_name, $action_name, $model_name, $data);

        $this->assertEquals('Controller_student', $controller_name);
        $this->assertEquals('Model_student', $model_name);
        $this->assertEquals('action_info', $action_name);
        $this->assertEquals('1', $data[0]);
    }

    public function testActionWithTwoParams(){
        $_SERVER['REQUEST_URI'] = '127.0.0.1/university/test/1/2/3';
        $controller_name = '';
        $action_name = '';
        $model_name = '';
        $data = [];

        Route::getControllerModelAndActionNames($controller_name, $action_name, $model_name, $data);

        $this->assertEquals('Controller_university', $controller_name);
        $this->assertEquals('Model_university', $model_name);
        $this->assertEquals('action_test', $action_name);
        $this->assertEquals('1', $data[0]);
        $this->assertEquals('2', $data[1]);
        $this->assertEquals('3', $data[2]);
    }
}
