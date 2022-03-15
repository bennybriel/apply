<?php
namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPOSTUTME implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $ses;

 

    public function headings(): array
    {
        return [
            'UTME',
            'Surname',
            'Firstname',
            'Othername',
            'Email',
            'ExamDate',
            'ExamTIme',
            'Hall',
            'Batch',
            'HallSeat',
           // 'Programme',
            'Session',
            'AppType',
           // 'AddmissionType'

        ];
    }
    public function query()
    {
        //return UGPreAdmissionReg::query();
        /*you can use condition in query to get required result*/
        return User::query()->select('users.utme',
                                                'users.surname',
                                                'users.firstname',
                                                'users.othername',
                                                'users.email',
                                                'examdate',
                                                'examtime',
                                                'ha.name as hallname',
                                                'batch',
                                                'hallnumber',
                                               // 'category1',
                                                'sc.session',
                                                'apptype',
                                               // 'admissiontype'
                                                )
                                         ->join('screeningclearance as sc', 'users.matricno', '=', 'sc.utme')
                                         ->join('hall as ha', 'sc.hallid', '=', 'ha.hallid')
                                         //->join('u_g_pre_admission_regs as rg', 'users.matricno', '=', 'rg.matricno')
                                         ->orderby('ha.hallid','asc')
                                         ->orderby('batch','asc');
                                        
    }
    public function map($apl): array
    {

        return [
            $apl->utme,
           strtoupper($apl->surname),
            $apl->firstname,
            $apl->othername,
            $apl->email,
            $apl->examdate,
            $apl->examtime,
            $apl->hallname,
            $apl->batch,
            $apl->hallnumber,
          //  $apl->category1,
            $apl->session,
            $apl->apptype,
          //  $apl->admissiontype
        ];
    }

}