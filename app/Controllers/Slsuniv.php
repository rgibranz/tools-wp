<?php

namespace App\Controllers;

use \Config\Database;

class Slsuniv extends BaseController
{

    private $slsuniv;

    public function __construct()
    {
        $this->slsuniv = new \App\Models\Slsuniv\Posts();
    }

    public function CourseEnrollment()
    {

        $course = $this->slsuniv->where('post_type', 'sfwd-courses')->where('post_status', 'publish')->findAll();
        var_dump($course);
    }
}
