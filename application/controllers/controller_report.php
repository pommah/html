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
        $this->data['generalInfo'] = $this->model->general_info();
        $this->view->generate('report/general.php','common.php',$this->data);
    }

    public function action_matrix($type = 'nozology', $district = '8', $ugsn = '010000'){
        if ($type == 'nozology'){
            $this->data['nozology'] = $this->model->get_regions_by_nozology_group();
            $this->generateView('matrix_nozology');
        }
        else if ($type == 'ugsn'){
            $this->data['ugsn'] = $this->model->get_ugsn_by_districts();
            $this->generateView('matrix_ugsn');
        }
        else if ($type == 'direction'){
            $this->data['direction'] = $this->model->get_regions_by_directions($district, $ugsn);
            $this->generateView('matrix_directions');
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/report/' . $viewName;
    }
}