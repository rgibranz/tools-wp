<?php

namespace App\Controllers;

use \Config\Database;

class Slsuniv extends BaseController
{

    private $slsuniv;

    public function __construct()
    {
        $this->slsuniv = Database::connect('slsuniv');
    }

    public function CourseEnrollment()
    {

        $course = $this->slsuniv->table('wpkv_posts')
            ->select('ID,post_title')
            ->where('post_type', 'sfwd-courses')
            ->where('post_status', 'publish')
            ->get();
        var_dump($course->getResult());
    }
}
