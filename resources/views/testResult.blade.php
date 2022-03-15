@extends('layouts.appfront')
@section('content')
<?php
use Illuminate\Support\Collection;
  $mat ="10801411HC";
  $rcounter=0;
  $req = DB::SELECT('CALL GetRequiredSubjects(?)',array($mat));
  $rcounter = 5 - count($req);
  $opt = DB::SELECT('CALL GetOptionalSubjects(?,?)',array($mat,$rcounter));


?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
    table {
    border-collapse: collapse;
    }

    td, th {
    border: 1px solid #999;
    padding: 0.5rem;
    text-align: left;
    }

    {
  box-sizing: border-box;
}

/* Create two unequal columns that floats next to each other */
.column {
  float: left;
  padding: 10px;
  height: 30px; /* Should be removed. Only for demonstration */
}

.left {
  width: 25%;
}

.right {
  width: 75%;
}
.lefts {
  width: 50%;
}

.rights {
  width: 50%;
}


/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
.noBorder {
    border:none !important;
    font-weight: bold;
}
.noBorder1 {
    border:none !important;
}
</style>

<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
       <div align="center">
          <img src="../logRegTemp/img/brand/logo_admission.png" style="max-width:100%;height:auto;"/>
          <h4>Ladoke Akintola University of Technology</h4>
          </div>
    </div>
    <div class="col-md-4"></div>
</div>



                        @if($req)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">OLevel Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Score</th>
                                                                    

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                       
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Score</th>
                                                                       
                                                                    
                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    // dd($item[$counter][0]->grade);
                                                                    ?>
                                                                    @foreach($req as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                           
                                                                            <td>{{ $data->subject }}</td>
                                                                            <td>{{ $data->grade }}</td>
                                                                            <td>{{ $data->score }}</td>
                                                                         

                                                                        </tr>
                                                                    @endforeach
                                                                    @foreach($opt as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                           
                                                                            <td>{{ $data->subject }}</td>
                                                                            <td>{{ $data->grade }}</td>
                                                                            <td>{{ $data->score }}</td>
                                                                         

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             @endif
@endsection