<?php
Class Controller_Student extends Controller {
    function action_index($data = null) {
        $this->check_auth();
        if($this->auth && $data) {

        }
    }
}