<?php
class Utils
{
    public static $forms =["Очная", "Заочная", "Очно-заочная", "Дистанционная"];
    public static $levels = ["Бакалавриат", "Магистратура", "Специалитет"];
    public static $colors = ['#F44336','#9C27B0','#673AB7','#3F51B5', '#2196F3',
        '#009688','#8BC34A','#FF9800', '#795548','#9E9E9E', '#E91E63', '#03A9F4',
        '#00BCD4', '#4CAF50', '#CDDC39', '#FFEB3B', '#FFC107', '#FF5722'];
    public  static $nozology = [1=>"Нарушение зрения",2=>"Нарушение слуха",3=>"Поражение опорно-двигательного аппарата"];


    public static function dotDirect($id) {
        return substr($id, 0, 2).".".substr($id, 2, 2).".".substr($id, 4, 2);
    }
}
