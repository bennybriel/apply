<?php
namespace App\Exports;
use App\PostUTMESummary;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
class ExportPUTMESummary implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $ses;

    public function __construct(String $sess)
    {
        $this->sess = $sess;
    }
    public function headings(): array
    {
        return [
            
            'UTME',
            'Name',
            'UTMEScore',
            'PostUTMEScore',
            'OlevelScore',
            'TotalScore',
            'Programme',
            'Session',
            'State'     
        ];
    }
    public function query()
    {
                return PostUTMESummary::query()->select(
                'utme',
                'name',
                'utmescore',
                'postutmescore',
                'olevelscore',
                'total' ,
                'programme',
                'session',
                'state'

                )
        ->where('session', $this->sess)
        ->orderby('olevelscore','asc');
        
    }
    public function map($apl): array
    {
        return 
        [
            $apl->utme,
            $apl->name,
            $apl->utmescore,
            $apl->postutmescore,
            $apl->olevelscore,
            $apl->total,
            $apl->category1,
            $apl->session,
            $apl->state
        ];
    }

}