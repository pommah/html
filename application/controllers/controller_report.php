<?php
include 'application/core/utils.php';
Class Controller_Report extends Authorized_Controller {
    public $data = [];
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Report();
        if($this->auth!=UserTypes::MINISTRY) {
            header("Location: /");
        }
        else {
            $this->data['menu'] = parent::get_menu(UserTypes::MINISTRY);
        }
    }

    public function action_index()
    {
        $this->data['generalInfo'] = $this->model->general_info();
        $this->data['pie_region'] = $this->model->get_stud_by_districts_for_pie();
        $this->data['pie_nozology'] = $this->model->get_stud_by_nozology_for_pie();
        $this->data['pie_year'] = $this->model->get_stud_by_year_for_pie();
        $this->data['pie_level'] = $this->model->get_stud_by_level_for_pie();
        $this->data['pie_form'] = $this->model->get_stud_by_form_for_pie();
        $this->generateView('general');
    }

    public function action_matrix($type = 'nozology', $district = '8', $ugsn = '010000'){
        if ($type == 'nozology'){
            $this->data['nozology'] = $this->model->get_regions_by_nozology_group();
            $this->generateView('matrix_nozology');
        }
        else if ($type == 'ugsn'){
            $this->data['ugsn'] = $this->model->get_ugsn_by_districts();
            $this->generateView('matrix_ugsn');
        }
        else if ($type == 'direction'){
            $this->data['direction'] = $this->model->get_regions_by_directions($district, $ugsn);
            $this->generateView('matrix_directions');
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/report/' . $viewName;
    }

    public static function cmp($a, $b)
    {
        $diff = $b['count'] - $a['count'];
        return $diff > 0 ? 1 : ($diff < 0 ? -1 : 0);
    }

    public static function draw_pie($data, $entityName, $header){
        $sum = 0;
        foreach ($data as $val){
            $sum+=$val['count'];
        }
        usort($data, "Controller_Report::cmp");
        $svg = "<svg style='width:300px; height: 300px;' viewBox=\"0 0 100 100\">";
        $table = "<table class='studentList'><tr><th>Номер</th><th>Название</th><th>Цвет</th><th>Число</th><th>Проценты</th></tr>";
        $sumAngle = 90;
        $count = 0;
        foreach ($data as $val){
            $per = $val['count'] / $sum;
            $x1 = 50 - 50*cos(deg2rad($sumAngle));
            $y1 = 50 - 50*sin(deg2rad($sumAngle));
            $sumAngle+= $per*360;
            $newX = 50 - 50*cos(deg2rad($sumAngle));
            $newY = 50 - 50*sin(deg2rad($sumAngle));
            $perStr = sprintf("%.2f", $per*100);
            $hint =  $val['Name'].$entityName." - ".$val['count']." (".$perStr."%)";
            $svg.=sprintf("<path fill='%s' d='M 50 50 L %d %d A 50 50 0 0 1 %d %d L 50 50'><title>%s</title></path>", Utils::$colors[$count], $x1, $y1, $newX, $newY, $hint);
            $table.= sprintf("<tr><td>%s</td><td>%s</td><td style='background-color: %s;'></td><td>%s</td><td>%s</td></tr>", $count + 1, $val['Name'], Utils::$colors[$count], $val['count'], $perStr);
            $count++;
        }
        $svg.="</svg>";
        $table.="</table>";
        return "<div style='width: 350px; display: inline-block;'><h3>".$header."</h3>".$svg.$table."</div>";
    }
}