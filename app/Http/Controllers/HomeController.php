<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppraisalRequest;
use App\Mail\Reminder;
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
use App\Proof;
use App\Ibc;
use PDF;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){

        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];
        
        if($accessStatus == "staff"){
             
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

            if(Auth::user()->status == 'START_APPRAISAL'){
               
                $ibcs = Ibc::all();
                $name = explode(" ", trim(Auth::user()->name));
                $lastname = $name[0];
                $firstname = "";
                $staffId = Auth::user()->staff_id;
                if(count($name) > 1){
                    $firstname = $name[1];
                }

                
                $data = array(
                    'ibcs' => $ibcs,
                    'email' => Auth::user()->email,
                    'lastname' => $lastname,
                    'firstname' => $firstname,
                    'isAppraiser' => $isAppraiser,
                    'isReviewer' => $isReviewer,
                    'staffId' => $staffId,
                    'accessLevel' => $accessLevel
                );
                //return view('home', $data); 
                return redirect()->route('dashboard-index'); 
                //return redirect()->route('access-requests', ['request' => 'dl_enhance']);   
            }
            else{
                
                $c_status = PerformanceCompletionForm::where('account_id', Auth::user()->id)->first();
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
        }
        else{
            return redirect('admin');
        }
        

    }

    public function admin(){
        
        //return "yes";

        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];
       
        $ibc = null;
        $employees = Employee::paginate(20);
        $ibcs = Ibc::all();

         //return "yes";

       
        if(isset($_GET['q'])){
            $ibc = trim($_GET['q']);

            if($ibc == "All"){
                $employees = Employee::paginate(20);
            }
            else{
                $employees = Employee::where("ibc", $ibc)->paginate(20);
            }
        }

        if(isset($_GET['d'])){
            return PDF::loadView('download_report', compact('employees'))->setPaper('a4', 'landscape')->stream('phed_appraisal_report_2019.pdf');
        }
    
        foreach($employees as $employee){
            $user = User::find($employee->account_id);
            $rating = OverallSummary::where('staff_id', $employee->staff_id)->first();
            $proof = Proof::where('account_id', $employee->account_id)->first();

            
            if($user != null){
                $employee->status = $user->status;
            }
            else{
                $employee->status = null;
            }
                                    
            if($rating != null){
                $employee->appraiser_rating = $rating->a_overall;
                $employee->reviewer_rating = $rating->r_overall;
                $employee->hhcm_rating = $rating->hhcm;
                $employee->cpo_rating = $rating->cpo;    
            }
            else{
                $employee->appraiser_rating = null;
                $employee->reviewer_rating = null;
                $employee->hhcm_rating = null;
                $employee->cpo_rating = null;  
            }
          
            $proof != null ? $employee->proof = $proof->path :  $employee->proof = null;
          
        } 

        //return $employees;
         

       
        $data = array(
            'employees' => $employees,
            'ibcs' => $ibcs,
            'admin_name' => Auth::user()->name,
            'admin_access' => Auth::user()->access,
            'accessStatus' => $accessStatus,
            'accessLevel' => $accessLevel,
            'query' => $ibc
        );

        if(($accessStatus == "performance") || ($accessStatus == "hr")){
           return view('admin.hr')->with($data);
        }
        if($accessStatus == "hhcm"){
            return view('admin.hhcm')->with($data);
        }
        if($accessStatus == "cpo"){
            return view('admin.cpo')->with($data);
        }
        if($accessStatus == "it"){
            return redirect()->route('it-dashboard');
        }
        
    }


     /*
        Renders the  IT application dashboard
    */
    public function it_dashboard(){

        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];

        $data = array(
            "admin_name" => Auth::user()->name,
            "accessLevel" => $accessLevel
        );

        //return $data;
        return view('it.index')->with($data);
    }

    public function reminder($id){
        
        $user = User::find($id);
        $employee = Employee::where('account_id', $id)->first();
        $supervisor = Supervisor::where('account_id', $id)->first();
        $stat = $user->status;
        $email = $employee->email;

        if($stat == "WAIT_APPRAISER"){
            $email = $supervisor->appraiser_email;
        }
        if($stat == "WAIT_REVIEWER"){
            $email = $supervisor->reviewer_email;
        }


        $msg = new Reminder($id, $employee->staff_id, $stat);
        $msg->subject("REMINDER: 2019 PHED APPRAISAL");
        Mail::to($email)->send($msg);


        return back()->with('success', "reminder successfully sent");
    }

    public function normalize(Request $request){

        
        $rating = OverallSummary::where('staff_id', trim($request->staff_id))->first();
          
        if(trim($request->admin_access) == "hhcm"){
            $request->rating = $rating->r_overall + $request->rating; 
            $rating->hhcm = trim($request->rating) ;
        }
        else{
            if($request->normalize_criteria == 'reviewer'){
                $request->rating = intval($rating->r_overall) + $request->rating; 
            }
            else{
                $request->rating = intval($rating->hhcm) + $request->rating;
            }
           
            $rating->cpo = trim($request->rating);  
        }
        if($request->rating > 100){
            return back()->with('error', 'Rating is '.$request->rating.' .100 is the maximum rating that can be acquired.');
        }
        $rating->save();

        return back()->with('success', 'operation successful');

    }

    public function batch_normalize(Request $request){

        
        $ibc = trim($request->ibc);
        $ibc_employees = Employee::where("ibc", $ibc)->get();
        if($ibc_employees != null){
            foreach($ibc_employees as $e){
                $rating = OverallSummary::where('staff_id', $e->staff_id)->first();  

                if(trim($request->admin_access) == "hhcm"){
                    $rating->r_overall != null ? $result = $rating->r_overall + $request->rating : $result = null; 
                    $rating->hhcm = trim($result) ;
                    if($rating->hhcm > 100){
                        return back()->with('error', 'Rating is '.$rating->hhcm.' .100 is the maximum rating that can be acquired.');
                    }
                                
                    
                }
                else{
                    if($rating->r_overall != null && $rating->hhcm != null){
                        if($request->normalize_criteria == 'reviewer'){                                               
                            $result = intval($rating->r_overall) + $request->rating; 
                        }
                        else{
                            $result = intval($rating->hhcm) + $request->rating;
                        }
                        $rating->cpo = trim($result);                        
                    }
                    else{
                        $rating->cpo = null;
                    }

                    if($rating->cpo > 100){
                        return back()->with('error', 'Rating is '.$rating->cpo.' .100 is the maximum rating that can be acquired.');
                    }
                    
                }  

                $rating->save();
               
            }
            return back()->with('success', 'operation successful');

        }
        return back()->with('error', 'No employee currently availabe for this location('.$ibc.')');

       
    }

    public function sort_employees(Request $request){
        //return $request;
        $ibc = trim($request->ibc);
        return redirect('admin?q='.$ibc);
        
    }

   
    public function download_report(Request $request){
        //return $request;

        $ibc = trim($request->ibc);
        $type = trim($request->type);

        if($type == 'pdf'){
            return redirect('admin?q='.$ibc.'&d=true');
        }
        return redirect('excel?q='.$ibc);
        
    }

    public function excel(){

        if(isset($_GET['q'])){
            $ibc = trim($_GET['q']);
            return Excel::download(new UsersExport($ibc), 'phed_appraisal_2019_'.$ibc.'.xlsx');
        }
        return Excel::download(new UsersExport("All"), 'phed_appraisal_2019.xlsx');
       
    }


    public function role_appraiser(){

        //Auth::user()->email;
        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];
        $totalAppraisees = 0;
        $completed = 0;
        $uncompleted = 0;
        $percentage = 0;
        $success = 0;
        $completedArr = array();
        $uncompletedArr = array();
        $totalArr = array();
        $appraisees = array();
        $query = "";
        $ibc = "";

        
        if(isset($_GET['q'])){
            $query = $_GET['q'];
        }

        if(isset($_GET['ibc'])){
           $ibc = $_GET['ibc'];
        }



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

               
        $ibcs = Ibc::all();
        $staffs = Supervisor::Where('appraiser_email', Auth::user()->email)->get();


        //$totalAppraisees = count($staffs);

        if(count($staffs) < 1){
            return back()->with("error", "Access Denied! Appraiser privilege is not currently available for your account");
        }
        else{
            foreach($staffs as $staff){
                               
                if($staff->status != null){
                    $totalAppraisees++;
                    if($staff->status == 'WAIT_APPRAISER'){
                        $uncompleted += 1;
                        $employee = Employee::Where('staff_id', $staff->staff_id)->first();
                        if(isset($_GET['ibc'])){
                            $employee = Employee::Where('staff_id', $staff->staff_id)->where('ibc', $ibc)->first();
                        }

                        if($employee != null){
                            $employee->status = "UNCOMPLETED";
                            array_push($uncompletedArr, $employee);
                        }
                                        
                    }
                    else{
                        $completed += 1;                   
                        $employee = Employee::Where('staff_id', $staff->staff_id)->first();
                        if(isset($_GET['ibc'])){
                            $employee = Employee::Where('staff_id', $staff->staff_id)->where('ibc', $ibc)->first();
                        }
                        if($employee != null){
                                $employee->status = "COMPLETED";
                                array_push($completedArr, $employee);  
                        }                                      
                    }
                    
                    if($employee != null){
                        array_push($totalArr, $employee);
                    }
                }           
            }

            if($completed > 0){
               $success = round(($completed/$totalAppraisees) * 100);
            }
           
        }

        $appraisees = $uncompletedArr;
        if($query == "completed"){
            $appraisees = $completedArr;
        }
        if($query == "uncompleted"){
            $appraisees = $uncompletedArr;
        }
        if($query == "total"){
            $appraisees = $totalArr;
        }
        
        
        $data = array(
            'appraisees' => $appraisees,
            'total' => $totalAppraisees,
            'completed' => $completed,
            'uncompleted' => $uncompleted,
            'success' => $success,
            'ibcs' => $ibcs,
            'role' => "appraiser",
            'query' => $query,
            'ibc' => $ibc,
            'isAppraiser' => $isAppraiser,
            'isReviewer' => $isReviewer,
            'accessLevel' => $accessLevel
        );
        
        return view('staff.appraiser')->with($data);
    }

    public function role_reviewer(){

        //Auth::user()->email;
        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];
        $totalAppraisees = 0;
        $completed = 0;
        $uncompleted = 0;
        $percentage = 0;
        $success = 0;
        $completedArr = array();
        $uncompletedArr = array();
        $totalArr = array();
        $appraisees = array();
        $query = "";
        $ibc = "";

        
        if(isset($_GET['q'])){
            $query = $_GET['q'];
        }
         if(isset($_GET['ibc'])){
            $ibc = $_GET['ibc'];
        }


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



        $ibcs = Ibc::all();
        $staffs = Supervisor::Where('reviewer_email', Auth::user()->email)->get();
        
        //$totalAppraisees = count($staffs);

        if(count($staffs) < 1){
            return "not found";
            //return view('staff.appraiser')->with($data);
            return back()->with('error', "Access Denied! Reviewer privilege is not currently available for your account");
        }
        else{
            foreach($staffs as $staff){
                
               if($staff->status != null && $staff->status != "WAIT_APPRAISER"){
                   $totalAppraisees++;
                    if($staff->status == 'WAIT_REVIEWER'){
                        $uncompleted += 1;
                        $employee = Employee::Where('staff_id', $staff->staff_id)->first(); 
                        if(isset($_GET['ibc'])){
                            
                            $employee = Employee::Where('staff_id', $staff->staff_id)->where('ibc', $ibc)->first();
                        }
                        if($employee != null){
                            $employee->status = "UNCOMPLETED";
                            array_push($uncompletedArr, $employee);
                        }
                    }
                    else{
                        $completed += 1;                   
                        $employee = Employee::Where('staff_id', $staff->staff_id)->first();
                        if(isset($_GET['ibc'])){
                        
                            $employee = Employee::Where('staff_id', $staff->staff_id)->where('ibc', $ibc)->first();
                        }
                        if($employee != null){
                            $employee->status = "COMPLETED";
                            array_push($completedArr, $employee);
                        }
                                
                    }
                    
                    if($employee != null){
                            array_push($totalArr, $employee);
                    }
                }
                
             
            }

            //return $totalArr;

            if($completed > 0){
               $success = round(($completed/$totalAppraisees) * 100);
            }
           
        }

        $appraisees = $uncompletedArr;
        if($query == "completed"){
            $appraisees = $completedArr;
        }
        if($query == "uncompleted"){
            $appraisees = $uncompletedArr;
        }
        if($query == "total"){
            $appraisees = $totalArr;
        }
        
        $data = array(
            'appraisees' => $appraisees,
            'total' => $totalAppraisees,
            'completed' => $completed,
            'uncompleted' => $uncompleted,
            'success' => $success,
            'ibcs' => $ibcs,
            'role' => "reviewer",
            'query' => $query,
            'ibc' => $ibc,
            'isAppraiser' => $isAppraiser,
            'isReviewer' => true,
            'accessLevel' => $accessLevel
        );
        
        return view('staff.appraiser')->with($data);
    }

   
   

    
}
