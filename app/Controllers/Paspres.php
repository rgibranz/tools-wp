<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Paspres extends BaseController
{
    private $db;
    private $posts;
    private $users;
    private $usermeta;
    public function __construct()
    {
        $this->db       = \Config\Database::connect('paspreslocal');
        $this->posts    = $this->db->table('posts');
        $this->users    = $this->db->table('users');
        $this->usermeta = $this->db->table('usermeta');
    }

    public function enroll()
    {
        $kelas = $this->posts->where('post_type', 'courses')->get()->getResultArray();

        return view('paspres/enroll', ['kelas' => $kelas]);
    }

    public function dienroll()
    {
        $post_id = $this->request->getPost('post_id');
        $file = $this->request->getFile('file');

        // init arai hasil
        $hasil = [];

        // membaca file uploadan
        $handle = fopen($file->getTempName(), "r");
        $i = 0;

        // perulangan enrol
        while (($row = fgetcsv($handle, 2048))) {
            $i++;
            if ($i == 1) continue;

            // mengambil email user dari csv
            $user_email = $row[3];

            //mengambil data user dari database
            $user = $this->users->select('ID,user_email')->where('user_email', $user_email)->get()->getRow();

            if ($user == null) { // mengecek apakah user ada
                array_push($hasil, [
                    'email'  => $user_email,
                    'status' => 'tidak bisa',
                    'ket'    => 'user tidak ada di database'
                ]);
                continue;
            }

            //mengambil data enrol dari post 
            $enrol = $this->posts->select('ID,post_author,post_date,post_date_gmt,post_title')
                ->where('post_type', 'tutor_enrolled')
                ->where('post_parent', $post_id)
                ->where('post_author', $user->ID)
                ->where('post_status', 'completed')
                ->get()->getRow();

            if ($enrol != null) { // mengecek apakah user sudah di enroll
                array_push($hasil, [
                    'email'  => $user_email,
                    'status' => 'gagal',
                    'ket'    => 'user sudah terenroll'
                ]);
                continue;
            }

            // mengenroll user
            $data_enrol = [
                'post_author'           => $user->ID,
                'post_content'          => '',
                'post_content_filtered' => '',
                'post_title'            => 'Course Enrolled &ndash; ' . date('d/m/Y') . ' @' . date('g:i a'),
                'post_name'             => 'course-enrolled-' . date('d-m-Y-gi-a'),
                'post_excerpt'          => '',
                'post_status'           => 'completed',
                'post_type'             => 'tutor_enrolled',
                'comment_status'        => 'closed',
                'ping_status'           => 'closed',
                'post_password'         => '',
                'to_ping'               => '',
                'pinged'                => '',
                'post_parent'           => $post_id,
                'menu_order'            => 0,
                'guid'                  => '',
                'post_date'             => date('Y-m-d H:i:s'),
                'post_date_gmt'         => date('Y-m-d H:i:s'),
            ];
            $this->posts->insert($data_enrol);

            $post_insert_id = $this->db->insertID();

            $this->posts->where('ID', $post_insert_id)->update(['guid' => 'https://pastiprestasi.com/?post_type=tutor_enrolled&p=' . $post_insert_id]);

            // mengupdate meta agar user ditandai sebagai student
            $meta_data = [
                'user_id'    => $user->ID,
                'meta_key'   => '_is_tutor_student',
                'meta_value' => time()
            ];

            $this->usermeta->insert($meta_data);
            array_push($hasil, [
                'email'  => $user_email,
                'status' => 'berhasil',
                'ket'    => 'berhasil enroll user'
            ]);
        }
        fclose($handle);

        return view('paspres/hasilenrol', ['hasil' => $hasil]);
    }
}
