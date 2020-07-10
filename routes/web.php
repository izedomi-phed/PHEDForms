<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', function () {
    return view('welcome');
});

Route::get('/error', function () {
    return view('error');
});

Auth::routes(['verify' => true]);


//HOME CONTROLLER
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'HomeController@admin')->name('admin');
Route::get("/admin/it", 'HomeController@it_dashboard')->name('it-dashboard');

/*
Route::get('/reminder/{id}', 'HomeController@reminder')->name('reminder');
Route::get('/excel', 'HomeController@excel');

Route::post('/normalize', 'HomeController@normalize');
Route::post('/batch_normalize', 'HomeController@batch_normalize');
Route::post('/sort_employees', 'HomeController@sort_employees')->name('sort');
Route::post('/download_report', 'HomeController@download_report')->name('download-report');
Route::post('/home/role_sort', 'HomeController@role_sort');


Route::get('/home/appraiser', 'HomeController@role_appraiser')->name('role-appraiser');
Route::get('/home/reviewer', 'HomeController@role_reviewer')->name('role-reviewer');

*/

//LEAVE REQUEST CONTROLLER
Route::post('/dashboard/submit_leave_request', 'LeaveRequestController@submit_leave_request')->name('submit_leave_request');
Route::get('/dashboard/leave_request_approval_list', 'LeaveRequestController@leave_request_approval_list')->name('leave-request-approval-list');





//Route::get('/home/{$role}', 'HomeController@role_appraiser')->name('role-appraiser');


/*

//EMPLOYEE CONTROLLER
Route::get('/self_appraisal', 'EmployeeController@self_appraisal');
Route::get('/send_to_appraiser', 'EmployeeController@send_appraisal_request');
Route::get('/send_to_reviewer', 'EmployeeController@send_reviewer_request');
Route::get('/send_to_hr', 'EmployeeController@send_hr_request');
Route::get('/home/profile', 'EmployeeController@profile')->name('profile');
Route::get('/home/profile/{staff_id}', 'EmployeeController@get_staff_profile_details');
Route::get('/change_role/{new_role?}/{access_level?}', 'EmployeeController@change_role')->name('change-role');


Route::post('/appraisal_details', 'EmployeeController@submit_appraisal_details');
Route::post('/performance_appraisal', 'EmployeeController@performance_appraisal');

*/

/*
//REQUEST CONTROLLER ROUTES
Route::get('/appraiser/employee/{id}/{staff_id}', 'RequestController@appraiser_action');
Route::get('/reviewer/employee/{id}/{staff_id}', 'RequestController@reviewer_action');
Route::get('/hr/employee/{id}/{staff_id}', 'RequestController@hr_action');
Route::get('/employee/{id}/{staff_id}', 'RequestController@appraisee_details');
Route::get('/download/{staff_id}', 'RequestController@download_test');
*/

/*
Route::post('/performance_appraisal_by_appraiser', 'RequestController@performance_appraisal_by_appraiser');
Route::post('/performance_appraisal_by_reviewer', 'RequestController@performance_appraisal_by_reviewer');
Route::post('/recommendation_by_appraiser', 'RequestController@recommendations_by_appraiser');
Route::post('/overall_summary_by_appraiser', 'RequestController@overall_summary_by_appraiser');
Route::post('/overall_summary_by_reviewer', 'RequestController@overall_summary_by_reviewer');
Route::post('/performance_appraisal_by_reviewer', 'RequestController@performance_appraisal_by_reviewer');
Route::post('/get_staff_details', 'RequestController@get_staff_details');
Route::post('/vue_submit', 'RequestController@vue_submit');

*/

Route::post('/api_login', 'RequestController@api_login');
Route::post('/dashboard/get_staff_details', 'RequestController@get_staff_details');


Route::get('create_admin', 'RequestController@create_admin_view');
Route::post('create_admin', 'RequestController@create_admin')->name('new_admin');


Route::get("test", 'EmployeeController@test')->name("test");
Route::post("testy", 'EmployeeController@testy')->name("testy");
Route::post("upload_proof", 'EmployeeController@upload_proof')->name("upload-proof");




//DLEnhance
Route::get('/dashboard', 'AccessRequestController@index')->name('dashboard-index');
Route::get('/dashboard/{request}', 'AccessRequestController@generic_requests')->name('access-requests');
Route::post('/dashboard/dl_enhance_request', 'AccessRequestController@dl_enhance_request')->name('dl_enhance_request');



//DLEnhance
Route::get("requests/{type}/{id}/{staff_id}", "AccessApprovalController@dl_enhance_approval")->name('dl-enhance-approval');
Route::post("requests/approval", "AccessApprovalController@requests_approval_action")->name('dl-enhance-approval-action');
Route::get('dashboard/get_current_request/{type}', "AccessApprovalController@current_request")->name('get-current-request');

//IT dashboard: DLEnhance
Route::get("admin/it/{type}", "ItDLEnhanceController@index")->name('dlenhance-dashboard');
Route::get("admin/it/{type}/{query}", "ItDlEnhanceController@get_all_requests")->name('dlenhance-requests');

//IT dashboard: Sage
Route::get("admin/it/sage", "ItSageController@index");
