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
        //Todo Функция получения id университета
        $universityId = 1;
        $this->data['content'] = $this->model->get_university_directions($universityId);
        $this->content = "application/views/control_modules/directions.php";
        $this->view->generate($this->content, 'control_view.php', $this->data);

    }
    public  function action_students($id = null) {
        $this->defaultAction=false;
        if(!$this->index)
            $this->action_index();
        $this->data['menus']['selected']="students";
        if(!$id) {
            $this->content = 'application/views/control_modules/student_list.php';
            $this->data['students'] = $this->model->getStudents();
            $this->view->generate($this->content, 'control_view.php', $this->data);
        }
        else {
            $student = $this->model->about_student($id);
            if($student) {
                $this->data['student'] = $student;
                $this->content = 'application/views/control_modules/student.php';
                $this->view->generate($this->content, 'control_view.php', $this->data);
            }
        }
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
    public function action_settings(){
        header("Location: /university_settings");
    }
}