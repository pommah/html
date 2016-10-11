<?php
class Controller_University extends Authorized_Controller
{
    public function  __construct()
    {
        parent::__construct();
        $this->model = new Model_University();
    }

    public function action_edit(){
        $this->data['regions'] = $this->model->get_region_names();
        $this->generateView('edit');
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/university/'.$viewName;
    }
}