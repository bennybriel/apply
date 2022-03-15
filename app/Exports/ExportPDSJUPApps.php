<?php
namespace App\Exports;
use App\UGPreAdmissionReg;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPDSJUPApps implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $ses;

   
    public function headings(): array
    {
        return [
            'ID',
            'Formnumber',
            'Surname',
            'Firstname',
            'Othername',
            'Email',
            'Phone',
            'Programme 1',
            'Programme 2',
            'Session',
            'DOB',
            'Gender',
            'MaritalStatus',
            'State',
            'Town',
            'Address',
            'Religion',
            'AddmissionType'

        ];
    }
    public function query()
    {
        //return UGPreAdmissionReg::query();
        /*you can use condition in query to get required result*/
        /* return UGPreAdmissionReg::query()->select('formnumber','us.apptype','us.matricno','us.surname','us.firstname','us.othername','us.email','phone')
                                        ->join('users as us', 'us.matricno', '=', 'u_g_pre_admission_regs.matricno')
                                         ->orwhere('apptype', 'PDS')
                                         ->orwhere('apptype', 'JUP')
                                         ->orderby('us.formnumber','asc'); */
     return UGPreAdmissionReg::query()->select('us.id','us.formnumber',
                                         'us.surname',
                                         'us.firstname',
                                         'us.othername',
                                         'us.email',
                                         'phone',
                                         'category1',
                                         'category2',
                                         'session',
                                         'dob',
                                         'gender',
                                         'maritalstatus',
                                         'state',
                                         'town',
                                         'address',
                                         'religion',
                                         'admissiontype'
                                         )
                                  ->join('users as us', 'us.matricno', '=', 'u_g_pre_admission_regs.matricno')
                                  ->orwhere('apptype', 'PDS')
                                  ->orwhere('apptype', 'JUP')
                                  ->orderby('us.formnumber','asc');


    }
    public function map($apl): array
    {
        return [
            $apl->formnumber,
            $apl->apptype,
            $apl->matricno,
            $apl->surname,
            $apl->firstname,
            $apl->othername,
            $apl->email,
            $apl->phone
          
         
        ];
    }

}