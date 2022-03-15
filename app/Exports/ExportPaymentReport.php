<?php
namespace App\Exports;
use App\UGStudentAccount;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPaymentReport implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $ses;

    public function __construct(String $pty)
    {

         $this->pty = $pty;
       // $this->apptype = $apptype;
       
       // $this->to = $to;
       //dd($pty);
    }
    public function headings(): array
    {
        return [
           
            'UTME',
            'Name',
            'Programme',
            'PaymentType',
            'Session',
            

        ];
    }
    public function query()
    {
        ini_set('max_execution_time', 600);
        return UGStudentAccount::query()->select('al.utme',
                                                 'al.name',
                                                 'al.programme',
                                                 'paymenttype',
                                                 'al.session'
                                                )
                                         ->join('users as us', 'us.matricno', '=', 'u_g_student_accounts.matricno')
                                         ->join('admission_lists as al','al.utme', '=', 'us.utme')
                                         ->where('u_g_student_accounts.apptype',   'UGD')
                                         ->where('description', $this->pty)
                                         ->where('u_g_student_accounts.ispaid', '1');
                                        
    }
    public function map($apl): array
    {

        return [
        
            $apl->utme,
            $apl->name,
            $apl->programme,
            $apl->paymenttype,
            $apl->session    
        ];
    }

}