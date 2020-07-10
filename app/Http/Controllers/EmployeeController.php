<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\AppraisalRequest;
use App\Employee;
use App\Supervisor;
use App\FinancialPerformance;
use App\CustomerPerformance;
use App\ProcessOperationPerformance;
use App\PerformanceCompletionForm;
use App\BehaviouralAttribute;
use App\Training;
use App\User;
use App\Recommendation;
use App\OverallSummary;
use App\AppraiserStatus;
use App\Proof;
use App\Ibc;

class EmployeeController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware(['auth','verified']);    
    }
    

    public function submit_appraisal_details(Request $request){

        $val =  Validator::make($request->all(), [
            'staff_id' => ['required', 'string', 'max:255'],
            'official_email' => ['required', 'string', 'email', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'haq' => ['required', 'string'],
            'doe' => ['required'],
            'appraiser_first_name' => ['required', 'string'],
            'appraiser_last_name' => ['required', 'string'],
            'appraiser_email' => ['required', 'string'],
            'reviewer_first_name' => ['required', 'string'],
            'reviewer_last_name' => ['required', 'string'],
            'reviewer_email' => ['required', 'string'],
            'ibc' => ['required', 'string']
        ]);

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
        else{

            $errors = array();
            $email = explode("@", trim($request->appraiser_email));
            if($email[1] != 'phed.com.ng'){
                array_push($errors, "Incorrect entry! Invalid Appraiser Email");
               
                return response()->json([
                    'errors' => $errors,
                    'validaton' => true,
                ], 200);
            }

            $email = explode("@", trim($request->reviewer_email));
            if($email[1] != 'phed.com.ng'){
                array_push($errors, "Incorrect entry! Invalid Reviewer Email");
               
                return response()->json([
                    'errors' => $errors,
                    'validaton' => true,
                ], 200);
            }

            $employee = new Employee();
            $employee->account_id = Auth::user()->id;
            $employee->staff_id = trim($request->staff_id);
            $employee->designation = trim($request->designation);
            $employee->name = trim($request->first_name) . " " . trim($request->middle_name) . " ". trim($request->last_name);
            $employee->email = Auth::user()->email;//trim($request->official_email);
            $employee->haq = trim($request->haq);
            $employee->doe = trim($request->doe);
            $employee->ibc = trim($request->ibc);
            //$employee->status = "to_appraisal";
            $employee->save();

            $supervisor = new Supervisor();
            $supervisor->account_id = Auth::user()->id;
            $supervisor->staff_id = trim($request->staff_id);
            $supervisor->appraiser_name = trim($request->appraiser_first_name). " ". trim($request->appraiser_last_name);
            $supervisor->appraiser_email = strtolower(trim($request->appraiser_email));
            $supervisor->reviewer_name =  trim($request->reviewer_first_name). " ". trim($request->reviewer_lastname_name);
            $supervisor->reviewer_email = strtolower(trim($request->reviewer_email));
            $supervisor->save();

            $completion_status = new PerformanceCompletionForm();
            $completion_status->staff_id = trim($request->staff_id);
            $completion_status->account_id = Auth::user()->id;
            $completion_status->save();

            $user = User::find(Auth::user()->id);
            $user->status = "TO_COMPLETE_FORM";
            $user->name = trim($request->first_name) . " " . trim($request->middle_name) . " ". trim($request->last_name);
            $user->save();

            return "success";

            return response()->json([
                'msg' => "success",
            ], 200);

                
            return redirect('self_appraisal')->with('success', 'Submitted Successfully. Please fill the peformance appraisal form below to complete your appraisal. Thank you');
            //return redirect()->back();
        }
      
        
      
        

    }

    public function vue_submit(){

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

              
        return redirect('self_appraisal')->with('success', 'Submitted Successfully. Please fill the peformance appraisal form below to complete your appraisal. Thank you');
        //return redirect()->back();

    }

    public function self_appraisal(){

        
        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];
        
        
        $isAppraiser = false;
        $isReviewer = false;
        $supervisors = Supervisor::all();
        foreach($supervisors as $supervisor){
            if(Auth::user()->email == $supervisor->appraiser_email){
                $isAppraiser = true;
            }
            if(Auth::user()->email == $supervisor->reviewer_email){
                $isReviewer = true;
            }
        }
       
        $c_status = Employee::where('account_id', Auth::user()->id)->first(); 
        $c_status->request_status = Auth::user()->status;
        if($c_status != null){
            $data = array(
                'isAppraiser' => $isAppraiser,
                'isReviewer' => $isReviewer,
                'form_completion_status' => $c_status,
                'accessLevel' => $accessLevel
            );
            return view('self_appraisal')->with($data);
        }
        return back()->with('error', 'operation failed');
                   
    }

    public function performance_appraisal(Request $request){
        
       
          
        for($count = 0; $count < count($request->title_f); $count++){
            
            $fp = new FinancialPerformance();
            $fp->staff_id = $request->staff_id;
            $fp->performance_title = $request->title_f[$count];
            $fp->target_planned = $request->target_planned_f[$count];
            $fp->target_achieved = $request->target_achieved_f[$count];
            $fp->rating_by_self = $request->rating_by_self_f[$count];
            $fp->save();
            
        }

        for($count = 0; $count < count($request->title_c); $count++){
            
            $fp = new CustomerPerformance();
            $fp->staff_id = $request->staff_id;
            $fp->performance_title = $request->title_c[$count];
            $fp->target_planned = $request->target_planned_c[$count];
            $fp->target_achieved = $request->target_achieved_c[$count];
            $fp->rating_by_self = $request->rating_by_self_c[$count];
            $fp->save();
            
        }

        for($count = 0; $count < count($request->title_t); $count++){
            
            $fp = new Training();
            $fp->staff_id = $request->staff_id;
            $fp->performance_title = $request->title_t[$count];
            $fp->target_planned = $request->target_planned_t[$count];
            $fp->target_achieved = $request->target_achieved_t[$count];
            $fp->rating_by_self = $request->rating_by_self_t[$count];
            $fp->save();
            
        }

        for($count = 0; $count < count($request->title_p); $count++){
            
            $fp = new ProcessOperationPerformance();
            $fp->staff_id = $request->staff_id;
            $fp->performance_title = $request->title_p[$count];
            $fp->target_planned = $request->target_planned_p[$count];
            $fp->target_achieved = $request->target_achieved_p[$count];
            $fp->rating_by_self = $request->rating_by_self_p[$count];
            $fp->save();
            
        }



        for($count = 0; $count < count($request->title_b); $count++){
            $fp = new BehaviouralAttribute();
            $fp->staff_id = $request->staff_id;
            $fp->performance_title = $request->title_b[$count];
            $fp->rating_by_self = $request->rating_by_self_b[$count];
            $fp->save();
            
        }

        

        //return "success";

        $c_status = PerformanceCompletionForm::where('account_id', Auth::user()->id)->first();
        $c_status->financial = 1;
        $c_status->save();

        return $this->send_appraisal_request();

    }

    public function send_appraisal_request(){

        $employee = Employee::where('account_id', Auth::user()->id)->first();
        $supervisor = Supervisor::where('account_id', Auth::user()->id)->first();
        //return $employee;
       
        $user = User::where('id', Auth::user()->id)->first();
        $user->status = "WAIT_APPRAISER";
        $supervisor->status = "WAIT_APPRAISER";
        

        $rec = new Recommendation();
        $rec->staff_id = $employee->staff_id;
       

        $os = new OverallSummary();
        $os->staff_id = $employee->staff_id;
       

        $as = new AppraiserStatus();
        $as->staff_id = $employee->staff_id;
       
       
        //return $supervisor->appraiser_email;

        $msg = new AppraisalRequest($employee->id, $employee->staff_id, "appraiser");
        $msg->subject("PHED EMPLOYEE APPRAISAL - Request from ". $employee->name);
        Mail::to($supervisor->appraiser_email)->send($msg);
        //Mail::to("kingemmanuel@gmail.com")->send($msg);


        $user->save();
        $supervisor->save();
        $rec->save();
        $os->save();
        $as->save();

        
        return back()->with('success', "Appraisal report sent to APPRAISER successfully");
    }

    public function send_reviewer_request(){

        $employee = Employee::where('account_id', Auth::user()->id)->first();
        $supervisor = Supervisor::where('account_id', Auth::user()->id)->first();
        //return $employee;

        $user = User::where('id', Auth::user()->id)->first();
        $user->status = "WAIT_REVIEWER";
       
        
        $msg = new AppraisalRequest($employee->id, $employee->staff_id, "reviewer");
        $msg->subject("PHED EMPLOYEE APPRAISAL - Request from ". $employee->name);
        Mail::to($supervisor->reviewer_email)->send($msg);

        
        $user->save();


        return back()->with('success', "Mail Sent to REVIEWER");

    }

    public function send_hr_request(){
        $employee = Employee::where('account_id', Auth::user()->id)->first();
        $supervisor = Supervisor::where('account_id', Auth::user()->id)->first();
        //return $employee;
       
        $user = User::where('id', Auth::user()->id)->first();
        $user->status = "COMPLETED";
        


        $msg = new AppraisalRequest($employee->id, $employee->staff_id, "hr");
        $msg->subject("PHED EMPLOYEE APPRAISAL - Request from ". $employee->name);
        Mail::to($supervisor->hr_email)->send($msg); //hr emaill is not known yet

        $user->save();

        return back()->with('success', "Mail Sent to HR");

    }

    public function appraisal_details($id, $staff_id){
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
        );

        //return $performance;

        return view('request.appraisee')->with($data);
    }

    public function profile(){

        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];

        $isAppraiser = false;
        $isReviewer = false;
        $supervisors = Supervisor::all();
        foreach($supervisors as $supervisor){
            if(Auth::user()->email == $supervisor->appraiser_email){
                $isAppraiser = true;
            }
            if(Auth::user()->email == $supervisor->reviewer_email){
                $isReviewer = true;
            }
        }
        $data = array(
            'isAppraiser' => $isAppraiser,
            'isReviewer' => $isReviewer,
            'staffId' => Auth::user()->staff_id,
            'accessLevel' => $accessLevel
        );

        return view('staff.profile')->with($data);  
    }

    public function get_staff_profile_details($staff_id){
        $supervisor = Supervisor::where("staff_id", $staff_id)->first();
        $employee = Employee::where("staff_id", $staff_id)->first();

        $data = array(
            'supervisor' => $supervisor,
            'employee' => $employee
        );

        return $data;
    }

    public function change_role($newRole, $accessLevel){

        $user = User::where('id', Auth::user()->id)->first();
        
        $user->access = "{$newRole}|{$accessLevel}";
        $user->save();

        //return redirect(route('home'));
        return redirect()->route('home');
                

    }

    public function test(){
        return view('test');
    }

    public function testy(Request $request){
        

        $staff_id = Auth::user()->staff_id;

        for($count = 0; $count < count($request->f); $count++){
            
            $fp = new FinancialPerformance();
            $fp->staff_id = $staff_id;
            $fp->performance_title = $request->f[$count]['title'];
            $fp->target_planned = $request->f[$count]['target_planned'];
            $fp->target_achieved = $request->f[$count]['target_achieved'];
            $fp->rating_by_self = $request->f[$count]['rating_by_self'];
            $fp->save();
            
        }

        for($count = 0; $count < count($request->c); $count++){
            
            $fp = new CustomerPerformance();
            $fp->staff_id = $staff_id;
            $fp->performance_title = $request->c[$count]['title'];
            $fp->target_planned = $request->c[$count]['target_planned'];
            $fp->target_achieved = $request->c[$count]['target_achieved'];
            $fp->rating_by_self = $request->c[$count]['rating_by_self'];
            $fp->save();
            
        }

        for($count = 0; $count < count($request->t); $count++){
            
            $fp = new Training();
            $fp->staff_id = $staff_id;
            $fp->performance_title = $request->t[$count]['title'];
            $fp->target_planned = $request->t[$count]['target_planned'];
            $fp->target_achieved = $request->t[$count]['target_achieved'];
            $fp->rating_by_self = $request->t[$count]['rating_by_self'];
            $fp->save();
            
        }

        for($count = 0; $count < count($request->p); $count++){
            
            $fp = new ProcessOperationPerformance();
            $fp->staff_id = $staff_id;
            $fp->performance_title = $request->p[$count]['title'];
            $fp->target_planned = $request->p[$count]['target_planned'];
            $fp->target_achieved = $request->p[$count]['target_achieved'];
            $fp->rating_by_self = $request->p[$count]['rating_by_self'];
            $fp->save();
            $fp->save();
            
        }

        for($count = 0; $count < count($request->b); $count++){
            $fp = new BehaviouralAttribute();
            $fp->staff_id = $staff_id;
            $fp->performance_title = $request->b[$count]['title'];
            $fp->rating_by_self = $request->b[$count]['rating_by_self'];
            $fp->save();
            
        }

        //return "success";

        $c_status = PerformanceCompletionForm::where('account_id', Auth::user()->id)->first();
        $c_status->financial = 1;
        $c_status->save();

        $user = User::find(Auth::user()->id);
        $user->status = "WAIT_APPRAISER";
        $user->save();
        
        return "updetails submitted";

    }

    public function upload_proof(Request $request){

        
      
        $val = Validator::make($request->all(), [
            'proof' => ['file', 'max:2000'],
        ]);

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
        else{
            $file = $request->file('proof');
            $acceptedExtensions = ['jpeg', 'png', 'gif', 'jpg', 'doc', 'docx', 'pdf'];
            $extension = $file->getClientOriginalExtension();
            $extension = strtolower($extension);
          
           
            $fileName = Auth::user()->staff_id."_".time().".".$extension;

            // return $projectFile;

            if(!in_array($extension, $acceptedExtensions)){
                $errors = array();
                array_push($errors, "Accepted formats are 'jpeg', 'png', 'gif', 'docx', 'pdf'");
                return response()->json([
                    'errors' => $errors,
                    'validate' => true
                ], 200);
            }

            //Move Uploaded File
            $destinationPath = './proof';
            $file->move($destinationPath,$fileName);

            $proofExist = Proof::where("staff_id", Auth::user()->staff_id)->first();

            if($proofExist == null){
                $proof = new Proof();
                $proof->account_id = Auth::user()->id;
                $proof->staff_id = Auth::user()->staff_id;
                $proof->path = $fileName;
                $proof->save();
            }
            else{
                $proofExist->path = $fileName;
                $proofExist->save();
            }
                       
            return "file uploaded";
        }
         
    }


}
