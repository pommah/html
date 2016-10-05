<?php

class Controller_Control extends Controller
{
    public $data = [];
    public $content;
    public $index =false;
    public $defaultAction=true;
    protected $mod;
    function action_index()
    {
        $this->check_auth();
        if($this->auth) {
            $this->model = new Model_Control();
            $user = $this->model->get_data_user();
            switch($this->auth) {
                case 1: $this->content = 'application/views/control_modules/admin_view.php';

                        break;
                case 2: $this->content = 'application/views/control_modules/template_view.php';
                        $menu = $this->model->get_menu_university();
                        break;
                default: $this->content = null;
                        break;
            }
            $this->data = [
                "user" => $user,
                "menus" => $menu
            ];
            $this->index = true;
            if($this->defaultAction) {
                $this->action_direction();
            }
        }
        else {
            header("Location: /");
        }
    }
    public function  action_direction() {
        $this->defaultAction=false;
        if(!$this->index)
            $this->action_index();
        $this->data['content'] = $this->model->get_direction();
        $this->content = "application/views/control_modules/directions.php";
        $this->view->generate($this->content, 'control_view.php', $this->data);

    }
    public  function action_students() {
        $this->defaultAction=false;
        if(!$this->index)
            $this->action_index();
        $this->data['menus']['selected']="students";
        $this->content = 'application/views/control_modules/student_list.php';
        $this->data['students'] = $this->getStudents();
        $this->view->generate($this->content, 'control_view.php', $this->data);
    }
    public function action_add_student() {
        $this->defaultAction=false;
        if(!$this->index)
            $this->action_index();
        $this->data['menus']['selected']="add_student";
        $this->content = 'application/views/control_modules/add_student.php';
        //$this->data['students'] = $this->getStudents();
        $this->view->generate($this->content, 'control_view.php', $this->data);
    }
    public function action_exit() {
        $this->destroy_session();
    }
    private function getStudents(){
        $list = [];
        include('modules/db.php');
        $req = $conn->prepare("SELECT Student.Name, NozologyGroup.Name AS \"NozologyGroup\", Direction.Name 
          AS \"Direction\", Student.DateBegin, Student.DateEnd, ProgramStudent.NameFile
	      FROM ((Student INNER JOIN NozologyGroup ON Student.ID_NozologyGroup=NozologyGroup.ID) INNER JOIN 
	      ProgramStudent ON Student.ID_Prog = ProgramStudent.ID) INNER JOIN Direction ON Direction.ID = 
	      ProgramStudent.ID_Direction
          WHERE ProgramStudent.ID_University = ?");
        $universityId = 1;
        $req->bindParam(1, $universityId);
        $req->execute();
        $list = $req->fetchAll(PDO::FETCH_NAMED);
        return $list;
    }
}