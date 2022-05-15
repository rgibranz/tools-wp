<?php

namespace App\Controllers;

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


        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $writer->save('php://output');
        $this->response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="User Terenrol Kelas ' . $course['post_title'] . '.xlsx"');
    }
}
