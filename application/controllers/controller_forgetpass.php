<?php

class Controller_Forgetpass extends Controller
{

    function action_index()
    {
        if(!$this->auth) {
            $this->view->generate('', 'forgetpass_view.php');
            $menu = Model_Control::get_menu_university();
        }
    }
}