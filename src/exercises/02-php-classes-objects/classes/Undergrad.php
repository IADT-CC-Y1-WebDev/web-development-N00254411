<?php
require_once __DIR__ . '/student.php';
class Undergrad extends Student {
    protected $Course;
    protected $year;
    public function __construct($name, $number, $course, $year) {
        parent::__construct($name, $number);
        $this->Course = $course;
        $this->year = $year;
    }

    public function getCourse() {
        return $this->Course;
    }
    public function getYear() {
        return $this->year;
    }

    public function __toString() {
        return "Undergrad: " . parent::__toString() . ", Course: {$this->Course}, Year: {$this->year}";
    }
}
?>