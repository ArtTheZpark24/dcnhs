<?php

use App\Http\Controllers\AddClassController;
use App\Http\Controllers\ExportUsertController;
use App\Http\Controllers\AlluserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssesmentController;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\DisplayAllGradesController;
use App\Http\Controllers\FirstGradeController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\GuardiansAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportGradesController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\SchoolyearController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StrandController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionStudentController;
use App\Http\Controllers\StrandSubController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentGuardianController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\TeacherAuthInfoController;
use App\Http\Controllers\TeacherLoginController;
use App\Http\Controllers\WrittenWorksController;
use App\Models\PerformanceTask;
use App\Models\StudentGuardian;
use Illuminate\Support\Facades\Route;
use Vonage\Meetings\Room;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//home page
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/login/page', [HomeController::class, 'login'])->name('home.loginpage');
Route::get('/teacher/login', [TeacherLoginController::class, 'index'])->name('teacher.index');
Route::post('/teacher/login/post', [TeacherLoginController::class, 'login'])->name('teacher.login');

// login teacher

Route::get('/admin/login', [AdminController::class, 'index'])->name('admin.login');


Route::get('/student/login', [StudentLoginController::class, 'index'])->name('student.login');
Route::post('/student/login/check', [StudentLoginController::class, 'login'])->name('student.login.post');


// login guardians

Route::get('guardians/login', [GuardiansAuthController::class, 'index'])->name('guardian.login');

Route::post('guardians/login/post', [GuardiansAuthController::class, 'login'])->name('guardian.login.post');


//login users
Route::post('/admin-post', [AdminController::class, 'adminLogin'])->name('admin-post');
Route::middleware('admin')->group(function(){
//users
Route::get('admin/all/users', [AlluserController::class, 'index'])->name('all.users');

 //student route
Route::post('admin/import/students', [StudentController::class, 'studentImport'])->name('students.excel');
Route::get('admin/create/students', [StudentController::class, 'index'])->name('students.create');
Route::post('admin/create/students', [StudentController::class, 'create'])->name('students.create.post');
Route::get('admin/create/student/list', [StudentController::class, 'data'])->name('students.data');
Route::put('admin/create/student/update/{id}', [StudentController::class, 'update'])->name('students.data.update');
Route::delete('admin/create/student/delete/{id}', [StudentController::class, 'delete'])->name('students.data.delete');
Route::get('admin/student/archive', [StudentController::class, 'archive'])->name('students.data.archive');
Route::patch('admin/student/restore/{id}', [StudentController::class, 'restore'])->name('students.data.restore');

//reset the password of student

Route::post('admin/student/reset/password/{id}', [StudentController::class, 'resetPass'])->name('student.password.reset');


   
   // graduate student route

   Route::get('admin/student/gradutes/record', [StudentController::class, 'graduates'])->name('students.graduates');
Route::put('admin/student/gradutes/record/delete/{id}/{stud_id}', [StudentController::class, 'gradDel'])->name('graduates.delete');

//teacher route
Route::get('admin/create/teachers', [TeacherController::class, 'index'])->name('teachers.create');
Route::post('admin/create/teachers', [TeacherController::class, 'create'])->name('teachers.create.post');
Route::get('admin/teachers/list', [TeacherController::class, 'data'])->name('teachers.data');
Route::put('admin/teachers/update{id}', [TeacherController::class, 'update'])->name('teachers.data.update');
Route::delete('admin/teachers/delete{id}', [TeacherController::class, 'delete'])->name('teachers.data.delete');
Route::get('admin/teachers/archive', [TeacherController::class, 'archive'])->name('teachers.data.archive');
Route::patch('admin/teachers/archive/{id}', [TeacherController::class, 'restore'])->name('teachers.data.restore');
Route::post('admin/teachers/password/rest/{id}', [TeacherController::class, 'resetPass'])->name('teachers..reset.password');
//guardian route

Route::get('admin/create/guardians', [GuardianController::class, 'index'])->name('guardians.create');
Route::post('admin/create/guardians', [GuardianController::class, 'create'])->name('guardians.create.post');
Route::get('admin/guardians/list', [GuardianController::class, 'data'])->name('guardians.data');
Route::put('admin/guardians/update{id}', [GuardianController::class, 'update'])->name('guardians.update');
Route::delete('admin/guardians/delete{id}', [GuardianController::class, 'delete'])->name('guardians.delete');
Route::get('admin/guardians/archive', [GuardianController::class, 'archive'])->name('guardians.archive');
Route::patch('admin/guardians/restore/{id}', [GuardianController::class, 'restore'])->name('guardians.restore');
Route::post('admin/guardians/restore/all', [GuardianController::class, 'restoreAll'])->name('guardians.restore.all');

//guardian reset password
Route::post('admin/guardians/password/reset/{id}', [GuardianController::class, 'resetPass'])->name('guardian.password.reset');

//Strand Route
   Route::get('/admin/add/strand', [StrandController::class, 'index'])->name('strand.index');
Route::post('/admin/add/strand', [StrandController::class, 'strandPost'])->name('strand.post');
Route::put('/admin/add/strand/update/{id}', [StrandController::class, 'update'])->name('strand.update');  
Route::delete('/admin/add/strand/delete/{id}', [StrandController::class, 'delete'])->name('strand.delete'); 


//Add subject route to strand
  Route::get('admin/strand/add/subject/{id}', [StrandSubController::class, 'index'])->name('strandsub.index');
  Route::post('admin/strand/add/subject/{id}', [StrandSubController::class, 'create'])->name('strandsub.create');
  Route::delete('admin/strand/delete/{id}', [StrandSubController::class, 'delete'])->name('strandsub.delete');

    //subject Route

  Route::get('admin/subjects/create', [SubjectController::class, 'index'])->name('subject.index');
  Route::post('admin/subjects/create', [SubjectController::class, 'create'])->name('subject.create');
  Route::put('admin/subjects/update/{id}', [SubjectController::class, 'update'])->name('subject.update');
  Route::delete('admin/subjects/delete/{id}', [SubjectController::class, 'delete'])->name('subject.delete');

    //section route

    Route::get('/admin/section', [SectionController::class, 'index'])->name('section.index');
    Route::post('/admin/section', [SectionController::class, 'create'])->name('section.post.create');
    Route::put('/admin/section/update/{id}', [SectionController::class, 'update'])->name('section.post.update');
     Route::delete('/admin/section/delete{id}', [SectionController::class, 'delete'])->name('section.post.delete');

     //Add student to section route

     Route::get('/admin/section/student/strand/{strand_id}/level/{grade_level_id}/section/{section_id}', [SectionStudentController::class, 'index'])->name('section.student.index');
    Route::post('/admin/section/student/strand/section/{section_id}', [SectionStudentController::class, 'addStudent'])->name('section.student.add');
      Route::delete('/admin/section/student/strand/section/{id}', [SectionStudentController::class, 'delete'])->name('section.student.delete');

    //admin change profile route
    Route::get('admin/profile', [AdminController::class, 'changeProfile'])->name('admin.profile');
    Route::post('admin/profile/post', [AdminController::class, 'changeProfilePost'])->name('admin.profile.post');
       //change password
    
       Route::get('admin/change/password', [AdminController::class, 'changePassword'])->name('admin.change.password');
       Route::post('admin/change/password', [AdminController::class, 'updatePassword'])->name('admin.update.password');
    

     //School year Route

     Route::get('admin/school/year', [SchoolyearController::class, 'index'])->name('school.year');
     Route::post('admin/school/year', [SchoolyearController::class, 'schoolYearPost'])->name('school.year.post');
      Route::put('admin/school/year/update/{id}', [SchoolyearController::class, 'update'])->name('school.year.update');
     Route::put('admin/school/year/active/{id}', [SchoolyearController::class, 'active'])->name('school.year.active');

    //Semester Route

    Route::get('admin/semester/', [SemesterController::class, 'index'])->name('semester');
    Route::post('admin/semester/', [SemesterController::class, 'create'])->name('semester.add.post');
    Route::put('admin/semester/status/deactive/{id}', [SemesterController::class,  'deactive'])->name('semester.deactive.status');
    Route::put('admin/semester/status/active/{id}', [SemesterController::class,  'active'])->name('semester.active.status');
    Route::put('admin/semester/update/{id}', [SemesterController::class,  'update'])->name('semester.update');
    

    //Grade level Route




     //grading route
  
  Route::get('admin/grades', [GradingController::class, 'index'])->name('grading.index');
Route::put('admin/grades/post/{id}', [GradingController::class, 'postGrades'])->name('grading.post');
Route::post('admin/grades/post/all', [GradingController::class, 'postAllGrades'])->name('grading.all.post');
Route::delete('admin/grades/delete/{id}', [GradingController::class, 'delete'])->name('grading.delete');

    //classes route

//senior high school classes

Route::get('admin/school/classes', [AddClassController::class, 'schoolClasses'])->name('admin.school.classes');

//add class to strand
Route::get('admin/classes/fetch/data{id}', [AdminController::class, 'fetchdata'])->name('classes.fetchdata');
Route::get('admin/classes/strand/{strand}/{id}', [AddClassController::class, 'index'])->name('strand.class');
Route::post('admin/classes/strand/create/{id}', [AddClassController::class, 'create'])->name('strand.class.create');
Route::put('admin/classes/strand/update/{id}', [AddClassController::class, 'update'])->name('strand.class.update');
Route::delete('admin/classes/strand/delete/{id}', [AddClassController::class, 'delete'])->name('strand.class.delete');
   
//student check list

Route::get('admin/student/checklist/{id}', [CheckListController::class, 'checklist'])->name('admin.student.checklist');


//student to guardian

Route::get('admin/student/guardian/{id}', [StudentGuardianController::class, 'index'])->name('student.guardian.index');
Route::post('admin/student/guardian/{id}', [StudentGuardianController::class, 'addStudent'])->name('student.guardian.create');
Route::get('admin/student/guardian/list/{id}', [StudentGuardianController::class, 'studentList'])->name('student.guardian.list');
Route::delete('admin/student/guardian/delete/{id}', [StudentGuardianController::class, 'delete'])->name('student.guardian.delete');


//admin route
Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('/admin/data/table', [AdminController::class, 'adminTable'])->name('admin-table');



Route::middleware(['superAdmin'])->prefix('admin/create')->group(function () {
   
    Route::get('admin/create/admin', [AdminController::class, 'addAdmin'])->name('admin.create');
    Route::post('admin/create/admin', [AdminController::class, 'create'])->name('admin.create.post');
    Route::get('admin/data/admin', [AdminController::class, 'data'])->name('admin.data');
   Route::put('admin/data/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
   Route::delete('admin/data/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
      Route::post('admin/data/admin/delete/all', [AdminController::class, 'deleteAll'])->name('admin.delete.all');
    Route::get('admin/data/admin/archive', [AdminController::class, 'archive'])->name('admin.archive');





     Route::patch('admin/restore/{id}', [AdminController::class, 'restore'])->name('admin.restore');
    

});

 Route::post('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin-logout');

});



//guardian middlware

Route::middleware('guardian')->group(function (){



  Route::get('home/guardian', [GuardiansAuthController::class, 'home'])->name('guardian.home');
Route::get('guardian/students/list', [GuardiansAuthController::class, 'studentList'])->name('guardian.students');
Route::get('guardian/student/grades/{student_id}', [GuardiansAuthController::class, 'studentGrades'])->name('guardian.student.grades');
Route::get('guardian/student/class/{student_id}', [GuardiansAuthController::class, 'studentClass'])->name('guardian.student.class');
Route::get('guardian/chechklist/student/{student_id}', [GuardiansAuthController::class, 'checklist'])->name('guardian.student.checklist');
Route::post('guardian/logout', [GuardiansAuthController::class, 'logout'])->name('guardian.logout');
Route::get('guardian/profile', [GuardiansAuthController::class, 'profile'])->name('guardian.profile');
Route::post('guardian/update/profile', [GuardiansAuthController::class, 'updateProfile'])->name('guardian.update.profile');
Route::get('guardian/change/password', [GuardiansAuthController::class, 'changePassword'])->name('guardian.change.password');
Route::put('guardian/update/password', [GuardiansAuthController::class, 'updatePassword'])->name('guardian.update.password');
});























Route::middleware('teacher')->group(function(){


  Route::post('/teacher/logout', [TeacherLoginController::class, 'logout'])->name('teacher.logout');


//teacher dashboard
  Route::get('/teacher/dashboard', [TeacherLoginController::class, 'dashboard'])->name('teacher.dashboard');


  //teacher advisory
    Route::get('/teacher/advisory', [TeacherAuthInfoController::class, 'advisories'])->name('teacher.advisory');
    Route::get('/teacher/advisory/grades', [TeacherAuthInfoController::class, 'advisoriesGrades'])->name('teacher.advisory.grades');

//teacher //classes
 Route::get('/teacher/classes', [TeacherAuthInfoController::class, 'classes'])->name('teacher.classes');

 //students in a class
   Route::get('/teacher/classes/students/{strand_id}/{grade_level_id}/{section_id}/{subject_id}/{class_id}', [TeacherAuthInfoController::class, 'classStudents'])->name('teacher.classes.student');


//student all grades

//import grades through excel
Route::get('/teacher/import/student/grades', [ImportGradesController::class, 'index'])->name('import.grades');
Route::post('/teacher/import/student/grades/post', [ImportGradesController::class, 'import'])->name('import.grades.post');

  //grades written works computation


  Route::get('/teacher/input/grade/writtenworks/{student_id}/{subject_id}', [WrittenWorksController::class, 'writtenWorks'])->name('student.written');
Route::post('/teacher/input/grade/student/{student_id}/{subject_id}', [WrittenWorksController::class, 'computeWrittenWorks'])->name('student.written.post');
Route::put('/teacher/input/grade/student/{student_id}/{subject_id}/{ws_id}', [WrittenWorksController::class, 'update'])->name('student.written.update');
    Route::delete('/teacher/input/grade/student/delete{id}', [WrittenWorksController::class, 'delete'])->name('ws.delete');


    //grades performance task computation computation
      Route::get('/teacher/input/grade/performance/{student_id}/{subject_id}', [PerformanceController::class, 'index'])->name('student.perform');
Route::post('/teacher/input/grade/performance/{student_id}/{subject_id}', [PerformanceController::class, 'compute'])->name('student.perform.post');
Route::put('/teacher/input/grade/student/performace/{student_id}/{subject_id}/{pt_id}', [PerformanceController::class, 'update'])->name('student.perform.update');
Route::delete('/teacher/input/grade/student/performance/delete{id}', [PerformanceController::class, 'delete'])->name('perform.delete');

//assesment grade computation
Route::get('/teacher/input/grade/assessment/{student_id}/{subject_id}', [AssesmentController::class, 'index'])->name('student.assessment');
Route::post('/teacher/input/grade/assessment/{student_id}/{subject_id}', [AssesmentController::class, 'compute'])->name('student.assessment.post');
Route::put('/teacher/input/grade/student/assessment/update/{student_id}/{subject_id}/{as_id}', [AssesmentController::class, 'update'])->name('student.assessment.update');
    Route::delete('/teacher/input/grade/student/assessment/delete{id}', [AssesmentController::class, 'delete'])->name('assesment.delete');
//Enter Final Grade
  Route::get('/teacher/input/grade/student/{student_id}/{subject_id}/', [FirstGradeController::class, 'index'])->name('student.grades.compute');
    Route::post('/teacher/input/grade/student/finalgrades/{student_id}/{subject_id}', [FirstGradeController::class, 'saveGrades'])->name('student.grades.post');








//promote students
Route::put('/student/promote/{id}/{section_id}', [TeacherAuthInfoController::class, 'promoteStudent'])->name('student.promote');
Route::put('/students/promote/all', [TeacherAuthInfoController::class, 'promoteAll'])->name('students.promote.all');

//profile and change password
Route::get('/teacher/profile', [TeacherAuthInfoController::class, 'profile'])->name('teacher.profile');
Route::put('/teacher/change/profile', [TeacherAuthInfoController::class, 'changeProfile'])->name('teacher.change.profile');
Route::get('/teacher/change/password', [TeacherAuthInfoController::class, 'changePassword'])->name('teacher.password');
Route::put('/teacher/update/password', [TeacherAuthInfoController::class, 'updatePassword'])->name('teacher.password.update');
});
  
//forgot password route

Route::get('forgot/password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot.password');
Route::post('forgot/password', [ForgotPasswordController::class, 'forgotPasswordPost'])->name('forgot.password.post');
Route::get('reset/password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');
Route::post('reset/new/password', [ForgotPasswordController::class, 'resetPasswordPost'])->name('reset.password.post');

//student route middleware
Route::middleware('student')->group(function(){

Route::get('/student/dashboard', [StudentAuthController::class, 'index'])->name('student.index');
//student subject route

Route::get('/student/subjects', [StudentAuthController::class, 'subject'])->name('student.subject');

//student grade route

Route::get('/student/grades', [StudentAuthController::class, 'grades'])->name('student.grades');

//student logout

Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
//student class

Route::get('student/class', [StudentAuthController::class, 'class'])->name('student.class');
//student check list
Route::get('student/check/list', [CheckListController::class, 'index'])->name('student.checklist');
//student change profile and password
Route::get('student/profile', [StudentAuthController::class, 'profile'])->name('student.profile');
Route::put('student/change/profile', [StudentAuthController::class, 'changeProfile'])->name('student.change.profile');
Route::get('student/change/password', [StudentAuthController::class, 'changePassword'])->name('student.password');
Route::put('student/update/password', [StudentAuthController::class, 'updatePassword'])->name('student.update.password');
});



