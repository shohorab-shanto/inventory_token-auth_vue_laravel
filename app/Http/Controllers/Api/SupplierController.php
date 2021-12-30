<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Image;
use DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();
        return response()->json($supplier);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:suppliers|max:255',
            'email' => 'required|unique:suppliers|max:255',
            'phone' => 'required|unique:suppliers|max:255',
        ]);

        if($request->photo){ //console thke photo niea data base e rakhar jonno
            $position = strpos($request->photo, ';'); //what data and which position i want to take data in console
            $sub = substr($request->photo,0,$position); //that will started from 0
            $ext = explode('/',$sub)[1]; //0 theke start korci 1 theke nibe

            $name = time().".".$ext;  //unique name
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path.$name;
            $img->save($image_url);

            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shopname = $request->shopname;
            $supplier->photo = $image_url;
            $supplier->save();

        }else{
            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shopname = $request->shopname;
            $supplier->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supllier = DB::table('suppliers')->where('id',$id)->first();
        return response()->json($supllier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['shopname'] = $request->shopname;
        $image = $request->newphoto;

        if($image){
            $position = strpos($image, ';'); //what data and which position i want to take data in console
            $sub = substr($image,0,$position); //that will started from 0
            $ext = explode('/',$sub)[1]; //0 theke start korci 1 theke nibe

            $name = time().".".$ext;  //unique name
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url); //ekhne new image asbe

            if($success){ //jdi new image pay tahle condition er maddhome oita replace korbe
                $data['photo'] = $image_url; //jdi notun pi c ase seta photo te joma hobe
                $img = DB::table('suppliers')->where('id',$id)->first();
                $image_path = $img->photo;
                $done = unlink($image_path);//ager pi c unlink hoiea jbe
                $user = DB::table('suppliers')->where('id',$id)->update($data);
            }
        }else{ //without updating photo
            $oldphoto = $request->photo;
            $data['photo'] = $request->photo;
            $user = DB::table('suppliers')->where('id',$id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = DB::table('suppliers')->where('id',$id)->first();

        $photo = $supplier->photo;
        if($photo){
            unlink($photo);
            DB::table('suppliers')->where('id',$id)->delete();
        }else{
            DB::table('suppliers')->where('id',$id)->delete();
        }

    }
}
