<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\Departments;
use App\Models\Vacancies;
use App\Models\Applicants;
class Main extends BaseController
{   
    protected $request;
    protected $session;
    protected $db;
    protected $auth_model;
    protected $vacancy_model;
    protected $department_model;
    protected $applicant_model;
    protected $data;


    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->db = db_connect();
        $this->auth_model = new Auth;
        $this->department_model = new departments;
        $this->vacancy_model = new Vacancies;
        $this->applicant_model = new Applicants;
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }

    public function index()
    {
        $this->data['page_title']="Home";
        $this->data['departments']=$this->department_model->countAll();
        $this->data['vacancies']=$this->vacancy_model->countAll();
        $this->data['applicants']=$this->applicant_model->countAll();
        return view('pages/home', $this->data);
    }

    public function users(){
        $this->data['page_title']="Users";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->auth_model->where("id != '{$this->session->login_id}'")->countAllResults();
        $this->data['users'] = $this->auth_model->where("id != '{$this->session->login_id}'")->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['users'])? count($this->data['users']) : 0;
        $this->data['pager'] = $this->auth_model->pager;
        return view('pages/users/list', $this->data);
    }
    public function user_add(){
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            if($password !== $cpassword){
                $this->session->setFlashdata('error',"Kata sandi tidak cocok.");
            }else{
                $udata= [];
                $udata['name'] = $name;
                $udata['email'] = $email;
                if(!empty($password))
                $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $checkMail = $this->auth_model->where('email',$email)->countAllResults();
                if($checkMail > 0){
                    $this->session->setFlashdata('error',"Email Pengguna Sudah Diambil.");
                }else{
                    $save = $this->auth_model->save($udata);
                    if($save){
                        $this->session->setFlashdata('main_success',"Detail Pengguna telah berhasil diperbarui.");
                        return redirect()->to('Main/users');
                    }else{
                        $this->session->setFlashdata('error',"Detail Pengguna gagal diperbarui.");
                    }
                }
            }
        }

        $this->data['page_title']="Add User";
        return view('pages/users/add', $this->data);
    }
    public function user_edit($id=''){
        if(empty($id))
        return redirect()->to('Main/users');
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            if($password !== $cpassword){
                $this->session->setFlashdata('error',"Kata sandi tidak cocok.");
            }else{
                $udata= [];
                $udata['name'] = $name;
                $udata['email'] = $email;
                if(!empty($password))
                $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $checkMail = $this->auth_model->where('email',$email)->where('id!=',$id)->countAllResults();
                if($checkMail > 0){
                    $this->session->setFlashdata('error',"Email Pengguna Sudah Diambil.");
                }else{
                    $update = $this->auth_model->where('id',$id)->set($udata)->update();
                    if($update){
                        $this->session->setFlashdata('success',"Detail Pengguna telah berhasil diperbarui.");
                        return redirect()->to('Main/user_edit/'.$id);
                    }else{
                        $this->session->setFlashdata('error',"Detail Pengguna gagal diperbarui.");
                    }
                }
            }
        }

        $this->data['page_title']="Edit User";
        $this->data['user'] = $this->auth_model->where("id ='{$id}'")->first();
        return view('pages/users/edit', $this->data);
    }
    
    public function user_delete($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Penghapusan pengguna gagal karena ID tidak diketahui.");
                return redirect()->to('Main/users');
        }
        $delete = $this->auth_model->where('id', $id)->delete();
        if($delete){
            $this->session->setFlashdata('main_success',"Pengguna telah berhasil dihapus.");
        }else{
            $this->session->setFlashdata('main_error',"Penghapusan pengguna gagal karena ID tidak diketahui.");
        }
        return redirect()->to('Main/users');
    }


    // department
    public function departments(){
        $this->data['page_title']="Departments";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->department_model->countAllResults();
        $this->data['departments'] = $this->department_model->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['departments'])? count($this->data['departments']) : 0;
        $this->data['pager'] = $this->department_model->pager;
        return view('pages/departments/list', $this->data);
    }
    public function department_add(){
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['name'] = htmlspecialchars($this->db->escapeString($name));
            $udata['description'] = htmlspecialchars($this->db->escapeString($description));
            $checkCode = $this->department_model->where('name',$name)->countAllResults();
            if($checkCode){
                $this->session->setFlashdata('error',"Department Already Taken.");
            }else{
                $save = $this->department_model->save($udata);
                if($save){
                    $this->session->setFlashdata('main_success',"Detail Departemen telah berhasil diperbarui.");
                    return redirect()->to('Main/departments/');
                }else{
                    $this->session->setFlashdata('error',"Detail Departemen gagal diperbarui.");
                }
            }
        }

        $this->data['page_title']="Add New Department";
        return view('pages/departments/add', $this->data);
    }
    public function department_edit($id=''){
        if(empty($id))
        return redirect()->to('Main/departments');
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['name'] = htmlspecialchars($this->db->escapeString($name));
            $udata['description'] = htmlspecialchars($this->db->escapeString($description));
            $checkCode = $this->department_model->where('name',$name)->where("id!= '{$id}'")->countAllResults();
            if($checkCode){
                $this->session->setFlashdata('error',"Department Already Taken.");
            }else{
                $update = $this->department_model->where('id',$id)->set($udata)->update();
                if($update){
                    $this->session->setFlashdata('success',"Detail Departemen telah berhasil diperbarui.");
                    return redirect()->to('Main/department_edit/'.$id);
                }else{
                    $this->session->setFlashdata('error',"Detail Departemen gagal diperbarui.");
                }
            }
        }

        $this->data['page_title']="Edit Department";
        $this->data['department'] = $this->department_model->where("id ='{$id}'")->first();
        return view('pages/departments/edit', $this->data);
    }
    
    public function department_delete($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Penghapusan Departemen gagal karena ID tidak diketahui.");
                return redirect()->to('Main/departments');
        }
        $delete = $this->department_model->where('id', $id)->delete();
        if($delete){
            $this->session->setFlashdata('main_success',"Departemen telah berhasil dihapus.");
        }else{
            $this->session->setFlashdata('main_error',"Penghapusan Departemen gagal karena ID tidak diketahui.");
        }
        return redirect()->to('Main/departments');
    }

    // vacancy
    public function vacancies(){
        $this->data['page_title']="Vacancies";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        if(!empty($this->request->getVar('search'))){
            $search = $this->request->getVar('search');
            $this->vacancy_model->where(" vacancies.position LIKE '%{$search}%' or vacancies.description LIKE '%{$search}%'");
        }
        $this->data['total'] =  $this->vacancy_model->countAllResults();
        if(!empty($this->request->getVar('search'))){
            $search = $this->request->getVar('search');
            $this->vacancy_model->where(" vacancies.position LIKE '%{$search}%' or vacancies.description LIKE '%{$search}%'");
        }
        $this->data['vacancies'] = $this->vacancy_model
                                        ->select("vacancies.*, departments.name as department, (vacancies.slot - COALESCE((SELECT COUNT(id) FROM applicants where vacancy_id = vacancies.id and status = 1), 0)) as available")
                                        ->join("departments","vacancies.department_id = departments.id", "inner")
                                        ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['vacancies'])? count($this->data['vacancies']) : 0;
        $this->data['pager'] = $this->vacancy_model->pager;
        return view('pages/vacancies/list', $this->data);
    }
    public function vacancy_add(){
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['department_id'] = htmlspecialchars($this->db->escapeString($department_id));
            $udata['position'] = htmlspecialchars($this->db->escapeString($position));
            $udata['description'] = htmlspecialchars($this->db->escapeString($description));
            $udata['slot'] = ($this->db->escapeString($slot));
            $udata['salary_from'] = ($this->db->escapeString($salary_from));
            $udata['salary_to'] = ($this->db->escapeString($salary_to));
            $udata['status'] = ($this->db->escapeString($status));
            $save = $this->vacancy_model->save($udata);
            if($save){
                $this->session->setFlashdata('main_success',"Detail Lowongan telah berhasil diperbarui.");
                return redirect()->to('Main/vacancies/');
            }else{
                $this->session->setFlashdata('error',"Detail Lowongan gagal diperbarui.");
            }
        }

        $this->data['page_title']="Add New vacancy";
        $this->data['departments']=$this->department_model->findAll();
        return view('pages/vacancies/add', $this->data);
    }
    public function vacancy_edit($id=''){
        if(empty($id))
        return redirect()->to('Main/vacancies');
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $udata= [];
            $udata['department_id'] = htmlspecialchars($this->db->escapeString($department_id));
            $udata['position'] = htmlspecialchars($this->db->escapeString($position));
            $udata['description'] = htmlspecialchars($this->db->escapeString($description));
            $udata['slot'] = ($this->db->escapeString($slot));
            $udata['salary_from'] = ($this->db->escapeString($salary_from));
            $udata['salary_to'] = ($this->db->escapeString($salary_to));
            $udata['status'] = ($this->db->escapeString($status));
            $update = $this->vacancy_model->where('id',$id)->set($udata)->update();
            if($update){
                $this->session->setFlashdata('success',"Detail Lowongan telah berhasil diperbarui.");
                return redirect()->to('Main/vacancy_edit/'.$id);
            }else{
                $this->session->setFlashdata('error',"Detail Lowongan gagal diperbarui.");
            }
        }

        $this->data['page_title']="Edit Vacancy";
        $this->data['vacancy'] = $this->vacancy_model->where("id ='{$id}'")->first();
        $this->data['departments']=$this->department_model->findAll();
        return view('pages/vacancies/edit', $this->data);
    }
    public function vacancy_delete($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Penghapusan Lowongan gagal karena ID tidak dikenal.");
                return redirect()->to('Main/vacancies');
        }
        $delete = $this->vacancy_model->where('id', $id)->delete();
        if($delete){
            $this->session->setFlashdata('main_success',"Lowongan telah berhasil dihapus.");
        }else{
            $this->session->setFlashdata('main_error',"Penghapusan Lowongan gagal karena ID tidak dikenal.");
        }
        return redirect()->to('Main/vacancies');
    }

     // applicants
     public function applicants(){
        $this->data['page_title']="Applicants";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->applicant_model->countAllResults();
        $this->data['applicants'] = $this->applicant_model
                                        ->select("applicants.*, CONCAT(applicants.last_name,', ',applicants.first_name,' ',COALESCE(CONCAT(' ', applicants.middle_name), '')) as `name` , vacancies.position, departments.name as department")
                                        ->join("vacancies","applicants.vacancy_id = vacancies.id", "inner")
                                        ->join("departments","vacancies.department_id = departments.id", "inner")
                                        ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['applicants'])? count($this->data['applicants']) : 0;
        $this->data['pager'] = $this->applicant_model->pager;
        return view('pages/applicants/list', $this->data);
    }
    public function applicant_view($id=""){
        if(empty($id)){
            $this->session->setFlashdata('main_error',"Unknown ID.");
            return redirect()->to('Main/applicants');
        }
        $this->data['applicant'] = $this->applicant_model
                                        ->select("applicants.*, CONCAT(applicants.last_name,', ',applicants.first_name,' ',COALESCE(CONCAT(' ', applicants.middle_name), '')) as `name` , vacancies.position, departments.name as department")
                                        ->join("vacancies","applicants.vacancy_id = vacancies.id", "inner")
                                        ->join("departments","vacancies.department_id = departments.id", "inner")
                                        ->where('applicants.id', $id)->first();
        if(!isset($this->data['applicant']['id'])){
            $this->session->setFlashdata('main_error',"Unknown ID.");
            return redirect()->to('Main/applicants');
        }
        $this->data['page_title']=$this->data['applicant']['name'];
        return view('pages/applicants/view', $this->data);
    }
    public function applicant_hired($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Unknown ID.");
                return redirect()->to('Main/applicants');
        }
        $update = $this->applicant_model->where('id', $id)->set('status',1)->update();
        if($update){
            $this->session->setFlashdata('main_success',"Pemohon telah ditandai sebagai Dipekerjakan.");
        }else{
            $this->session->setFlashdata('main_error',"Detail pelamar gagal ditandai sebagai Dipekerjakan.");
        }
        return redirect()->to('Main/applicant_view/'.$id);
    }
    public function applicant_nothired($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Unknown ID.");
                return redirect()->to('Main/applicants');
        }
        $update = $this->applicant_model->where('id', $id)->set('status',2)->update();
        if($update){
            $this->session->setFlashdata('main_success',"Pemohon telah ditandai sebagai Tidak Dipekerjakan.");
        }else{
            $this->session->setFlashdata('main_error',"Detail pelamar gagal ditandai sebagai Tidak Dipekerjakan.");
        }
        return redirect()->to('Main/applicant_view/'.$id);
    }
    public function applicant_delete($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Penghapusan Pemohon gagal karena ID tidak dikenal.");
                return redirect()->to('Main/vacancies');
        }
        $delete = $this->applicant_model->where('id', $id)->delete();
        if($delete){
            $this->session->setFlashdata('main_success',"Pemohon telah berhasil dihapus.");
        }else{
            $this->session->setFlashdata('main_error',"Penghapusan Pemohon gagal karena ID tidak dikenal.");
        }
        return redirect()->to('Main/applicants');
    }

}
