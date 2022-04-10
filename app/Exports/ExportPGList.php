<?php
namespace App\Exports;
use App\UGPreAdmissionReg;
use App\PGRegistered;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
class ExportPGList implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $prog;

    public function __construct(String $prog)
    {
        $this->prog = $prog;
    }
    public function headings(): array
    {
        return [
           
            'FormNumber',
            'Fullname',
            'Department',
            'Course',
            'Degree',
            ];
    }
    public function query()
    {
        //return UGPreAdmissionReg::query();
        /*you can use condition in query to get required result*/
         // $p = DB::table('pgprogramme')->where('programmeid', $this->prog)->first();
          //dd($this->prog);
          return  PGRegistered::query()->select('formnumber','name','programme','course','degree')
                                          ->where('departmentid',$this->prog)
                                          ->orderby('formnumber','asc')
                                          ->orderby('degree','asc');
    }
    public function map($apl): array
    {
      
        return [
        
            $apl->formnumber,
            $apl->name,
            $apl->programme,
            $apl->course,
            $apl->degree
          
          
         
        ];
    }

}