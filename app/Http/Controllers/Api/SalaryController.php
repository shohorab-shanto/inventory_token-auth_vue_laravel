<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SalaryController extends Controller
{
    public function Paid(Request $request,$id){

        $ValidateData = $request->validate([
         'salary_month' => 'required',
        ]);

        $month = $request->salary_month;
        $check = DB::table('salleries')->where('employee_id',$id)->where('salary_month',$month)->first();
        if ($check) {
           return response()->json('Salary Alrady Paid');
        }else{
            $data = array();
        $data['employee_id'] = $id;
        $data['amount'] = $request->sallery;
        $data['salary_date'] = date('d/m/Y');
        $data['salary_month'] = $month;
        $data['salary_year'] = date('Y');
        DB::table('salleries')->insert($data);

        }

        }

        public function AllSalary(){
            $salary = DB::table('salleries')->select('salary_month')->groupBy('salary_month')->get();
            return response()->json($salary);
        }

        public function ViewSalary($id){

            $month = $id;
              $view = DB::table('salleries')
                      ->join('employees','salleries.employee_id','employees.id')
                      ->select('employees.name','salleries.*')
                      ->where('salleries.salary_month',$month)
                      ->get();
                      return response()->json($view);

          }

          public function EditSalary($id){

            $view = DB::table('salleries')
                    ->join('employees','salleries.employee_id','employees.id')
                    ->select('employees.name','employees.email','salleries.*')
                    ->where('salleries.id',$id)
                    ->first();
                    return response()->json($view);

        }

        public function SalaryUpdate(Request $request,$id){

            $data = array();
            $data['employee_id'] = $request->employee_id;
            $data['amount'] = $request->amount;
            $data['salary_month'] = $request->salary_month;

          DB::table('salleries')->where('id',$id)->update($data);
        }


}
