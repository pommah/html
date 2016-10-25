<?php
Class Controller_Report extends Authorized_Controller {
    public $data = [];
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Report();
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

    public function action_matrix($type = 'nozology'){
        if ($type == 'nozology'){
            $this->data['nozology'] = $this->model->get_regions_by_nozology_group();
            $this->generateView('matrix_nozology');
        }
        else if ($type == 'ugsn'){
            $this->data['all_ugsn'] = $this->model->get_all_ugsn();
            $this->data['ugsn'] = $this->model->get_regions_by_ugsn();
            $this->generateView('matrix_ugsn');
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/report/' . $viewName;
    }
}