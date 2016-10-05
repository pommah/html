<?php

class Controller_Main extends Controller
{

    function action_index()
    {
        if(!$this->auth) {
            $this->view->generate('', 'main_view.php');
        }
    }
}