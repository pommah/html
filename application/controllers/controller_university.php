<?php
include 'application/controllers/controller_report.php';
class Controller_University extends Authorized_Controller
{
    public function  __construct()
    {
        parent::__construct();
        $this->model = new Model_University();
    }

    public function action_add(){
        if (array_key_exists('data', $_POST)) {
            $university = $_POST['data'];
            $data = explode(";", $university);
            echo $this->model->add_university($data[0], $data[1], $data[3], $data[2]);
        }
        else{
            $this->data['regions'] = $this->model->get_all_regions();
            $this->generateView('add');
        }
    }

    public function action_edit(){
        if (array_key_exists('universityData', $_POST)) {
            $university = $_POST['universityData'];
            $data = explode(";", $university);
            $universityId = 1;
            echo $this->model->update_university_data($data[0], $data[1], $data[2], $data[3], $universityId);
        }
        else{
            $this->data['university'] = $this->model->get_university_info();
            $this->data['regions'] = $this->model->get_region_names();
            $this->generateView('edit');
        }
    }

    public function action_index($type = 'all', $id = '1')
    {
        if (parent::get_user_type() == (UserTypes::MINISTRY || UserTypes::ADMIN)){
            if ($type == 'all'){
                $this->data['districts'] = $this->model->get_districts();
                $this->generateView('index');
            }else if($type == 'district'){
                $this->data['regions'] = $this->model->get_regions($id);
                $this->generateView('index_district');
            }else if($type == 'region'){
                $this->data['universities'] = $this->model->get_universities($id);
                $this->generateView('index_region');
            }
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/university/'.$viewName;
    }
}