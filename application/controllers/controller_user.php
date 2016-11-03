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

    public function action_get_universitys() {
        $array = [];
        $array = $this->model->get_universitys();
        $univer = json_encode($array,JSON_UNESCAPED_UNICODE);
        echo $univer;
    }

    public function action_index()
    {
        $this->data['users'] = $this->model->get_all_users();
        $this->generateView('index');
    }

    public function action_info($id){
        $this->data['userData'] = $this->model->get_user_data($id);
        $this->generateView('info');
    }

    public function action_edit($id){
        if (array_key_exists('userdata', $_POST)) {
            $userData = $_POST['userdata'];
            $dataArray = explode(";", $userData);
            echo $this->model->update_user_data($dataArray);
        }else{
            $this->data['userData'] = $this->model->get_user_data($id);
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