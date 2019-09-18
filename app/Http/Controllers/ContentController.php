<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class ContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
        $data['title'] = 'Content Managment';
        $data['add'] = 'content/add-content';
        $data['edit'] = 'content/edit-content';
        $data['delete'] = 'content/delete-userguide';
        $data['content'] = DB::table('content')->get();
        return view('content')->with($data);
    }
    public function addContent(Request $r){  
        $this->data['status'] = TRUE;
        if(!$r->id){
            if (empty(Input::get('title'))) {
                $this->data['inputerror'][] = 'title';
                $this->data['error_string'][] = 'Please enter Title.';
                $this->data['status'] = FALSE;
            }
            if (empty(Input::get('content'))) {
                $this->data['inputerror'][] = 'content';
                $this->data['error_string'][] = 'Please enter content.';
                $this->data['status'] = FALSE;
            }
            if ($this->data['status'] === FALSE) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($this->data);
                    exit;
            }else {
                $contents = [
                    'title' => $r->title,
                    'content' => $r->content,
                    'created_at' => date('Y-m-d H:i:s')
                ]; 
                $insert = DB::table('content')->insert($contents);
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
            if (empty(Input::get('title'))) {
                $this->data['inputerror'][] = 'title';
                $this->data['error_string'][] = 'Please enter Title.';
                $this->data['status'] = FALSE;
            }
            if (empty(Input::get('content'))) { 
                $this->data['inputerror'][] = 'content';
                $this->data['error_string'][] = 'Please enter content.';
                $this->data['status'] = FALSE;
            }
            if ($this->data['status'] === FALSE) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($this->data);
                    exit;
            }else {
                $contents = [
                     'title' => $r->title,
                    'content' => $r->content,
                    'created_at' => date('Y-m-d H:i:s')
                ]; 
                $update = DB::table('content')->where('id', $r->id)->update($contents);
                if($update){
                    $data['status'] = TRUE;
                    $data['message'] = 'Content Update successfully.';
                    return response()->json($data);
                }else{
                    $data['status'] = FALSE;
                    $data['message'] = 'Something went wrong. Please try again.';
                    return response()->json($data);
                }
            }
        }
    }

    public function getByid($id){
        $contents = DB::table('content')->where('id',$id)->first();
        return response()->json($contents);
    }
    
    public function delete_userguide($id){ 
        $delete = DB::table('content')->where('id',$id)->delete();
        if($delete){
            $data['status'] = TRUE;
            $data['message'] = 'Userguid Delete Successfully';
        }else{
            $data['status'] = FALSE;
            $data['message'] = 'Something Wrong.';
        }
        return response()->json($data);    
    }
    
    function UserGuidelist(Request $request){
        $columns = array(0 =>'title', 1=> 'content');
        $query = DB::table('content');
        $totalData = $query->count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value'))){            
            $user_guide = $query->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        }else {
            $search = $request->input('search.value'); 
            $user_guide = $query->where(function($q) use ($search) { 
                        $q->Where('title', 'LIKE',"%{$search}%")
                        ->orWhere('content', 'LIKE',"%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        $totalFiltered = count($user_guide);
        }

        $data = array();
        if(!empty($user_guide))
        {
            foreach ($user_guide as $value)
            {
                $option = "<a href='javascript:void(0)' onClick='edit_record(".$value->id.")'><i title='Edit' class='fa fa-edit text-primary' style='font-size: 20px;'></i></a>
                <a href='javascript:void(0)' onClick='delete_record(".$value->id.")'><i title='Delete' class='fa fa-trash text-danger' style='font-size: 20px;'></i></a>";
                $nestedData['title'] = $value->title;
                $nestedData['content'] = $value->content;
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
       
}
