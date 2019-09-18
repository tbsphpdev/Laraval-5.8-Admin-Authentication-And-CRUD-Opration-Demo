<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Auth;

class UserController extends Controller
{
    public function welcome(){
        return 'Welcome';
    }
    public function index(){
        $data['title']      = 'User Management';
        $data['list']       = 'user/list';
        $data['view']       = 'user/user-view';
        $data['status']     = 'user/list';
        $data['add']        = 'user/add-user';
        $data['userstatus'] = 'user/change-userstatus';
        $data['edit']       = 'user/edit-user';
        $data['delete']     = 'user/delete';
        return view('user_list')->with($data);
    }
    
    public function userlist(Request $request){        
        $columns = array(0 =>'name', 1=> 'created_at' , 2 =>'email', 3=>'status');
        $query = DB::table('users')->where('role',1);
        $totalData = $query->count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value'))){            
            $user = $query->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        }else {
            $search = $request->input('search.value'); 
            $user = $query->where(function($q) use ($search) { 
                        $q->Where('name', 'LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        $totalFiltered = count($user);
        }

        $data = array();
        if(!empty($user))
        {
            foreach ($user as $value)
            {
                $option = "<a href='javascript:void(0)' onClick='edit_record(".$value->id.")'><i title='Edit' class='fa fa-edit text-primary' style='font-size: 20px;'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' onClick='delete_record(".$value->id.")'><i title='Delete' class='fa fa-trash text-danger' style='font-size: 20px;'></i></a>";
                $nestedData['name'] = $value->name;
                $nestedData['date'] = date('Y-m-d', strtotime($value->updated_at));
                $nestedData['email'] = $value->email;
                $nestedData['status'] = $value->status == 1 ? "<a href='javascript:void(0)' onClick='change_userstatus(".$value->id.",0)';><i title='Active' class='label bg-green bg-active-user'>Active</i></a>" : "<a href='javascript:void(0)' onClick='change_userstatus(".$value->id.",1)';><i title='Inactive' class='label bg-red bg-inactive-user'>Inactive</i></a>";
                $nestedData['options'] = $option;
                $data[] = $nestedData;  
            }
        }
          
        $json_data = array( 
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data); 
    }

    public function getByid($id){
        $contents = DB::table('users')->where('id',$id)->first();
        return response()->json($contents);
    }
    
    public function user_details($id){ 
        $user = DB::table('users')->where('id',$id)->first();
        return view('user_view')->with('user',$user);
    }
    public function addUser(Request $r){ 
        $this->data['status'] = TRUE;
        if(!$r->id){ 
            if (empty(Input::get('user_name'))) {
                $this->data['inputerror'][] = 'user_name';
                $this->data['error_string'][] = 'Please enter name.';
                $this->data['status'] = FALSE;
            }
            if (empty(Input::get('user_email'))) {
                $this->data['inputerror'][] = 'user_email';
                $this->data['error_string'][] = 'Please enter email.';
                $this->data['status'] = FALSE;
            }elseif (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", Input::get('user_email'))) {
                $this->data['inputerror'][] = 'user_email';
                $this->data['error_string'][] = 'Please enter valid email.';
                $this->data['status'] = FALSE;
            }
            if ($this->data['status'] === FALSE) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($this->data);
                    exit;
            }else {
                $user_detail = [
                    'name' => $r->user_name,
                    'email' => $r->user_email,
                    'password' => bcrypt($r->user_password),
                    'status' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]; 
                $insert = DB::table('users')->insert($user_detail);
                if($insert){
                    $data['status'] = TRUE;
                    $data['message'] = 'Content Insert successfully.';
                    return response()->json($data);
                }else{
                    $data['status'] = FALSE;
                    $data['message'] = 'Something went wrong. Please try again.';
                    return response()->json($data);
                }
            }
        }else{
            if (empty(Input::get('user_name'))) {
                $this->data['inputerror'][] = 'user_name';
                $this->data['error_string'][] = 'Please enter name.';
                $this->data['status'] = FALSE;
            }
            if (empty(Input::get('user_email'))) { 
                $this->data['inputerror'][] = 'user_email';
                $this->data['error_string'][] = 'Please enter email.';
                $this->data['status'] = FALSE;
            }
            if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", Input::get('user_email'))) {
                $this->data['inputerror'][] = 'user_email';
                $this->data['error_string'][] = 'Please enter valid email.';
                $this->data['status'] = FALSE;
            }
            if ($this->data['status'] === FALSE) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($this->data);
                    exit;
            }else {
                $user_detail = [
                    'name' => $r->user_name,
                    'email' => $r->user_email,
                    'updated_at' => date('Y-m-d H:i:s')
                ]; 
                $update = DB::table('users')->where('id', $r->id)->update($user_detail);
                if($update){
                    $data['status'] = TRUE;
                    $data['message'] = 'User Update successfully.';
                    return response()->json($data);
                }else{
                    $data['status'] = FALSE;
                    $data['message'] = 'Something went wrong. Please try again.';
                    return response()->json($data);
                }
            }
        }
    }
    public function changeuserStatus($id,$status){
         $update = DB::table('users')->where('id',$id)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
        if($update){
            $user = DB::table('users')->where('id',$id)->first(['name','email']);
            $status = ($status == 1 ? 'Active' : 'Inactive');
            $data['status'] = TRUE;
            $data['message'] = 'Status Change Successfully';
        }else{
            $data['status'] = FALSE;
            $data['message'] = 'Something Wrong.';
        }
        return response()->json($data);   

    }
    public function delete_user($id){ 
        $delete = DB::table('users')->where('id',$id)->delete();
        if($delete){
            $data['status'] = TRUE;
            $data['message'] = 'User Delete Successfully';
        }else{
            $data['status'] = FALSE;
            $data['message'] = 'Something Wrong.';
        }
        return response()->json($data);    
    }
}