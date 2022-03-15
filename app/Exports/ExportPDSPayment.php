<?php
namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
class ExportPDSPayment implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
 
    public function __construct(String $sess,$pat)
    {
        $this->sess = $sess;
        $this->pat = $pat;
    }
    public function headings(): array
    {
        return [
            
            'FormNumber',
            'Name',
            'Session',
            'Date',
            'Status'      
        ];
    }
    public function query()
    {
        if($this->pat=="Acc")
        {
                return User::query()->select(
                'formnumber',
                'name',
                'activesession',
                'created_at',
                'status'

                )
                ->where('activesession',    $this->sess)
                ->where('isacceptance', 1)
                ->orderby('formnumber','asc');
        }
        if($this->pat=="Med")
        {
                return User::query()->select(
                'formnumber',
                'name',
                'activesession',
                'created_at',
                'status'

                )
                ->where('activesession',    $this->sess)
                ->where('ismedical', 1)
                ->orderby('formnumber','asc');
        }
        if($this->pat=="Tut")
        {
                return User::query()->distinct()->select(
                'formnumber',
                'name',
                'activesession',
                'created_at',
                'paymenttype'

                )
                ->join('u_g_student_accounts as st', 'st.matricno', '=', 'users.matricno')
                ->where('activesession',    $this->sess)
                ->where('istuition', 1)
                ->orderby('formnumber','asc');
        }
      
        
    }
    public function map($apl): array
    {
        return 
        [
            $apl->formnumber,
            $apl->name,
            $apl->session,
            $apl->created_at,
            $apl->status
        ];
    }

}