<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;

class CompanyFetchController extends Controller
{
    public function getCompanies()
    {
        try {
                $user = \Auth::user();
                $companies = $user->companies()->latest()->paginate(10);
        
                return response()->json([
                    'companies' => $companies,
                    'message' => 'Company Data Fetch Successful'
                ], 200);
       
            
        } catch(\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'message' => 'Company Data Fetch Failed'
            ], 500); 
        }
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $companies = Company::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('website','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $companies = Post::latest()->paginate(10);
        }

        return response()->json([
            'data' => $companies,
            'message' => 'Company Fetch Data Successfully'
        ], 200); 
    }


    public function archivedSearch(){

        if ($search = \Request::get('q')) {
            $companies = Company::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('website','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $companies = Post::latest()->paginate(10);
        }

        return response()->json([
            'data' => $companies,
            'message' => 'Company Fetch Data Successfully'
        ], 200); 

    }
}
