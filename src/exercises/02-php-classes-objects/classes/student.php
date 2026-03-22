<?php
class Student {
    protected $name;
    protected $number;

    public function __construct($name, $number){
        $this->name = $name;
        $this->number = $number;
        if (empty($number)) {
            throw new Exception("Student number cannot be empty");
        }
    }
    // public function __destruct() {
    //     echo " Destroying student:  {$this->name}<br>";
    // }   
    public function getName() {
        return $this->name;
    }
    public function getNumber() {
        return $this->number;
    }
    public function __toString() {
        return " Student: " . $this->name . " (" . $this->number . ")";
    }
}  
?> 