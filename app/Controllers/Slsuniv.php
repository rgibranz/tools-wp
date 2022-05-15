<?php

namespace App\Controllers;

use \Config\Database;

class Slsuniv extends BaseController
{

    private $posts;
    private $usermeta;

    public function __construct()
    {
        $this->posts = new \App\Models\Slsuniv\Posts();
        $this->usermeta = new \App\Models\Slsuniv\Usermeta();
    }

    public function CourseEnrollment()
    {
        $course = $this->posts->where('post_type', 'sfwd-courses')->where('post_status', 'publish')->findAll();
        return view('slsuniv/CourseEnrollment', ['course' => $course]);
    }

    public function ExportCourseEnrollment()
    {
        $post_id = $this->request->getPost('post_id');

        $course = $this->posts->find($post_id);

        $db = db_connect('slsuniv');
        $query = $db->query("SELECT * FROM wpkv_usermeta JOIN wpkv_users ON wpkv_users.id = wpkv_usermeta.user_id WHERE wpkv_usermeta.meta_key = 'course_" . $post_id . "_access_from'");

        $hasil = $query->getResult();

        var_dump($hasil);
        var_dump($course);
    }
}
