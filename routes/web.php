<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('student',[StudentController::class, 'index'])->name('students');

Route::get('student-create',function(){
    return view('sutdent.create');
})->name('students-create');

Route::get('student-export',[StudentController::class,'export'])->name('export_student');

Route::post('import-student',[StudentController::class,'import'])->name('import_students');

Route::post('student-store',[StudentController::class,'store'])->name('student_store');
