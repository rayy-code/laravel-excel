<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    //
    public function index()
    {

        $students = student::all();
        return view('sutdent.student',[
            'students' => $students
        ]);
    }
    public function import(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'file_upload' => 'required|mimes:csv,xls,xlsx',
        // ]);

        $request->validate([
            'data'=>'required|mimes:csv,xls,xlsx',
        ]);

        //check if validation fails
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        $file = $request->file('data');

        //membuat nama file unik    
        $filename = $file->hashName();

       //temporary file
       $path = $file->storeAs('/public/excel/',$filename);

       // import data
       $import = Excel::import(new StudentImport(), storage_path('app/public/excel/'.$filename));

       //remove from server
       Storage::delete($path);

       if($import) {
           //redirect
           return redirect()->route('students')->with(['success' => 'Data Berhasil Diimport!']);
       } else {
           //redirect
           return redirect()->route('students')->with(['error' => 'Data Gagal Diimport!']);
       }
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_id' => 'required',
            'name' => 'required',
            'class' => 'required',
            'majority'=> 'required'
        ]);

        student::create([
            'no_id' => $request->no_id,
            'name' => $request->name,
            'class' => $request->class,
            'majority'=> $request->majority
        ]);

        return redirect()->route('students');
    }
    public function export()
    {
        return Excel::download(new student(), 'student.xlsx');
    }
}
