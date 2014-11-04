<?php

class ViewHelper
{

    public static function printError($name)
    {
        if(isset($_SESSION[$name.'_error']))
        {
            for($i = 0; $i < count($_SESSION[$name.'_error']);$i++)
            {
                echo '<div class="error">'.$_SESSION[$name.'_error'][$i].'</div>';
            }
            unset($_SESSION[$name.'_error']);
        }
    }

    public static function printSuccess($name)
    {
        if(isset($_SESSION[$name.'_success']))
        {
            for($i = 0; $i < count($_SESSION[$name.'_success']);$i++)
            {
                echo '<div class="success">'.$_SESSION[$name.'_success'][$i].'</div>';
            }
            unset($_SESSION[$name.'_success']);
        }
    }

    public static function printMessages($name) {
        ViewHelper::printError($name);
        ViewHelper::printSuccess($name);
    }

    public static function printHour(){
        $currentTime = time();
        if (date("i") >= 55)
        {
            $hour = date("H", ($currentTime + 3600));
        } else {
            $hour = date("H");
        }
        return $hour;
    }

    public static function printMinute(){
        if (date("i") >= 55)
        {
            $minute = "00";
        } else {
            $minute = 5 * ceil((date("i")+1) / 5);
        }
        return str_pad($minute, 2, 0, STR_PAD_LEFT);
    }

    public static function printDate(){
        if (date("i") >= 55 && date("H") == 23){
            return date("d/m/Y", time() + 3600);
        } else {
            return date("d/m/Y");
        }
    }
    
    public static function printDateTime() 
    {
        if (date("i") >= 55 && date("H") == 23){
            return date("d/m/Y H:i", time() + 3600);
        } else {
            return date("d/m/Y H:i");
        }
    }
    
    public static function generateHTMLSelectOptions($list, $attributes = array()) {
        $html = "";
        $attributeList = "";
        
        foreach ($attributes as $key => $value) {
            $attributeList .= $key . '="' . $value . '" ';
        }
        
        foreach ($list as $item) {
            $html .= "<option ". $attributeList .">". $item ."</option>";
        }
        
        return $html;
    }

    public static function generateRandomColor() 
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}

?>
