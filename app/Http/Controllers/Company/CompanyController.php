<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Attachment;
use Carbon\Carbon,Str,Validator,Redirect,Session, Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
                'name' => 'required|max:255',
                'email' => 'required|email|unique:companies',
                'website' => 'required|url',
                'photo' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }
            
            $originalImage= $request->file('photo');
            $fileType = $originalImage->getMimeType();
            
            $photo = time().$originalImage->getClientOriginalName();
            $user = \Auth::user();

            $company = new Company();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->website = $request->website;
            $company->creator_id = $user->id;
            $company->updater_id = $user->id;
            $company->save();


            $attachment = new Attachment();
            $attachment->photo = $photo;
            $attachment->type = $fileType;
            $attachment->company_id = $company->id;
            $attachment->creator_id = $user->id;
            $attachment->updater_id = $user->id;

            if($attachment->save()){
                $photoPath = public_path('images/'.$company->id.'/');

                if (!file_exists($photoPath)) {
                    mkdir($photoPath, 0777, true);
                }
                // create instance
                $img = \Image::make($originalImage->getRealPath());
    
                // resize image to fixed size
                $img->resize(100, 100);
                $img->save($photoPath.$photo);
            }
            
         
            \DB::commit();

            return back()->with('successMsg','Company Save Successfully');
          

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
        $company = $user->companies()->withTrashed()->findOrFail($id);

        return view('companies.show', [
            'company' => $company
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
        $company = $user->companies()->withTrashed()->findOrFail($id);
    
        return view('companies.edit', [
            'company' => $company
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
            $company = $user->companies()->withTrashed()->findOrFail($id);
           
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:companies,email,'.$company->id,
                'website' => 'required|url',
                'photo' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }
            $originalImage= $request->file('photo');
            $user = \Auth::user();
            
            $company->name = $request->name;
            $company->email = $request->email;
            $company->website = $request->website;
            $company->updater_id = $user->id;
            $company->update();

            if($originalImage){
                $fileType = $originalImage->getMimeType();
                $photo = time().$originalImage->getClientOriginalName();

                $attachment = Attachment::where('company_id',$company->id)->firstOrFail();
                $currentPhoto = $attachment->photo;
                $attachment->photo = $photo;
                $attachment->type = $fileType;
                $attachment->updater_id = $user->id;
    
                if($attachment->save()){
                    $productPhoto = public_path('images/'.$company->id.'/').$currentPhoto;
                    $photoPath = public_path('images/'.$company->id.'/');
                    if (!file_exists($productPhoto)) {
                        mkdir($photoPath, 0777, true);
                    } else {
                        @unlink($productPhoto);
                    }
                    // create instance
                    $img = \Image::make($originalImage->getRealPath());
        
                    // resize image to fixed size
                    $img->resize(100, 100);
                    $img->save($photoPath.$photo);
                }
            }

           
            
            \DB::commit();

            return back()->with('successMsg','Company Details Update Successfully');

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
            $company = $user->companies()->findOrFail($id);

            /* Soft delete user */
            $company->delete();

            \DB::commit();

            return response()->json([
                    'data' => $company,
                    'message' => 'Company Archived Successfully'
            ], 200); 
        } catch(\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage(),
                'message' => 'Company Archived Failed'
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
            $company = $user->companies()->onlyTrashed()->findOrFail($id);

            /* Restore media */
            $company->restore();

            \DB::commit();
            return response()->json([
                'logged_in' => true,
                'data' => $company,
                'message' => 'Company Restored Successfully'
            ], 200); 

        } catch(\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage(),
                'message' => 'Company Restored Failed'
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
}
