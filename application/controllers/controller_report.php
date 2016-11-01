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
            $this->data['to'] = "/report/matrix/nozology_district";
            $this->data['colName'] = "Округ \\ Нозологическая группа";
            $this->data['nozology'] = $this->model->get_districts_by_nozology_group();
            $this->generateView('matrix_nozology');
        }
        else if($type == 'nozology_district'){
            $this->data['to'] = "/university/index/region";
            $this->data['colName'] = "Регион \\ Нозологическая группа";
            $this->data['nozology'] = $this->model->get_regions_by_nozology_group($district);
            $this->generateView('matrix_nozology');
        }
        else if ($type == 'ugsn'){
            $this->data['to'] = "direction";
            $this->data['ugsn'] = $this->model->get_ugsn_by_districts();
            $this->generateView('matrix_ugsn');
        }
        else if ($type == 'ugsn_lag'){
            $this->data['to'] = "direction_lag";
            $this->data['ugsn'] = $this->model->get_ugsn_lag_by_districts();
            $this->generateView('matrix_ugsn');
        }
        else if ($type == 'ugsn_expelled'){
            $this->data['to'] = "direction_expelled";
            $this->data['ugsn'] = $this->model->get_ugsn_expelled_by_districts();
            $this->generateView('matrix_ugsn');
        }
        else if ($type == 'direction'){
            $this->data['direction'] = $this->model->get_regions_by_directions($district, $ugsn);
            $this->generateView('matrix_directions');
        }
        else if ($type == 'direction_lag'){
            $this->data['direction'] = $this->model->get_regions_lag_by_directions($district, $ugsn);
            $this->generateView('matrix_directions');
        }
        else if ($type == 'direction_expelled'){
            $this->data['direction'] = $this->model->get_regions_expelled_by_directions($district, $ugsn);
            $this->generateView('matrix_directions');
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/report/' . $viewName;
    }

    public static function draw_pie($data, $entityName, $header, $colName, $colNum){
        $sum = 0;
        foreach ($data as $val){
            $sum+=$val[$colNum];
        }
        usort($data, function($a, $b) use($colNum){
            $diff = $b[$colNum] - $a[$colNum];
            return $diff > 0 ? 1 : ($diff < 0 ? -1 : 0);
        });

        $svg = "<svg style='width:300px; height: 300px; vertical-align: top; display: inline-block;' viewBox=\"0 0 100 100\">";
        $path = "";
        $text = "";
        $table = "<table style=' margin-left: 50px; display: inline-block;' class='studentList'><tr><th>Номер</th><th>Название</th><th>Цвет</th><th>Число</th><th>Проценты</th></tr>";
        $sumAngle = 90;
        $count = 0;
        foreach ($data as $val){
            $per = $val[$colNum] / $sum;
            $perStr = sprintf("%.2f", $per*100);
            $hint =  $val[$colName].$entityName." - ".$val[$colNum]." (".$perStr."%)";
            $textX = 0;
            $textY = 0;
            $color = '#607D8B';
            if ($count < 18){
                $color = Utils::$colors[$count];
            }
            if ($per<0.5){
                $x1 = 50 - 50*cos(deg2rad($sumAngle));
                $y1 = 50 - 50*sin(deg2rad($sumAngle));
                $sumAngle+= $per*360;
                $newX = 50 - 50*cos(deg2rad($sumAngle));
                $newY = 50 - 50*sin(deg2rad($sumAngle));
                if ($sumAngle > 445){
                    $newX = 50;
                    $newY = 0;
                }
                $textX = ($x1+$newX)/2;
                $textY = ($y1+$newY)/2;
                $path.=sprintf("<path fill='%s' d='M 50 50 L %d %d A 50 50 0 0 1 %d %d L 50 50' onmouseout='hideHint();' onmousemove='displayHint(event, \"%s\");' ></path>", $color, $x1, $y1, $newX, $newY, $hint);
            }else{
                $parts = $per/2;
                for ($i=1; $i<=2; $i++){
                    $x1 = 50 - 50*cos(deg2rad($sumAngle));
                    $y1 = 50 - 50*sin(deg2rad($sumAngle));
                    $sumAngle+= $parts*360;
                    $newX = 50 - 50*cos(deg2rad($sumAngle));
                    $newY = 50 - 50*sin(deg2rad($sumAngle));
                    if ($sumAngle > 445){
                        $newX = 50;
                        $newY = 0;
                    }
                    if ($i == 1){
                        $textX = ($x1+$newX)/2;
                        $textY = ($y1+$newY)/2;
                    }
                    $path.=sprintf("<path fill='%s' d='M 50 50 L %d %d A 50 50 0 0 1 %d %d L 50 50' onmouseout='hideHint();' onmousemove='displayHint(event, \"%s\");'></path>", $color, $x1, $y1, $newX, $newY, $hint);

                }
            }
            if ($sumAngle > 370 && $sumAngle < 450){
                $textY+=10;
            }else if($sumAngle > 90 && $sumAngle < 280){
                $textX-=10;
            }
            if ($per > 0.05){
            //$text.=sprintf("<text x='%d' y='%d' font-size='6px' fill='white'>%s</text>", $textX, $textY, $perStr."%");
            }
            $table.= sprintf("<tr><td>%s</td><td>%s</td><td style='background-color: %s;'></td><td>%s</td><td><strong>%s</strong></td></tr>", $count + 1, $val[$colName], $color, $val[$colNum], $perStr."%");
            $count++;
        }
        $table.="</table>";
        return "<div><h3>".$header."</h3>".$svg.$path.$text."</svg>".$table."</div>";
    }
}