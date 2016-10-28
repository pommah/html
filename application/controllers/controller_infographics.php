<?php
Class Controller_Infographics extends Authorized_Controller {
    public $data = [];
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Infographics();
        if($this->auth!=UserTypes::MINISTRY) {
            header("Location: /");
        }
        else {
            $this->data['menu'] = parent::get_menu(UserTypes::MINISTRY);
        }
    }

    public function action_index()
    {
        $this->data['statistic'] = $this->model->get_statistic_region();
        $this->view->generate('application/views/infographics/infographics_index.php','common.php',$this->data);
    }
}
?>