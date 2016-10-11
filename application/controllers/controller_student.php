<?php
Class Controller_Student extends Authorized_Controller {

    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Student();
    }

    function action_index() {
        $this->data['students'] = $this->model->getStudents();
        $this->generateView('index');
    }

    function action_add(){
        $this->generateView('add');
    }

    function action_edit($id = null){
        $student = $this->model->about_student($id);
        if($student) {
            $this->data['student'] = $student;
            $this->generateView('edit');
        }
    }

    function action_info($id = null){
        $student = $this->model->about_student($id);
        if($student) {
            $this->data['student'] = $student;
            $this->generateView('info');
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/student/'.$viewName;
    }
}