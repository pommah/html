<?php

class Controller_Main extends Authorized_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function action_index()
    {
        if(!$this->auth) {
            $this->view->generate('', 'main_view.php');
        }
        else {
            $location = '';
            switch ($this->auth) {
                case 2: $location='/student'; break;
                case 1: $location='/university'; break;
            }
            header("Location: ".$location);
        }
    }
}