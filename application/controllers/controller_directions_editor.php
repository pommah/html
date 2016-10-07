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

    function action_addDirections(){
        $directions = explode(";", $_POST['directions']);
        include('modules/db.php');
        $prepareTable = $conn->prepare("DELETE FROM UniversityDirection WHERE ID_University = ?");
        //Todo Функция получения id университета
        $universityId = 1;
        $prepareTable->bindParam(1, $universityId);
        $prepareTable->execute();
        foreach ($directions as $direction){
            $query = $conn->prepare("INSERT INTO UniversityDirection (UniversityDirection.ID_University, UniversityDirection.ID_Direction) VALUES (?, ?)");
            $query->bindParam(1, $universityId);
            $query->bindParam(2, $direction);
            $query->execute();
        }
        echo "OK";
    }
}