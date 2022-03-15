<?php
namespace App\Exports;
use App\RequestLogger;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportRequestLogger implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $ses;

    
    public function headings(): array
    {
        return [
            'ID','RequestOperation','CreatedAt'
        ];
    }
    public function query()
    {
        //return UGPreAdmissionReg::query();
        /*you can use condition in query to get required result*/
        return RequestLogger::query()->select('id','request','created_at');
    }                               
    public function map($apl): array
    {
        return [
            $apl->id,
            $apl->request,
            $apl->created_at
        ];
    }

}