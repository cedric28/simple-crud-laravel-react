<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\Company;
use Str,Validator,Redirect,Session, Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();

        return view('employees.create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:employees',
                'phone' => 'required|regex:/(09)[0-9]/'
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }
            
            $user = \Auth::user();

            $employee = new Employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company_id = $request->company_id;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->creator_id = $user->id;
            $employee->updater_id = $user->id;
            $employee->save();
         
            \DB::commit();

            return back()->with('successMsg','Employee Save Successfully');
          

        } catch(\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
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
        $user = \Auth::user();
        $employee = $user->employees()->withTrashed()->findOrFail($id);

        return view('employees.show', [
            'employee' => $employee
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \Auth::user();
        $employee = $user->employees()->withTrashed()->findOrFail($id);
        $companies = Company::all();

        return view('employees.edit', [
            'employee' => $employee,
            'companies' => $companies
        ]);
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
        \DB::beginTransaction();

        try {
            $user = \Auth::user();
            $employee = $user->employees()->withTrashed()->findOrFail($id);
           
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:employees,email,'.$employee->id,
                'phone' => 'required|regex:/(09)[0-9]/'
            ]);
    
            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 404);
            }
            
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company_id = $request->company_id;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->updater_id = $user->id;
            $employee->update();
            
            \DB::commit();

            return back()->with('successMsg','Employee Save Successfully');

        } catch(\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
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
        \DB::beginTransaction();
        try {
            
            $user = \Auth::user();
            $employee = $user->employees()->findOrFail($id);

            /* Soft delete user */
            $employee->delete();

            \DB::commit();

            return response()->json([
                    'data' => $employee,
                    'message' => 'Employees Archived Successfully'
            ], 200); 
        } catch(\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage(),
                'message' => 'Emplpyee Archived Failed'
            ], 500); 
        }
    }
    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        \DB::beginTransaction();
        try {
            $user = \Auth::user();
            $employee = $user->employees()->onlyTrashed()->findOrFail($id);

            /* Restore employee */
            $employee->restore();

            \DB::commit();
            return response()->json([
                'logged_in' => true,
                'data' => $employee,
                'message' => 'Employee Restored Successfully'
            ], 200); 

        } catch(\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage(),
                'message' => 'Product Restored Failed'
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
}
