<?php
include 'application/core/utils.php';
include_once "application/core/OlFile.php";
Class Controller_Report extends Authorized_Controller {
    public $data = [];
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Report();
        if($this->auth != (UserTypes::MINISTRY || UserTypes::ADMIN)) {
            header("Location: /");
        }
        else {
            $this->data['menu'] = parent::get_menu(parent::get_user_type());
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
        $this->data['diag_prog'] = $this->model->get_program_nozology();
        $this->generateView('general');
    }

    public function action_matrix($type = 'nozology', $arg1 = null, $arg2 = null){
        if ($type == 'nozology'){
            $this->data['to'] = "/report/matrix/nozology_district";
            $this->data['colName'] = "Округ \\ Нозологическая группа";
            $this->data['nozology'] = $this->model->get_districts_by_nozology_group();
            $this->generateView('matrix_nozology');
        }
        else if($type == 'nozology_district'){
            $this->data['to'] = "/report/matrix/nozology_region";
            $this->data['colName'] = "Регион \\ Нозологическая группа";
            $this->data['nozology'] = $this->model->get_regions_by_nozology_group($arg1);
            $this->generateView('matrix_nozology');
        }
        else if($type == 'nozology_region'){
            $this->data['to'] = "/student/index";
            $this->data['colName'] = "Университет \\ Нозологическая группа";
            $this->data['nozology'] = $this->model->get_universities_by_nozology_group($arg1);
            $this->generateView('matrix_nozology');
        }
        else if ($type == 'ugsn'){
            $this->data['to'] = "direction";
            $this->data['header'] = "УГСН \\ Округ";
            $this->data['data'] = $this->model->get_ugsn_by_districts();
            $this->generateView('matrix_directions');
        }
        else if ($type == 'ugsn_lag'){
            $this->data['to'] = "direction_lag";
            $this->data['header'] = "УГСН \\ Округ";
            $this->data['data'] = $this->model->get_ugsn_lag_by_districts();
            $this->generateView('matrix_directions');
        }
        else if ($type == 'ugsn_expelled'){
            $this->data['to'] = "direction_expelled";
            $this->data['header'] = "УГСН \\ Округ";
            $this->data['data'] = $this->model->get_ugsn_expelled_by_districts();
            $this->generateView('matrix_directions');
        }
        else if ($type == 'direction'){
            $this->data['to'] = "/report/matrix/university";
            $this->data['header'] = "Регион \\ Направления";
            $this->data['data'] = $this->model->get_regions_by_directions($arg1, $arg2);
            $this->generateView('matrix_directions');
        }
        else if ($type == 'direction_lag'){
            $this->data['to'] = "/report/matrix/university_lag";
            $this->data['header'] = "Регион \\ Направления";
            $this->data['data'] = $this->model->get_regions_lag_by_directions($arg1, $arg2);
            $this->generateView('matrix_directions');
        }
        else if ($type == 'direction_expelled'){
            $this->data['to'] = "/report/matrix/university_expelled";
            $this->data['header'] = "Регион \\ Направления";
            $this->data['data'] = $this->model->get_regions_expelled_by_directions($arg1, $arg2);
            $this->generateView('matrix_directions');
        }
        else if ($type == 'university'){
            $this->data['to'] = "/student/index";
            $this->data['header'] = "Университет \\ Направление";
            $this->data['data'] = $this->model->get_universities_by_direction($arg1, $arg2);
            $this->generateView('matrix_directions');
        }
        else if ($type == 'university_lag'){
            $this->data['to'] = "/student/index";
            $this->data['header'] = "Университет \\ Направление";
            $this->data['data'] = $this->model->get_universities_lag_by_direction($arg1, $arg2);
            $this->generateView('matrix_directions');
        }
        else if ($type == 'university_expelled'){
            $this->data['to'] = "/student/index";
            $this->data['header'] = "Университет \\ Направление";
            $this->data['data'] = $this->model->get_universities_expelled_by_direction($arg1, $arg2);
            $this->generateView('matrix_directions');
        }
    }

    public function action_ugsn_district($target = 'all', $export = null, $separator = 'libre'){
        if ($target == 'all'){
            $this->data['values'] = $this->model->report_all_ugsn_district();
            if ($export == null){
                $this->data['header'] = "Все студенты по ФО и УГСН";
                $this->generateView('exportable');
            }
            else{
                $data = $this->report_to_csv($this->data['values'], $separator);
                $this->give_file($data, "ugsn_district");
            }
        }
        else if ($target == 'lag'){
            $this->data['values'] = $this->model->report_ugsn_district('Задолженность');
            if ($export == null){
                $this->data['header'] = "Неуспевающие студенты по ФО и УГСН";
                $this->generateView('exportable');
            }
            else{
                $data = $this->report_to_csv($this->data['values'], $separator);
                $this->give_file($data, "ugsn_district_lag");
            }
        }
        else if ($target == 'expelled'){
            $this->data['values'] = $this->model->report_ugsn_district('Отчислен');
            if ($export == null){
                $this->data['header'] = "Отчисленные студенты по ФО и УГСН";
                $this->generateView('exportable');
            }
            else{
                $data = $this->report_to_csv($this->data['values'], $separator);
                $this->give_file($data, "ugsn_district_expel");
            }
        }
        else if ($target == 'export'){
            $data = $this->report_to_csv($this->model->report_all_ugsn_district(), $separator);
            $this->give_file($data, "ugsn_district");
        }
    }

    public function action_region_direction($target = 'all', $export = null, $separator = 'libre'){
        $this->data['ugsns'] = $this->model->get_all_ugsn();
        $this->data['districts'] = $this->model->get_all_districts();
        $this->query_data_for_report($target);
        if ($target == 'all'){
            if ($export == null){
                $this->data['header'] = "Все студенты по регионам и направлениям";
                $this->generateView('exportable');
            }
            else{
                $data = $this->report_to_csv($this->data['values'], $separator);
                $this->give_file($data, "region_direction");
            }
        }
        else if ($target == 'lag'){
            if ($export == null){
                $this->data['header'] = "Неуспевающие студенты по регионам и направлениям";
                $this->generateView('exportable');
            }
            else{
                $data = $this->report_to_csv($this->data['values'], $separator);
                $this->give_file($data, "region_direction_lag");
            }
        }
        else if ($target == 'expelled'){
            if ($export == null){
                $this->data['header'] = "Отчисленные студенты по регионам и направлениям";
                $this->generateView('exportable');
            }
            else{
                $data = $this->report_to_csv($this->data['values'], $separator);
                $this->give_file($data, "region_direction_expel");
            }
        }
        else if ($target == 'export'){
            $this->query_data_for_report('all');
            $data = $this->report_to_csv($this->data['values'], $separator);
            $this->give_file($data, "region_direction");
        }
    }

    public function query_data_for_report($type = 'all'){
        if (isset($_POST['district'])){
            $district = $_POST['district'];
            $ugsn = $_POST['ugsn'];
            $this->data['district'] = $district;
            $this->data['ugsn'] = $ugsn;

            $ugsn = $ugsn == 'all'?'%':$ugsn;
            $district = $district == 'all'?"%":$district;

            if ($type == 'all'){
                $this->data['values'] = $this->model->report_all_direction_region_filtered($ugsn, $district);
            }
            else if($type == 'lag'){
                $this->data['values'] = $this->model->report_direction_region_filtered('Задолженность', $ugsn, $district);
            }
            else if ($type == 'expelled'){
                $this->data['values'] = $this->model->report_direction_region_filtered('Отчислен', $ugsn, $district);
            }
        }
        else{
            if ($type == 'all'){
                $this->data['values'] = $this->model->report_all_direction_region();
            }
            else if($type == 'lag'){
                $this->data['values'] = $this->model->report_direction_region('Задолженность');
            }
            else if ($type == 'expelled'){
                $this->data['values'] = $this->model->report_direction_region('Отчислен');
            }
        }
    }

    public function action_region_nozology($export = null, $separator = 'libre'){
        $this->data['values'] = $this->model->report_region_nozology();
        if ($export == null){
            $this->data['header'] = "Все студенты по регионам и нозологическим группам";
            $this->generateView('exportable');
        }
        else{
            $data = $this->report_to_csv($this->data['values'], $separator);
            $this->give_file($data, "region_nozology");
        }
    }

    public function action_ugsn_nozology($export = null, $separator = 'libre'){
        $this->data['values'] = $this->model->report_ugsn_nozology();
        if ($export == null){
            $this->data['header'] = "Все студенты по УГСН и нозологическим группам";
            $this->generateView('exportable');
        }
        else{
            $data = $this->report_to_csv($this->data['values'], $separator);
            $this->give_file($data, "ugsn_nozology");
        }
    }

    private function generateView($actionName){
        $this->view->generate($this->getViewPath($actionName.'.php'), 'common.php', $this->data);
    }

    private function getViewPath($viewName){
        return 'application/views/report/' . $viewName;
    }

    private function give_file($data, $prefix){
        $now = new DateTime('NOW');
        $prefix = $now->format("H:i:s d.m.Y ").$prefix;
        $olFile = new OlFile($prefix.".csv");
        $olFile->createAndUpload($data);
    }

    private function report_to_csv($data, $separator){
        $sep = ",";
        if ($separator == 'excel'){
            $sep = ";";
        }
        $csv = "";
        $firstval =  $data['0']['rowName'];
        $count = 0;
        while ($data[$count]['rowName'] == $firstval){
            $csv.=$sep."\"".$data[$count]['colName']."\"";
            $count++;
        }
        for($i=0; $i < count($data); $i+=$count) {
            $csv .= "\n\"".$data[$i]['rowName']."\"";
            for ($j = 0; $j < $count; $j++) {
                $csv .= $sep . $data[$i + $j]['value'];
            }
        }
        return $csv;
    }

    public static function draw_pie($data, $entityName, $header, $colName, $colNum){
        $sum = 0;
        foreach ($data as $val){
            $sum+=$val[$colNum];
        }
        if ($sum == 0){
            return "";
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
            list($sumAngle, $textX, $textY, $path) = self::drawSegmentNew($per, $sumAngle, $color, $hint, $path);
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
        return "<div><div class='title'>".$header."</div><br>".$svg.$path.$text."</svg>".$table."</div>";
    }

    private static function drawSegment($per, $sumAngle, $color, $hint, $path):array
    {
        if ($per < 0.5) {
            $x1 = 50 - 50 * cos(deg2rad($sumAngle));
            $y1 = 50 - 50 * sin(deg2rad($sumAngle));
            $sumAngle += $per * 360;
            $newX = 50 - 50 * cos(deg2rad($sumAngle));
            $newY = 50 - 50 * sin(deg2rad($sumAngle));
            if ($sumAngle > 445) {
                $newX = 50;
                $newY = 0;
            }
            $textX = ($x1 + $newX) / 2;
            $textY = ($y1 + $newY) / 2;
            $path .= sprintf("<path fill='%s' d='M 50 50 L %d %d A 50 50 0 0 1 %d %d L 50 50' onmouseout='hideHint();' onmousemove='displayHint(event, \"%s\");' ></path>", $color, $x1, $y1, $newX, $newY, $hint);
            return array($sumAngle, $textX, $textY, $path);
        } else {
            $parts = $per / 2;
            for ($i = 1; $i <= 2; $i++) {
                $x1 = 50 - 50 * cos(deg2rad($sumAngle));
                $y1 = 50 - 50 * sin(deg2rad($sumAngle));
                $sumAngle += $parts * 360;
                $newX = 50 - 50 * cos(deg2rad($sumAngle));
                $newY = 50 - 50 * sin(deg2rad($sumAngle));
                if ($sumAngle > 445) {
                    $newX = 50;
                    $newY = 0;
                }
                if ($i == 1) {
                    $textX = ($x1 + $newX) / 2;
                    $textY = ($y1 + $newY) / 2;
                }
                $path .= sprintf("<path fill='%s' d='M 50 50 L %d %d A 50 50 0 0 1 %d %d L 50 50' onmouseout='hideHint();' onmousemove='displayHint(event, \"%s\");'></path>", $color, $x1, $y1, $newX, $newY, $hint);

            }
            return array($sumAngle, $textX, $textY, $path);
        }
    }

    private static function drawSegmentNew($per, $sumAngle, $color, $hint, $path):array
    {
        $startAngle = $sumAngle - 90;
        if ($startAngle < 0){
            $startAngle += 360;
        }
        $sweepAngle = $per * 360;
        $sumAngle += $sweepAngle;

        $largeArc = $sweepAngle > 180 ? 1 : 0;

        $a1 = deg2rad($startAngle);
        $a2 = deg2rad($startAngle + $sweepAngle);

        $cx = 50 + sin(deg2rad($startAngle + $sweepAngle/2)) * 3;
        $cy = 50 - cos(deg2rad($startAngle + $sweepAngle/2)) * 3;
        $rx = 40;
        $ry = 40;

        $x1 = $cx + $rx * sin($a1);
        $y1 = $cy - $ry * cos($a1);

        $x2 = $cx + $rx * sin($a2);
        $y2 = $cy - $ry * cos($a2);

        $textX = 0;
        $textY = 0;

        $path .= sprintf("<path fill='%s' d='M %d %d A %d %d 0 %d 1 %d %d L %d %d z' onmouseout='hideHint();' onmousemove='displayHint(event, \"%s\");' ></path>",
                $color, $x1, $y1, $rx, $ry, $largeArc, $x2, $y2, $cx, $cy, $hint);
        return array($sumAngle, $textX, $textY, $path);
    }
}
