<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Auth;
use App\Models\Vacancies;
use App\Models\Applicants;

class Vacancy extends BaseController
{
    protected $request;
    protected $session;
    protected $db;
    protected $auth_model;
    protected $vacancy_model;
    protected $applicant_model;
    protected $data;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->db = db_connect();
        $this->auth_model = new Auth;
        $this->vacancy_model = new Vacancies;
        $this->applicant_model = new Applicants;
        $this->data = ['session' => $this->session,'request'=>$this->request];

    }

    public function index()
    {
        $this->data['page_title'] = "Home";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  5;
        $this->data['total'] =  $this->vacancy_model->where('status', 1)
                                ->orderBy('abs(unix_timestamp(created_at)) DESC')
                                ->countAllResults();
        $this->data['vacancies'] = $this->vacancy_model
                                ->select("vacancies.*, departments.name as department, (vacancies.slot - COALESCE((SELECT COUNT(id) FROM applicants where vacancy_id = vacancies.id and status = 1), 0)) as available")
                                ->where('vacancies.status', 1)
                                ->join('departments',"vacancies.department_id = departments.id", "inner")
                                ->orderBy('abs(unix_timestamp(vacancies.created_at)) DESC')
                                ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['vacancies'])? count($this->data['vacancies']) : 0;
        $this->data['pager'] = $this->vacancy_model->pager;
        
        return view('pages/public/home', $this->data);
    }
    public function view($id = ''){
        if(empty($id))
        return redirect()->to('Vacancy/PagenotFound');
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['vacancy_id'] = ($this->db->escapeString($vacancy_id));
            $udata['first_name'] = htmlspecialchars($this->db->escapeString($first_name));
            $udata['middle_name'] = htmlspecialchars($this->db->escapeString($middle_name));
            $udata['last_name'] = htmlspecialchars($this->db->escapeString($last_name));
            $udata['email'] = htmlspecialchars($this->db->escapeString($email));
            $udata['contact'] = htmlspecialchars($this->db->escapeString($contact));
            $udata['address'] = htmlspecialchars($this->db->escapeString($address));
           
            $save = $this->applicant_model->save($udata);
            if($save){
                $this->session->setFlashdata('main_success',"Your Application has been submitted successfully. We'll reach you at your givent contact information as soon we sees your application. Thanks!");
                return redirect()->to('Vacancy/view/'.$id);
            }else{
                $this->session->setFlashdata('error',"Applicantion has failed to submit.");
            }
        }
        $vacancy = $this->vacancy_model
                     ->select("vacancies.*, departments.name as department, (vacancies.slot - COALESCE((SELECT COUNT(id) FROM applicants where vacancy_id = vacancies.id and status = 1), 0)) as available")
                     ->where("vacancies.id = '{$id}'")
                     ->join('departments',"vacancies.department_id = departments.id", "inner")
                     ->first();
        if(!isset($vacancy['id']))
        return redirect()->to('Vacancy/PagenotFound');
        $this->data['page_title'] = $vacancy['position'];
        $this->data['vacancy'] = $vacancy;
        return view('pages/public/vacancy', $this->data);
    }
    public function PagenotFound(){
        $this->data['page_title'] = "Page Not Found";
        return view('pages/public/page_not_found', $this->data);
    }
}
