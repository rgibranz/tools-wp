<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Paspres extends BaseController
{
    private $db;
    private $posts;
    public function __construct()
    {
        $this->db = \Config\Database::connect('paspreslocal');
        $this->posts = $this->db->table('posts');
    }

    public function enroll()
    {
        $kelas = $this->posts->where('post_type', 'courses')->get()->getResultArray();



        return view('paspres/enroll', ['kelas' => $kelas]);
    }
}
