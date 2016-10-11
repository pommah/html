<?php
class Controller_direction extends Authorized_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Direction();
    }

    function action_index(){
        $universityId = 1;
        $this->data['content'] = $this->model->get_university_directions($universityId);
        $this->generateView('index');
    }

    function action_add(){
        $this->generateView('add');
    }

    function action_info(){
        $this->generateView('info');
    }

    function action_delete(){
        $this->generateView('delete');
    }

    function action_edit(){
        $this->generateView('edit');
    }

    function action_edit_all(){
        if (array_key_exists('directions', $_POST)){
            $selectedDirections = $_POST['directions'];
            $directions = explode(";", $selectedDirections);
            echo $this->model->update_directions($directions);
        }else{
            $universityId = 1;
            $this->data["directions"] = $this->model->get_university_directions_id($universityId);
            $this->data["all_directions"] = $this->model->get_direction();
            $this->generateView('edit_all');
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/direction/'.$viewName;
    }
}