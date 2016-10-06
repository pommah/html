<?php

class Controller_directions_editor extends Controller
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
            $this->model = new model_directions_editor();
            $user = $this->model->get_data_user();
            //Todo Функция получения id университета
            $universityId = 1;
            $this->data = [
                "user" => $user,
                "directions" => $this->model->get_university_directions_id($universityId),
                "all_directions" => $this->model->get_direction()
            ];
            $this->view->generate($this->content, 'directions_editor_view.php', $this->data);
            $this->index = true;
            if($this->defaultAction) {

            }
        }
        else {
            header("Location: /");
        }
    }
}