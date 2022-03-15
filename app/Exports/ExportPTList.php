<?php
namespace App\Exports;
use App\UGPreAdmissionReg;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPTList implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $ses;
/*
    public function __construct(String $sess,$apptype)
    {

        $this->sess = $sess;
        $this->apptype = $apptype;
       
     
    }
    */
    public function headings(): array
    {
        return [
           
            'FormNumber',
            'Surname',
            'Firstname',
            'Othername',
            'Email',
            'Phone',
            'Programme ',
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
        return UGPreAdmissionReg::query()->select('us.formnumber',
                                                'us.surname',
                                                'us.firstname',
                                                'us.othername',
                                                'us.email',
                                                'phone',
                                                'category1',
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
                                         ->where('apptype',   'PT')
                                         ->where('ispaid',  '1')
                                         ->where('formnumber','<>' ,'')
                                         ->orderby('formnumber','asc');
    }
    public function map($apl): array
    {
      
        return [
        
            $apl->formnumber,
            $apl->surname,
            $apl->firstname,
            $apl->othername,
            $apl->email,
            $apl->phone,
            $apl->category1,
            $apl->session,
            $apl->dob,
            $apl->gender,
            $apl->martitalstatus,
            $apl->state,
            $apl->town,
            $apl->address,
            $apl->religion,
            $apl->admissiontype
          
         
        ];
    }

}