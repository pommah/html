<?php
class Controller_Trajectory extends Authorized_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Trajectory();
    }

    function action_index(){
        $this->data['Trajectories'] = $this->model->get_Trajectories($this->get_user_university_id());
        $this->generateView('index');
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/trajectory/'.$viewName;
    }
}