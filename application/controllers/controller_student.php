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
        if (array_key_exists('student', $_POST)) {
            $student = $_POST['student'];
            $data = explode(";", $student);
            echo $this->model->add_student_to_programm($data[0], $data[1], $data[2], $data[3], $data[4]);
        }else if(array_key_exists('student_and_program', $_POST)){
            $studentProgram = $_POST['student_and_program'];
            $data = explode(";", $studentProgram);
            $universityId = 1;
            echo $this->model->add_student_and_program($data[0], $data[1], $data[2], $data[3],$data[4], $data[5], $data[6], $universityId, $data[7], $data[8]);
        }else{
            $this->data['directions'] = $this->model->get_direction();
            $this->data['nozoology'] = $this->model->get_nozoology_groups();
            $this->data['programs'] = $this->model->get_programs();
            $this->generateView('add');
        }
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