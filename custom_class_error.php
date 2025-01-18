<?php

class CustomErrorHandler extends Exception {
    private $number;


    public function __construct($number, $code = 0) {
        $this->number = $number; 
        $message = "$number is an invalid value"; 
        parent::__construct($message, $code); 
    }

}

function checkPositiveNumber($number) {
    if ($number <= 0) {
       
        throw new CustomErrorHandler($number, 1001);
    }
    echo "This is a positive number.";
}

try {
    checkPositiveNumber(0); 
} catch (CustomErrorHandler $e) {
    
    echo $e->getMessage(); 
}

?>
