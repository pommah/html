<?php
class Controller {
    public $model;
    public $view;
    protected $auth;
    function __construct()
    {
        $this -> view = new View();
    }
    function action_index()
    {
    }
}
?>