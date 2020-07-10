<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Staff;
use PDF;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;



class RequestController extends Controller
{
    //

    public function api_login(Request $request){

        $username = $request->username;
        $password = $request->password;


        try{
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://insight.phed.com.ng/api/PHEDConnectAPI/Login",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode([
                'username'=>"{$username}",
                'password'=>"{$password}",
              ]),
              CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                "cache-control: no-cache"
              ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if($err){
              //return $err;
              // there was an error contacting the Paystack API
              return response()->json([
                // 'errors' => ["Ooops...we couldn't connect to the server"],
                 'errors' => [$err, "Ooops...we couldn't connect"]
              ], 500);
            }

            $res = json_decode($response, true);


            if($res['Status'] == "SUCCESSFUL"){

              $staffExist = Staff::where('staff_id', $res["StaffId"])->first();
              //if ""$staffExist" is null, user is logging in for the first time
              if($staffExist == null){
                // create staff
                $staff = new Staff();
                $staff->user_id = $res["Id"];
                $staff->name = $res["StaffName"];
                $staff->staff_id = $res["StaffId"];
                $staff->email = $res["Email"];
                $staff->designation = $res["Designation"];
                $staff->zone = $res["Zone"];
                $staff->department = $res["Department"];
                $staff->location = $res["Location"];
                $staff->phone = $res["PhoneNo"];
                $staff->address = $res["Address"];
                $staff->save();
              }

              $user = User::where('staff_id', $res["StaffId"])->first();
              //if ""$user" is null, user is logging in for the first tim
              if($user == null){
                $user = new User();
                $user->name = trim($res["StaffName"]);
                $user->staff_id = trim($res["StaffId"]);
                $user->email = trim($res["Email"]);
                $user->access = "staff|staff";
                $user->password = Hash::make("PHED@123");
                $user->email_verified_at = date("Y-m-d H:i:s");
                $user->save();

              }

              $this->guard()->login($user);
          }

          return $res;
        }
        catch(Exception $e){
            //return $err;
            // there was an error contacting the Paystack API
            return response()->json([
               'errors' => [$e->getMessage(), "Temporarily unable to connect to the server. Please refresh or try again later"]
            ], 500);
        }


    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }


    //get staff details
    public function get_staff_details(Request $request){

        //return $request;
        //return $request->staff_id;
        return Staff::where('staff_id', $request->staff_id)->first();
    }

    public function vue_submit(Request $request){

        $employee = new Employee();
        $employee->account_id = trim($request->Account_Id);
        $employee->staff_id = trim($request->Staff_Id);
        $employee->designation = trim($request->Staff_Team);
        $employee->name = trim($request->Staff_Name) . " ". trim($request->Staff_Surname);
        $employee->email = trim($request->Staff_Email);
        $employee->haq =  "BSC"; //trim($request->haq);
        $employee->doe = "24th Jan. 2020"; //trim($request->doe);
        $employee->ibc = "Garden City Industrail";//trim($request->ibc);
        //$employee->status = "to_appraisal";
        $employee->save();

        $supervisor = new Supervisor();
        $supervisor->account_id = trim($request->Account_Id);
        $supervisor->staff_id = trim($request->Staff_Id);
        $supervisor->appraiser_name = trim($request->Staff_Appraiser);
        $supervisor->appraiser_email = trim($request->Staff_Appraiser_Email);
        $supervisor->reviewer_name =  trim($request->Staff_Reviewer);
        $supervisor->reviewer_email = trim($request->Staff_Reviewer_Email);
        $supervisor->save();

        $completion_status = new PerformanceCompletionForm();
        $completion_status->staff_id = trim($request->Staff_Id);
        $completion_status->account_id = trim($request->Account_Id);
        $completion_status->save();

        $user = User::findOrFail(trim($request->Account_Id));
        $user->status = "TO_COMPLETE_FORM";
        $user->save();

        return "success";


    }

    public function appraiser_action($id, $staff_id){
        $d = array(
            'id' => $id,
            'staff_id' => $staff_id
        );

        $financial = FinancialPerformance::where('staff_id', $staff_id)->get();
        $customer = CustomerPerformance::where('staff_id', $staff_id)->get();
        $process = ProcessOperationPerformance::where('staff_id', $staff_id)->get();
        $behaviour = BehaviouralAttribute::where('staff_id', $staff_id)->get();
        $training = Training::where('staff_id', $staff_id)->get();

        $c_status = PerformanceCompletionForm::where('staff_id', $staff_id)->first();
        $as = AppraiserStatus::where('staff_id', $staff_id)->first();


        $data = array(
            'financialP' => $financial,
            'customerP' => $customer,
            'processP' => $process,
            'behaviourP' => $behaviour,
            'trainingP' => $training,
            'staff_id' => $staff_id,
            'form_completion_status'=> $c_status,
            'appraiser_completion_status' => $as
        );

        //return $performance;

        return view('request.appraiser')->with($data);
    }

    public function performance_appraisal_by_appraiser(Request $request){

        //return $request;
       //return  $this->overall_summary_by_appraiser($request);
        $employee = Employee::where('staff_id', trim($request->staff_id))->first();
        $user = User::findOrfail($employee->account_id);
        $supervisor = Supervisor::where('account_id', $employee->account_id)->first();
        $user->status = "WAIT_REVIEWER";
        $supervisor->status = "WAIT_REVIEWER";


       // $msg = new AppraisalRequest($user->id, $employee->staff_id, "employee");
       // $msg->subject("PHED EMPLOYEE APPRAISAL - REVIEW COMPLETE BY APPRAISER");
       // Mail::to($employee->email)->send($msg);


        $msg = new AppraisalRequest($employee->id, $employee->staff_id, "reviewer");
        $msg->subject("PHED EMPLOYEE APPRAISAL - Request from ". $employee->name);
        Mail::to($supervisor->reviewer_email)->send($msg);



        for($count = 0; $count < count($request->rating_by_appraiser_f); $count++){

            $fp = FinancialPerformance::findOrFail($request->id_f[$count]);
            $fp->rating_by_appraiser = $request->rating_by_appraiser_f[$count];
            $fp->save();

        }

        for($count = 0; $count < count($request->rating_by_appraiser_c); $count++){

            $fp = CustomerPerformance::findOrFail($request->id_c[$count]);
            $fp->rating_by_appraiser = $request->rating_by_appraiser_c[$count];
            $fp->save();

        }

        for($count = 0; $count < count($request->rating_by_appraiser_t); $count++){

            $fp = Training::findOrFail($request->id_t[$count]);
            $fp->rating_by_appraiser = $request->rating_by_appraiser_t[$count];
            $fp->save();

        }

        for($count = 0; $count < count($request->rating_by_appraiser_p); $count++){

           $fp = ProcessOperationPerformance::findOrFail($request->id_p[$count]);
           $fp->rating_by_appraiser = $request->rating_by_appraiser_p[$count];
           $fp->save();

        }


        for($count = 0; $count < count($request->rating_by_appraiser_b); $count++){
            $fp = BehaviouralAttribute::findOrFail($request->id_b[$count]);
            $fp->rating_by_appraiser = $request->rating_by_appraiser_b[$count];
            $fp->save();

        }

        $this->overall_summary_by_appraiser($request);
        $this->recommendations_by_appraiser($request);

        $as = AppraiserStatus::where('staff_id', trim($request->staff_id))->first();
        $as->overall = "1";
        $as->recommendation = "1";


        $user ->save();
        $as->save();
        $supervisor->save();
        return redirect()->route('role-appraiser')->with('success', "Employee appraisal successfully completed and submitted.\nThank you for you time.");
        //return back()->with('success', "Employee appraisal successfully completed and submitted.\nThank you for you time.");


    }

    public function recommendations_by_appraiser($request){
        //return $request;
        $rec = Recommendation::where('staff_id', trim($request->staff_id))->first();
        $rec->staff_id = trim($request->staff_id);
        $rec->job_rotation = trim($request->job_rotation);
        $rec->job_rotation_recommendation = trim($request->job_rotation_recommendation);
        $rec->job_enhancement = trim($request->job_enhancement);
        $rec->job_enhancement_recommendation = trim($request->job_enhancement_recommendation);
        $rec->promotion = trim($request->promotion);
        $rec->promotion_justification = trim($request->promotion_justification);
        $rec->training = trim($request->training_needs);
        $rec->training_recommendation = trim($request->training_needs_recommendation);
        if(trim($request->training_needs) == "NO"){
            $rec->training_recommendation = null;
        }
        $rec->others = trim($request->others);
        $rec->save();
    }

    public function overall_summary_by_appraiser($request){
        //return $request;
        //return $request->a;
        $os = OverallSummary::where('staff_id', trim($request->staff_id))->first();
        $os->staff_id = trim($request->staff_id);
        $os->a_performance = trim($request->performance);
        $os->a_attributes = trim($request->attribute);
        $os->a_training = trim($request->training);
        $os->a_overall = trim($request->overall);
        $os->save();
    }


    // reviewer actions
    public function reviewer_action($id, $staff_id){

        $financial = FinancialPerformance::where('staff_id', $staff_id)->get();
        $customer = CustomerPerformance::where('staff_id', $staff_id)->get();
        $process = ProcessOperationPerformance::where('staff_id', $staff_id)->get();
        $behaviour = BehaviouralAttribute::where('staff_id', $staff_id)->get();
        $training = Training::where('staff_id', $staff_id)->get();
        $recommendation = Recommendation::where('staff_id', $staff_id)->first();
        $summary = OverallSummary::where('staff_id', $staff_id)->first();

        $c_status = PerformanceCompletionForm::where('staff_id', $staff_id)->first();
        $as = AppraiserStatus::where('staff_id', $staff_id)->first();

        $data = array(
            'financialP' => $financial,
            'customerP' => $customer,
            'processP' => $process,
            'behaviourP' => $behaviour,
            'trainingP' => $training,
            'recommendation' => $recommendation,
            'summary' => $summary,
            'staff_id' => $staff_id,
            'form_completion_status'=> $c_status,
            'appraiser_completion_status' => $as
        );

        //return $performance;

        return view('request.reviewer')->with($data);
    }

    public function performance_appraisal_by_reviewer(Request $request){

        //return $request;

         //return $request;
       //return  $this->overall_summary_by_appraiser($request);

        $employee = Employee::where('staff_id', trim($request->staff_id))->first();
        $user = User::findOrfail($employee->account_id);
        $supervisor = Supervisor::where('account_id', $employee->account_id)->first();
        $user->status = "COMPLETED";
        $supervisor->status = "COMPLETED";


        $msg = new AppraisalRequest($employee->id, $employee->staff_id, "hr");
        $msg->subject("PHED EMPLOYEE APPRAISAL - APPRAISAL COMPLETED BY ". $employee->name);
        Mail::to($supervisor->hr_email)->send($msg); //hr emaill is not known yet


        $msg = new AppraisalRequest($user->id, $employee->staff_id, "employee");
        $msg->subject("PHED EMPLOYEE APPRAISAL - REVIEW COMPLETED BY REVIEWER");
        Mail::to($user->email)->send($msg);


        for($count = 0; $count < count($request->rating_by_reviewer_f); $count++){

            $fp = FinancialPerformance::findOrFail($request->id_f[$count]);
            $fp->rating_by_reviewer = $request->rating_by_reviewer_f[$count];
            $fp->save();

        }

        for($count = 0; $count < count($request->rating_by_reviewer_c); $count++){

            $fp = CustomerPerformance::findOrFail($request->id_c[$count]);
            $fp->rating_by_reviewer = $request->rating_by_reviewer_c[$count];
            $fp->save();

        }

        for($count = 0; $count < count($request->rating_by_reviewer_t); $count++){

            $fp = Training::findOrFail($request->id_t[$count]);
            $fp->rating_by_reviewer = $request->rating_by_reviewer_t[$count];
            $fp->save();

        }

        for($count = 0; $count < count($request->rating_by_reviewer_p); $count++){

           $fp = ProcessOperationPerformance::findOrFail($request->id_p[$count]);
           $fp->rating_by_reviewer = $request->rating_by_reviewer_p[$count];
           $fp->save();

        }


        for($count = 0; $count < count($request->rating_by_reviewer_b); $count++){
            $fp = BehaviouralAttribute::findOrFail($request->id_b[$count]);
            $fp->rating_by_reviewer = $request->rating_by_reviewer_b[$count];
            $fp->save();

        }

        $os = OverallSummary::where('staff_id', trim($request->staff_id))->first();
        $os->staff_id = trim($request->staff_id);
        $os->r_performance = trim($request->performance);
        $os->r_attributes = trim($request->attribute);
        $os->r_training = trim($request->training);
        $os->r_overall = trim($request->overall);

        $as = AppraiserStatus::where('staff_id', trim($request->staff_id))->first();
        $as->is_approved = "1";

        $c_status = PerformanceCompletionForm::where('staff_id', $request->staff_id)->first();
        $c_status->financial = 3;
        $c_status->customer = 3;
        $c_status->behaviour = 3;
        $c_status->process = 3;
        $c_status->training = 3;


        $user ->save();
        $os->save();
        $as->save();
        $supervisor->save();
        $c_status->save();

        return redirect()->route('role-reviewer')->with('success', "Employee appraisal successfully completed and submitted.\nThank you for you time.");
        //return back()->with('success', "Appraisal review completed and submitted successfully");


    }

    public function overall_summary_by_reviewer($request){
        //return $request;

        $os = OverallSummary::where('staff_id', trim($request->staff_id))->first();
        $os->staff_id = trim($request->staff_id);
        $os->r_performance = trim($request->performance);
        $os->r_attributes = trim($request->attribute);
        $os->r_training = trim($request->training);
        $os->r_overall = trim($request->overall);
        $os->save();

        $as = AppraiserStatus::where('staff_id', trim($request->staff_id))->first();
        $as->is_approved = "1";
        $as->save();


        $c_status = PerformanceCompletionForm::where('staff_id', $request->staff_id)->first();
        $c_status->financial = 3;
        $c_status->customer = 3;
        $c_status->behaviour = 3;
        $c_status->process = 3;
        $c_status->training = 3;
        $c_status->save();


        return back()->with('success', "submitted successfully");
        return back()->with('success', 'Overall summary submitted');
    }

    public function appraisee_details($id, $staff_id){
        $financial = FinancialPerformance::where('staff_id', $staff_id)->get();
        $customer = CustomerPerformance::where('staff_id', $staff_id)->get();
        $process = ProcessOperationPerformance::where('staff_id', $staff_id)->get();
        $behaviour = BehaviouralAttribute::where('staff_id', $staff_id)->get();
        $training = Training::where('staff_id', $staff_id)->get();
        $recommendation = Recommendation::where('staff_id', $staff_id)->first();
        $summary = OverallSummary::where('staff_id', $staff_id)->first();
        $employee = Employee::where('staff_id', $staff_id)->first();
        $supervisors = Supervisor::where('staff_id', $staff_id)->first();

        $c_status = PerformanceCompletionForm::where('staff_id', $staff_id)->first();
        $as = AppraiserStatus::where('staff_id', $staff_id)->first();

        $data = array(
            'financialP' => $financial,
            'customerP' => $customer,
            'processP' => $process,
            'behaviourP' => $behaviour,
            'trainingP' => $training,
            'recommendation' => $recommendation,
            'summary' => $summary,
            'supervisor' => $supervisors,
            'employee' => $employee,
            'staff_id' => $staff_id,
        );

        //return $performance;

        return view('request.appraisee')->with($data);
    }

    public function download_test($staff_id){

        $financial = FinancialPerformance::where('staff_id', $staff_id)->get();
        $customer = CustomerPerformance::where('staff_id', $staff_id)->get();
        $process = ProcessOperationPerformance::where('staff_id', $staff_id)->get();
        $behaviour = BehaviouralAttribute::where('staff_id', $staff_id)->get();
        $training = Training::where('staff_id', $staff_id)->get();
        $recommendation = Recommendation::where('staff_id', $staff_id)->first();
        $summary = OverallSummary::where('staff_id', $staff_id)->first();
        $employee = Employee::where('staff_id', $staff_id)->first();
        $supervisors = Supervisor::where('staff_id', $staff_id)->first();

        $c_status = PerformanceCompletionForm::where('staff_id', $staff_id)->first();
        $as = AppraiserStatus::where('staff_id', $staff_id)->first();

        $data = array(
            'financialP' => $financial,
            'customerP' => $customer,
            'processP' => $process,
            'behaviourP' => $behaviour,
            'trainingP' => $training,
            'recommendation' => $recommendation,
            'summary' => $summary,
            'supervisor' => $supervisors,
            'employee' => $employee,
            'staff_id' => $staff_id,
        );

        //$users = User::all();

        return PDF::loadView('download_test', compact('data'))->stream($employee->name."-phed-2019-appraisal.pdf");
        //return PDF::loadView('test', compact('data'))->stream('t.pdf');
    }


    public function create_admin_view(){
        return view('admin.create_admin');
    }

    public function create_admin(Request $request){

        $request->validate([
            'name' => 'required|string',
            'staff_id' => 'required|string',
            'email' => 'email|required|unique:users',
            'access' => 'string|required',
            'password' => 'string|required',
            'password_confirmation' => 'string|required'
        ]);

        //return $request;

        $e = explode("@", $request->email);
        if($e[1] != "phed.com.ng"){
            return back()->with('error', 'Invalid email entered');
        }
        if($request->password != $request->password_confirmation){
            return back()->with('error', "Password does not match");
        }

        $access = strtolower(trim($request->access));
        $access = "{$access}|{$access}";

        $user = new User();
        $user->name = trim($request->name);
        $user->staff_id = trim($request->staff_id);
        $user->email = trim($request->email);
        $user->access = $access;
        $user->password = Hash::make(trim($request->password));
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->save();

        return redirect('login')->with('success', 'account created. Login to continue.');
    }

}
