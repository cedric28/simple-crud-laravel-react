<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;

class EmployeeFetchController extends Controller
{
    public function getEmployees()
    {
        try {
            $user = \Auth::user();
            $employees  = $user->employees()->latest()->paginate(10);
    
            return response()->json([
                'employees' => $employees,
                'message' => 'Employee Data Fetch Successful'
            ], 200);
       
            
        } catch(\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'message' => 'Employee Data Fetch Failed'
            ], 500); 
        }
    }


    public function getInactiveEmployees()
    {
        try {
         
            $employees  = Employee::onlyTrashed()->paginate(15);
    
            return response()->json([
                'employees' => $employees,
                'message' => 'Employee Data Fetch Successful'
            ], 200);
    
        } catch(\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'message' => 'Employee Data Fetch Failed'
            ], 500); 
        }
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $employees = Employee::where(function($query) use ($search){
                $query->where('first_name','LIKE',"%$search%")
                        ->orWhere('last_name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%")
                        ->orWhere('phone','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $employees = Employee::latest()->paginate(10);
        }

        return response()->json([
            'data' => $employees,
            'message' => 'Employee Fetch Data Successfully'
        ], 200); 

    }


    public function archivedSearch(){

        if ($search = \Request::get('q')) {
            $employees = Employee::onlyTrashed()->where(function($query) use ($search){
                $query->where('first_name','LIKE',"%$search%")
                        ->orWhere('last_name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%")
                        ->orWhere('phone','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $employees = Employee::latest()->paginate(10);
        }

        return response()->json([
            'data' => $employees,
            'message' => 'Employee Fetch Data Successfully'
        ], 200); 

    }
}
