<?php
include 'application/core/utils.php';

Class Controller_Student extends Authorized_Controller {

    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Student();
    }

    function action_index($id = null) {
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
            $profile = $data[5] == 'null' ? null : $data[5];
            $planFile = $data[10] == 'null' ? null : $data[10];
            $rehabilitationFile = $data[11] == 'null' ? null : $data[11];
            echo $this->model->add_student_and_program($data[0], $data[1], $data[2], $data[3],$data[4], $profile, $data[6], $data[7], $data[8], $data[9], $planFile, $rehabilitationFile, $universityId);
        }else{
            $this->data['directions'] = $this->model->get_direction();
            $this->data['nozology'] = $this->model->get_nozoology_groups();
            $this->data['programs'] = $this->model->get_programs();
            $this->generateView('add');
        }
    }

    function action_edit($id = null){
        if (array_key_exists('currInfo', $_POST)) {
            $req = $_POST['currInfo'];
            $data = explode(";", $req);
            echo $this->model->edit_student_change_info($id, $data[0], $data[1], $data[2], $data[3]);
        } else if (array_key_exists('currEdit', $_POST)) {
            $req = $_POST['currEdit'];
            $data = explode(";", $req);
            $universityId = 1;
            $profile = $data[5] == 'null' ? null : $data[5];
            $planFile = $data[10] == 'null' ? null : $data[10];
            $rehabilitationFile = $data[11] == 'null' ? null : $data[11];
            echo $this->model->edit_student_change_program($id, $data[0], $data[1], $data[2], $data[3], $data[4], $profile, $data[6], $data[7], $data[8], $data[9], $planFile, $rehabilitationFile, $universityId, $data[12]);
        } else if (array_key_exists('currChange', $_POST)) {
            $req = $_POST['currChange'];
            $data = explode(";", $req);
            echo $this->model->edit_student_switch_program($id, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
        } else if (array_key_exists('saveNew', $_POST)) {
            $req = $_POST['saveNew'];
            $data = explode(";", $req);
            $universityId = 1;
            $profile = $data[5] == 'null' ? null : $data[5];
            $planFile = $data[10] == 'null' ? null : $data[10];
            $rehabilitationFile = $data[11] == 'null' ? null : $data[11];
            echo $this->model->edit_student_add_new_program($id, $data[0], $data[1], $data[2], $data[3], $data[4], $profile, $data[6], $data[7], $data[8], $data[9], $planFile, $rehabilitationFile, $universityId, $data[12]);
        } else{
            $student = $this->model->about_student($id);
            if($student) {
                $this->data['student'] = $student;
                $this->data['directions'] = $this->model->get_direction();
                $this->data['nozology'] = $this->model->get_nozoology_groups();
                $this->data['programs'] = $this->model->get_programs();
                $this->generateView('edit');
            }
        }
    }

    function action_info($id = null){
        $student = $this->model->about_student($id);
        if($student) {
            $this->data['student'] = $student;
            $this->generateView('info');
        }
    }
    function action_delete() {
        $id = $_POST['id'];
        $delete = $this->model->delete_student($id);
        echo $delete;
    }
    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/student/'.$viewName;
    }
    public function action_change_debt() {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $debts = $_POST['debts'];
        if(isset($_POST['file']))
            $file = $_POST['file'];
        else
            $file = null;
        $log = $this->model->changeDebt($id,$status,$debts,$file);
        exit($log);
    }

    public function action_add_debt() {
        $id = $_POST['id'];
        $log = $this->model->add_debt($id);
        exit($log);
    }
}