<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Peem extends BaseController
{
    public function index()
    {
    }

    public function __construct()
    {
        $this->db       = \Config\Database::connect('peem');
        $this->posts    = $this->db->table('posts');
    }

    public function CourseEnrollment()
    {
        $course = $this->posts->where('post_type', 'sfwd-courses')->where('post_status', 'publish')->get()->getResultArray();
        return view('peem/CourseEnrollment', ['course' => $course]);
    }

    public function ExportCourseEnrollment()
    {
        $post_id = $this->request->getPost('post_id');

        $course = $this->posts->where('ID', $post_id)->get()->getRowArray();

        $db = db_connect('peem');
        $query = $db->query("SELECT * FROM wp48_usermeta JOIN wp48_users ON wp48_users.id = wp48_usermeta.user_id WHERE wp48_usermeta.meta_key = 'course_" . $post_id . "_access_from'");

        $hasil = $query->getResult();

        // var_dump($hasil);
        // die;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;

        $sheet
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'id user')
            ->setCellValue('C1', 'Nama')
            ->setCellValue('D1', 'Email')
            ->setCellValue('E1', 'Course');

        $kolom = 2;
        $nomor = 1;
        foreach ($hasil as $data) {

            $sheet
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $data->ID)
                ->setCellValue('C' . $kolom, $data->user_login)
                ->setCellValue('D' . $kolom, $data->user_email)
                ->setCellValue('E' . $kolom, $course['post_title']);

            $kolom++;
            $nomor++;
        }


        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);

        $writer->save('php://output');
        $this->response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="User Terenrol Kelas ' . $course['post_title'] . '.csv"');
    }
}
