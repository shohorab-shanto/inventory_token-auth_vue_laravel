<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Image;
use DB;

class EmployeeController extends Controller
{

    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:employees|max:255',
            'email' => 'required|unique:employees|max:255',
            'phone' => 'required|unique:employees|max:255',
        ]);

        if($request->photo){ //console thke photo niea data base e rakhar jonno
            $position = strpos($request->photo, ';'); //what data and which position i want to take data in console
            $sub = substr($request->photo,0,$position); //that will started from 0
            $ext = explode('/',$sub)[1]; //0 theke start korci 1 theke nibe

            $name = time().".".$ext;  //unique name
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            $img->save($image_url);

            $employee = new Employee;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->sallery = $request->sallery;
            $employee->address = $request->address;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->photo = $image_url;
            $employee->save();

        }else{
            $employee = new Employee;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->sallery = $request->sallery;
            $employee->address = $request->address;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->save();
        }

    }

    public function show($id)
    {
        $employee = DB::table('employees')->where('id',$id)->first();
        return response()->json($employee);

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {  // update photo
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['sallery'] = $request->sallery;
        $data['address'] = $request->address;
        $data['nid'] = $request->nid;
        $data['joining_date'] = $request->joining_date;
        $image = $request->newphoto;

        if($image){
            $position = strpos($image, ';'); //what data and which position i want to take data in console
            $sub = substr($image,0,$position); //that will started from 0
            $ext = explode('/',$sub)[1]; //0 theke start korci 1 theke nibe

            $name = time().".".$ext;  //unique name
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url); //ekhne new image asbe

            if($success){ //jdi new image pay tahle condition er maddhome oita replace korbe
                $data['photo'] = $image_url; //jdi notun pi c ase seta photo te joma hobe
                $img = DB::table('employees')->where('id',$id)->first();
                $image_path = $img->photo;
                $done = unlink($image_path);//ager pi c unlink hoiea jbe
                $user = DB::table('employees')->where('id',$id)->update($data);
            }
        }else{ //without updating photo
            $oldphoto = $request->photo;
            $data['photo'] = $request->photo;
            $user = DB::table('employees')->where('id',$id)->update($data);
        }
    }

    public function destroy($id)
    {
        $employee = DB::table('employees')->where('id',$id)->first();

        $photo = $employee->photo;
        if($photo){
            unlink($photo);
            DB::table('employees')->where('id',$id)->delete();
        }else{
            DB::table('employees')->where('id',$id)->delete();
        }
    }
}
