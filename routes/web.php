<?php
// Mail
use App\Mail\sendEmail;
// Facades
use Illuminate\Support\Facades\{Auth, Route, Mail};
use App\Http\Controllers\Student\MeStudentGradeController;
use App\Http\Controllers\SemesteryearController;
// Shared Restful Controllers
use App\Http\Controllers\All\{
    ProfileController,
    TmpImageUploadController
};

// Admin Restful Controllers
use App\Http\Controllers\Admin\{
    DashboardController,
    ActivityLogController,
    AttendanceController as AdminAttendanceController,
    CategoryController,
    CourseController,
    DepartmentController,
    PatientController,
    PerformanceController as AdminPerformanceController,
    MeritanddemeritController as AdminMeritanddemeritController,
    PlatoonController,
    SettingsController,
    StudentController,
    StudentGradeController as AdminStudentGradeController,
    AttendanceRecordsController as AdminAttendanceRecordsController,
    FinalStudentGrade,
    UserController
};

use App\Http\Controllers\API\{
    AuthController as ApiAuthController,
};

// Auth Restful Controller
use App\Http\Controllers\Auth\{
    AuthController
};

// Main Restful Controller
use App\Http\Controllers\Main\{
    PagesController
};

// use App\Http\Controllers\FilterController;

// Platoon Leader Restful Controller
use App\Http\Controllers\PlatoonLeader\{
    AttendanceController as PlatoonLeaderAttendanceController,
    AttendanceMonitoringController,
    StudentFinalGradeController,
    StudentGradeController,
    DashboardController as PlatoonLeaderDashboardController,
    PerformanceController,
    MeritanddemeritController,
    AttendanceRecordsController,
    UpdateAttendanceRecordsController,
    StudentController as PlatoonLeaderStudentController,

};


// Student Restful Controller
use App\Http\Controllers\Student\{
    AttendanceController,
    PerformanceController as StudentPerformanceController
};
use DeepCopy\Filter\Filter;

Route::get('/', function () {
    return to_route('auth.login');
})->name('main.home');

// // Guest
// Route::group(['as' => 'main.'],function() {

//      Route::controller(PagesController::class)->group(function () {
//         Route::get('/', 'home')->name('home');
//     });

// });
// routes/web.php

// Admin
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard.index');
    /** Start Student Management */
    Route::resource('departments', DepartmentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('platoons', PlatoonController::class);
    Route::resource('students', StudentController::class);
    /** End Student Management */
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('patients', PatientController::class);
    //Route::get('role', RoleController::class)->name('role.index');
    Route::get('activity_logs', ActivityLogController::class)->name('activity_logs.index');
    Route::get('attendances', AdminAttendanceController::class)->name('attendances.index');
    Route::resource('performances', AdminPerformanceController::class);
    Route::resource('settings', SettingsController::class);

    Route::resource('attendance-records', AdminAttendanceRecordsController::class);
    // Route::get('records',[AdminAttendanceRecordsController::class, 'index'])->name('records');
    Route::get('records', [AdminAttendanceRecordsController::class, 'records'])->name('records');
    Route::get('merits-demerits/get', [AdminMeritanddemeritController::class, 'get']);
    Route::resource('aptitude', AdminMeritanddemeritController::class);
    Route::resource('studentgrade', AdminStudentGradeController::class);
    Route::resource('finalstudentgrade', FinalStudentGrade::class);
    Route::get('finalstudentgrade/get', [FinalStudentGrade::class, "get"]);
});

// Platoon leader
Route::group(['middleware' => ['auth', 'platoon_leader'], 'prefix' => 'platoon_leader', 'as' => 'platoon_leader.'], function () {

    Route::get('dashboard', PlatoonLeaderDashboardController::class)->name('dashboard.index');
    Route::resource('students', PlatoonLeaderStudentController::class);
    Route::resource('attendance-monitoring', AttendanceMonitoringController::class)->only('index', 'store');
    Route::resource('studentgrade', StudentGradeController::class);
    Route::resource('studentfinalgrade', StudentFinalGradeController::class);
    Route::resource('attendance-records', AttendanceRecordsController::class);
    Route::get('records', [AttendanceRecordsController::class, 'index'])->name('records');
    Route::get('show', [AttendanceRecordsController::class, 'show'])->name('show');
    Route::get('update_merits', [UpdateAttendanceRecordsController::class, 'update_merits'])->name('update_merits');
    Route::get('update_records', [UpdateAttendanceRecordsController::class, 'update_records'])->name('update_records');
    Route::get('attendances', PlatoonLeaderAttendanceController::class)->name('attendances.index');
    Route::get('merits-demerits/get', [MeritanddemeritController::class, 'get']);
    Route::resource('merits-demerits', MeritanddemeritController::class);
    Route::resource('performances', PerformanceController::class);
});

// Student
Route::group(['middleware' => ['auth', 'student'], 'prefix' => 'student', 'as' => 'student.'], function () {
    Route::get('attendances', AttendanceController::class)->name('attendances.index');
    Route::resource('performances', StudentPerformanceController::class);
    Route::resource('mestudentgrade', MeStudentGradeController::class);
    Route::get('performances/get', [StudentPerformanceController::class, 'get']);
});


// Auth
Route::group(['middleware' => ['auth']], function () {
    Route::delete('tmp_upload/revert', [TmpImageUploadController::class, 'revert']);     // TMP FILE UPLOAD
    Route::resource('tmp_upload', TmpImageUploadController::class);
    Route::resource('profile', ProfileController::class)->parameter('profile', 'user');;
});


// Custom Authentication
Route::group(['as' => 'auth.'], function () {
    // Auth Routes
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'attemptLogin')->name('attempt_login');
        // Route::post('/otp', 'attemptotp')->name('attempt_otp');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'attemptRegister')->name('attempt_register');
        Route::post('/logout', 'logout')->name('logout');

        // email verification
        Route::get('/email/verify/{token}', 'emailVerification')->name('email_verification');
    });
});


Auth::routes(['login' => false, 'register' => false, 'logout' => false]);
Route::get('/otp',  [ApiAuthController::class, 'otp'])->name('api.otp');
Route::post('/otp',  [ApiAuthController::class, 'attemptOtp'])->name('api.attemptOtp');
Route::get('request_otp', [ApiAuthController::class, 'requestOtp']);
Route::resource('semesteryear', SemesteryearController::class);



// Route::post('/filter', [FilterController::class, 'store'])->name('filter.store');

// Route::get('linkstorage', function () {
//     Artisan::call('storage:link');
// });
