<?php
namespace App\Exports;
use App\UGStudentAccount;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPaymentJUPEBReport implements FromQuery,WithHeadings
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
           
            'Formnumber',
            'Name',
            'Apptype',
            'Session',
            'Status',
            

        ];
    }
    public function query()
    {
        ini_set('max_execution_time', 600);
        return UGStudentAccount::query()->select('us.formnumber',
                                                 'us.name',
                                                 'us.apptype',
                                                 'us.activesession',
                                                 'response'
                                                )
                                         ->join('users as us', 'us.matricno', '=', 'u_g_student_accounts.matricno')
                                         ->where('paymenttype', $this->pty)
                                         ->where('us.apptype', 'JUP')
                                         ->where('istuition', '1')
                                         ->where('u_g_student_accounts.ispaid', '1');
                                        
    }
    public function map($apl): array
    {

        return [
        
            $apl->utme,
            $apl->name,
            $apl->apptype,
            $apl->session,
            $apl->response   
        ];
    }

}