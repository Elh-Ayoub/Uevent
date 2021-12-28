<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use File;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'location' => ['required', 'string'],
        ]);
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        $user = Auth::user();
        if(!$user){
            return back()->with('fail', 'There is no Authenticated user!');
        }
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'logo' => ($request->logo) ? ($this->uploadLogo($request)) : ('https://ui-avatars.com//api//?name='. substr($request->name, 0, 2) .'&color=7F9CF5&background=EBF4FF'),
        ]);
        if($company){
            $user->update(['company_id' => $company->id]);
            return back()->with('success', 'Company entity created successfully!');
        }else{
            return back()->with('fail', 'Something went wrong!');
        }
    }

    function uploadLogo($request){
        $image = $request->file('logo');
        if($image){
            $filename = uniqid().".".File::extension($image->getClientOriginalName());
            $image = $request->file('logo')->store('public');
            $image1 = $request->file('logo')->move(public_path('/company-logos'), $filename);
            return url('/company-logos/' . $filename);
        }
        return null;
    }
}
