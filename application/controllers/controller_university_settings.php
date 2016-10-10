<?php
class Controller_university_settings extends Controller
{
    public $data = [];

    function action_index()
    {
        $this->check_auth();
        if($this->auth) {
            $this->model = new model_university_settings();
            $user = $this->model->get_data_user();
            $menu = $this->model->get_menu_university();
            $regions = $this->model->get_region_names();
            $this->data = [
                "user" => $user,
                "menus" => $menu,
                "regions" => $regions
            ];
            $this->view->generate('', 'university_settings_view.php', $this->data);
        }else{
            header("Location: /");
        }
    }
}