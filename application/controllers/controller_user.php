<?php
class Controller_User extends Authorized_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_User();
    }

    public function action_add()
    {
        $this->generateView('add');
    }

    public function action_add_user() {
        $name = $_POST['name'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $permission = $_POST['permission'];
        $university = '';
        if(isset($_POST['university'])) {
        $university = $_POST['university'];
        }
        echo $this->model->add_user($name,$login,$password,$email,$permission,$university);
    }

    public function action_get_universities() {
        $array = [];
        $array = $this->model->get_universities();
        $univer = json_encode($array,JSON_UNESCAPED_UNICODE);
        echo $univer;
    }

    public function action_index()
    {
        $this->data['users'] = $this->model->get_all_users();
        $this->generateView('index');
    }

    public function action_info($id = null){
        if ($id == null){
            $this->data['userData'] = $this->model->get_user_data_by_login($_SESSION['login']);
        }
        else{
            $this->data['userData'] = $this->model->get_user_data($id);
        }
        $this->generateView('info');
    }

    public function action_edit($id = null){
        if (array_key_exists('userdata', $_POST)) {
            $userData = $_POST['userdata'];
            $dataArray = explode(";", $userData);
            echo $this->model->update_user_data($dataArray);
        }else{
            if ($id != null){
                $this->data['userData'] = $this->model->get_user_data($id);
            }
            else{
                $this->data['userData'] = $this->model->get_user_data_by_login($_SESSION['login']);
            }
            $this->generateView('edit');
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/user/'.$viewName;
    }
}