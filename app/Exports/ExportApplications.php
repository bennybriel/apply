<?php
namespace App\Exports;
use App\UGPreAdmissionReg;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportApplications implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $ses;

    public function __construct(String $sess,$apptype)
    {

        $this->sess = $sess;
        $this->apptype = $apptype;
       // $this->to = $to;

      // dd($apptype);
    }
    public function headings(): array
    {
        return [
            
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
            'Religion'
           

        ];
    }
    public function query()
    {
        //return UGPreAdmissionReg::query();
       // dd($this->sess);
                return UGPreAdmissionReg::query()->select('us.formnumber',
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
                'religion'
            
                )
        ->join('users as us', 'u_g_pre_admission_regs.matricno', '=', 'us.matricno')
        ->where('session', $this->sess)
        ->where('apptype', $this->apptype)
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
            $apl->category2,
            $apl->session,
            $apl->dob,
            $apl->gender,
            $apl->martitalstatus,
            $apl->state,
            $apl->town,
            $apl->address,
            $apl->religion
           
         
        ];
    }

}