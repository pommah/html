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
        if ($this->get_user_type() == UserTypes::UNIVERSITY){
            echo "Asd";
            $this->data['students'] = $this->model->getStudents($this->get_user_university_id());
        }
        else{
            $this->data['students'] = $this->model->getStudents($id);
        }
        $this->generateView('index');
    }

    function action_add(){
        if (array_key_exists('student', $_POST)) {
            $student = $_POST['student'];
            $data = explode(";", $student);

            include_once "application/core/OlFile.php";
            $rehabilitationFile = $this->check_files('fileRehabilitation',"files/rehabilitation");
            $psychoFile = $this->check_files('filePsycho',"files/psychology");
            $careerFile = $this->check_files('fileCareer',"files/career");
            $employmentFile = $this->check_files('fileEmployment',"files/employment");
            $distanceFile = $this->check_files('fileDistance',"files/distance");
            $portfolioFile = $this->check_files('filePortfolio',"files/portfolio");

            echo $this->model->add_student_to_programm($data[0], $data[1], $data[2], $data[3], $rehabilitationFile, $data[4], $psychoFile, $careerFile, $employmentFile, $distanceFile, $portfolioFile);
        }else if(array_key_exists('student_and_program', $_POST)){
            $studentProgram = $_POST['student_and_program'];
            $data = explode(";", $studentProgram);
            $universityId = parent::get_user_university_id();
            $profile = $data[5] == 'null' ? null : $data[5];

            include_once "application/core/OlFile.php";
            $rehabilitationFile = $this->check_files('fileRehabilitation',"files/rehabilitation");
            $psychoFile = $this->check_files('filePsycho',"files/psychology");
            $careerFile = $this->check_files('fileCareer',"files/career");
            $employmentFile = $this->check_files('fileEmployment',"files/employment");
            $distanceFile = $this->check_files('fileDistance',"files/distance");
            $portfolioFile = $this->check_files('filePortfolio',"files/portfolio");
            $programFile = $this->check_files('fileProgram',"files/programs");
            $planFile = $this->check_files('filePlan',"files/plans");

            echo $this->model->add_student_and_program($data[0], $data[1], $data[2], $data[3], $rehabilitationFile,
                $data[4], $profile, $data[6], $data[7], $data[8], $programFile, $planFile, $universityId, $psychoFile,
                $careerFile, $employmentFile, $distanceFile, $portfolioFile);
        }else{
            $this->data['directions'] = $this->model->get_university_direction($this->get_user_university_id());
            $this->data['nozology'] = $this->model->get_nozoology_groups();
            $this->data['programs'] = $this->model->get_programs();
            $this->generateView('add');
        }
    }

    function check_files($post, $path) {
        if(isset($_POST[$post])) {
            $file=$_POST[$post];
            $olFile = new OlFile(null, $path);
            return $olFile->saveFile($file);
        }
        else
            return null;
    }

    function action_edit($id = null){
        if (array_key_exists('currInfo', $_POST)) {
            $req = $_POST['currInfo'];
            $data = explode(";", $req);
            $rehabilitationFile = $data[4] == 'null' ? null : $data[4];
            echo $this->model->edit_student_change_info($id, $data[0], $data[1], $data[2], $data[3], $rehabilitationFile);
        } else if (array_key_exists('currEdit', $_POST)) {
            $req = $_POST['currEdit'];
            $data = explode(";", $req);
            $universityId = 1;
            $profile = $data[6] == 'null' ? null : $data[6];
            $planFile = $data[11] == 'null' ? null : $data[11];
            $rehabilitationFile = $data[4] == 'null' ? null : $data[4];
            echo $this->model->edit_student_change_program($id, $data[0], $data[1], $data[2], $data[3], $rehabilitationFile, $data[5], $profile, $data[7], $data[8], $data[9], $data[10], $planFile, $universityId, $data[12]);
        } else if (array_key_exists('currChange', $_POST)) {
            $req = $_POST['currChange'];
            $data = explode(";", $req);
            $rehabilitationFile = $data[4] == 'null' ? null : $data[4];
            echo $this->model->edit_student_switch_program($id, $data[0], $data[1], $data[2], $data[3], $rehabilitationFile, $data[5], $data[6]);
        } else if (array_key_exists('saveNew', $_POST)) {
            $req = $_POST['saveNew'];
            $data = explode(";", $req);
            $universityId = 1;
            $profile = $data[6] == 'null' ? null : $data[6];
            $planFile = $data[11] == 'null' ? null : $data[11];
            $rehabilitationFile = $data[4] == 'null' ? null : $data[4];
            echo $this->model->edit_student_add_new_program($id, $data[0], $data[1], $data[2], $data[3], $rehabilitationFile, $data[5], $profile, $data[7], $data[8], $data[9], $data[10], $planFile, $universityId, $data[12]);
        } else{
            $student = $this->model->about_student($id);
            if($student) {
                $this->data['student'] = $student;
                $this->data['directions'] = $this->model->get_university_direction($this->get_user_university_id());
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
        $adapts = $_POST['adapts'];
        if(isset($_POST['file']))
            $file = $_POST['file'];
        else
            $file = null;
        $log = $this->model->changeDebt($id,$status,$debts,$adapts,$file);
        exit($log);
    }

    public function action_add_debt() {
        $id = $_POST['id'];
        $log = $this->model->add_debt($id);
        exit($log);
    }
}