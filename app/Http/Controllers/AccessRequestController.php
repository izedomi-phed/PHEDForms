<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\AppraisalRequest;
use App\Mail\Reminder;
use App\User;
use App\Staff;
use App\LeaveRequest;
use App\UnusedLeaveRequest;
use App\SignatoryLeaveRequest;
use App\DlEnhanceRequests;
use App\SageRequests;
use PDF;

class AccessRequestController extends Controller
{
    //

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware(['auth','verified']);
    }


    public function index(){
        $data = $this->get_access();
        return view('staff.dashboard', $data);
    }

    public function generic_requests($request_type){

       $data = $this->get_access($request_type);

        if($request_type == "leave"){
          return view("staff.leave_form", $data);
        }
        return view('staff.requests', $data); //sage and dlenhance
    }


    public function dl_enhance_request(Request $request){
        //return $request;

        $errors = array();
        if($request->hod_email != "" || $request->hod_email != null){
            $email = explode("@", trim($request->hod_email));
            if($email[1] != 'phed.com.ng'){
                array_push($errors, "Unauthorized user. Invalid HOD Email");

                return response()->json([
                    'errors' => $errors,
                    'validaton' => true,
                ], 200);
            }
        }

        $val = $this->val($request->all());
        if($val->fails()){
            //return $val->errors();
            $errors = array();
            foreach($val->errors()->all() as $message) {
               array_push($errors, $message);
            }

            return response()->json([
                'errors' => $errors,
                'validaton' => true,
            ], 200);
        }

        $access_level = implode(",", $request->access_level);

        if($request->request_type == 'dl_enhance'){
            $role = null;
            if(count($request->role) > 0){
                $role = implode(",", $request->role);
            }

            $existingR = DlEnhanceRequests::where('account_id', Auth::user()->id)->first();
            if($existingR != null){
                $new_request = $existingR;
            }
            else{
                $new_request = new DlEnhanceRequests;
            }


            $new_request->role = $role;
        }
        if($request->request_type == 'sage'){

            $hr_module = null;
            $finance_module = null;
            if(count($request->hr_module) > 0){
                $hr_module = implode(",", $request->hr_module);
            }
            if(count($request->finance_module) > 0){
                $finance_module = implode(",", $request->finance_module);
            }

            //return $request;
            $existingR = SageRequests::where('account_id', Auth::user()->id)->first();
            if($existingR != null){
                $new_request = $existingR;
            }
            else{
                $new_request = new SageRequests;
            }

            $new_request->hr_module = $hr_module;
            $new_request->finance_module = $finance_module;

        }

        $account_id = Auth::user()->id;
        $user = User::find($account_id);
        $fullname = $request->first_name . " ". $request->last_name . " ". $request->other_name;
        $user->name = $fullname;


        $new_request->account_id = $account_id;
        $new_request->staff_id = $request->staff_id;
        $new_request->name = $fullname;
        $new_request->staff_type = $request->staff_type;
        $new_request->job_desc = $request->job_desc;
        $new_request->designation = $request->designation;
        $new_request->access_level = $access_level;
        $new_request->location = $request->location;
        $new_request->department = $request->department;
        $new_request->termination_date = $request->termination_date;
        $new_request->mobile_no = $request->mobile_no;
        $new_request->work_no = $request->work_no;
        $new_request->hod_name = $request->hod_name;
        $new_request->hod_email = $request->hod_email;
        $new_request->status = "TO_HOD";
        $new_request->save();
        $user->save();

        if($request->request_type == "dl_enhance"){
            $subject = "PHEDC DLEnhance Access Request";
        }
        else{
            $subject = "PHEDC Sage X3 ERP Access Request";
        }

        $msg = new Reminder($request->request_type, $new_request->id, $request->staff_id, "TO_HOD");
        $msg->subject($subject);
        Mail::to(trim($request->hod_email))->send($msg);

    }

    public  function get_access($request_type = 'dl_enhance'){

        $isAppraiser = false;
        $isReviewer = false;

        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];

        $name = explode(" ", trim(Auth::user()->name));
        $lastname = $name[0];
        $firstname = "";
        $other_name = "";
        if(count($name) > 1){
            $firstname = $name[1];
        }
        if(count($name) > 2){
            $other_name = $name[2];
        }

        //get count of leave request yet to be attended to
        $slr_count = SignatoryLeaveRequest::where('email', Auth::user()->email)->where('completed', "FALSE")->count();


        return array(
            'email' => Auth::user()->email,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'otherName' => $other_name,
            'isAppraiser' => $isAppraiser,
            'isReviewer' => $isReviewer,
            'staffId' => Auth::user()->staff_id,
            'accessLevel' => $accessLevel,
            'requestType' => $request_type,
            'leave_request_count' => $slr_count

        );
    }

    public function val($data){

        return Validator::make($data, [
            'staff_id' => ['required', 'string', 'max:255',],
            'official_email' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'designation' => ['required', 'string'],
            'staff_type' => ['required', 'string'],
            'job_desc' => ['required', 'string'],
            'location' => ['required', 'string'],
            'department' => ['required', 'string'],
            'mobile_no' => ['required'],
            'work_no' => ['required'],
            'hod_name' => ['required', 'string'],
            'hod_email' => ['required', 'string'],
        ]);
    }

}
