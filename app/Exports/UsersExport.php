<?php

namespace App\Exports;


//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


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
use App\Ibc;



class UsersExport implements FromArray, WithHeadings
{    


    protected $ibc;

    public function __construct($ibc)
    {
        $this->ibc = $ibc;
    }


  public function array(): array{

     //$s = User::all();
    if($this->ibc == "All"){
        $s = Employee::select('account_id', 'staff_id', 'name', 'email', 'designation', 'haq', 'doe', 'ibc')->get();
    }
    else{
        $s = Employee::select('account_id', 'staff_id', 'name', 'email', 'designation', 'haq', 'doe', 'ibc')
        ->where('ibc', $this->ibc)->get();
    }
    
     foreach($s as $a){
        $d = Supervisor::where('staff_id', $a->staff_id)->first();
        if($d != null){
            $a->an = $d->appraiser_name;
            $a->ae = $d->appraiser_email;
            $a->rn = $d->reviewer_name;
            $a->re = $d->reviewer_email;
        }
        $d = OverallSummary::where('staff_id', $a->staff_id)->first();
        if($d != null){
            
            $d->a_performance != null ? $a->ap = $d->a_performance : $a->rp = "NIL";
            $d->a_attributes != null ? $a->aa = $d->a_attributes : $a->ra = "NIL";
            $d->a_training != null ? $a->at = $d->a_training : $a->rt = "NIL";
            $d->a_overall != null ? $a->ao = $d->a_overall : $a->ro = "NIL";

            $d->r_performance != null ? $a->rp = $d->r_performance : $a->rp = "NIL";
            $d->r_attributes != null ? $a->ra = $d->r_attributes : $a->ra = "NIL";
            $d->r_training != null ? $a->rt = $d->r_training : $a->rt = "NIL";
            $d->r_overall != null ? $a->ro = $d->r_overall : $a->ro = "NIL";

            $d->hhcm != null ? $a->hhcm = $d->hhcm : $a->hhcm = "NIL";
            $d->cpo != null ? $a->cpo = $d->cpo : $a->cpo = "NIL";
                     
        }
        $d = Recommendation::where('staff_id', $a->staff_id)->first(); 
        if($d != null){
            $d->job_rotation != null ? $a->jr = $d->job_rotation : $a->jr = "NIL";
            $d->job_rotation_recommendation != null ? $a->jrr = $d->job_rotation_recommendation : $a->jrr = "NIL";
            $d->job_enhancement != null ? $a->je = $d->job_enhancement : $a->je = "NIL";
            $d->job_enhancement_recommendation != null ? $a->jer = $d->job_enhancement_recommendation : $a->jer = "NIL";

            $d->promotion != null ? $a->p = $d->promotion : $a->p = "NIL";
            $d->promotion_justification != null ? $a->pj = $d->promotion_justification : $a->pj = "NIL";
            $d->training != null ? $a->t = $d->training : $a->t = "NIL";
            $d->training_recommendation != null ? $a->tr = $d->training_recommendation : $a->tr = "NIL";

            $d->others != null ? $a->others = $d->others : $a->others = "NIL"; 
        }
     }

        return [
           $s
        ];
    }

    public function headings(): array{
        return [
            'USER ACCOUNT ID',
            'STAFF ID',
            'NAME',
            'EMAIL',
            'DESIGNATION',
            'HIGHEST ACADEMIC QUALIFICATION',
            'DATE OF EMPLOYMENT',
            'IBC',
            'APPRAISER NAME',
            'APPRAISER EMAIL',
            'REVIEWER NAME',
            'REVIEWER EMAIL',
            'APPRAISER PERFORMANCE RATING',
            'APPRAISER BEHAVIOURAL RATING',
            'APPRAISER TRAINING RATING',
            'APPRAISER OVERALL RATING',
            'REVIEWER PERFORMANCE RATING',
            'REVIEWER BEHAVIOURAL RATING',
            'REVIEWER TRAINING RATING',
            'REVIEWER OVERALL RATING',
            'HHCM RATING',
            'CPO RATING',
            'JOB ROTATION',
            'JOB ROTATION RECOMMENDATION',
            'JOB ENHANCEMENT',
            'JOB ENHANCEMENT RECOMMENDATION',
            'PROMOTION',
            'PROMOTION JUSTIFICATION',
            'TRAINING',
            'TRAINING RECOMMENDATION',
            'OTHERS'

        ];
    }


    public function query(){
        return User::where('id', '>', 1);
    }
    /**
    * @var User $user
    */
    public function map($user): array
    {
        // This example will return 3 rows.
        // First row will have 2 column, the next 2 will have 1 column
        return [
            
            [
                $user->name,
                $user->email,
            ],
            [
                $user->created_at,
            ],
            [
                $user->password
            ]
            
            
        ];
    }
}
