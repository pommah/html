<?php
Class Controller_Report extends Authorized_Controller {
    public $data = [];
    public function __construct()
    {
        parent::__construct();
        if($this->auth!=UserTypes::MINISTRY) {
            header("Location: /");
        }
        else {
            $this->data['menu'] = parent::get_menu(UserTypes::MINISTRY);
        }
    }

    public function action_index()
    {
        echo $this->auth;
        $this->view->generate('report/general.php','common.php',$this->data);
    }
}