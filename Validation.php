<?php

class Validation{
    function clean($str){
        $str = trim($str);
        $str = stripcslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }

    function fullname($username){
        $name_regex = "/^([a-zA-Z' ]+)$/";
        if (preg_match($name_regex, $username)) {
            return true;
        } else {
            return false;
        }
        
    }
}
?>