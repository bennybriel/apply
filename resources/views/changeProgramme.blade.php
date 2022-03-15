@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $prog = $ulist[0]->programme;
     $u = DB::SELECT('CALL   GetCurrentUserRole(?)', array($staffid));
     $sp  = DB::SELECT('CALL GetSpecialProgramme(?)',array($prog));  
     $ad = DB::SELECT('CALL  FetchDISTINCTUTMESubjectBrochure()');
//dd($ad);
     //dd($u);

?>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('ChangeProgrammes') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-8">


                        <div class="p-5">
                                <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Change Programme</h1>
                                    </div>
                                           
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                             <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">2021/2022 CHANGE OF PROGRAMME </h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Course</th>
                                                                        <th>Cutoff</th>
                                                                        <th>O'level Requirment</th>
                                                                        <th>UTME Requirment</th>
                                                                   
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                    <th>SN</th>
                                                                        <th>Course</th>
                                                                        <th>Cutoff</th>
                                                                        <th>O'level Requirment</th>
                                                                        <th>UTME Requirment</th>

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($dat as $dat)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $dat->name }} </td>
                                                                            <td>{{ $dat->cutoff }}  </td>  
                                                                            <td> {{ $dat->requirement }} </td>
                                                                            <td> {{ $dat->utmerequirement }} </td>
                                                                         </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                  </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Change Programme </h1>
                                              @if(Session::has('error'))
                                                    <div class="alert alert-danger">
                                                        {{ Session::get('error') }}
                                                        @php
                                                            Session::forget('error');
                                                        @endphp
                                                        </div>
                                                   @endif
                                                        @if(Session::has('success'))
                                                     <div class="alert alert-success">
                                                        {{ Session::get('success') }}
                                                        @php
                                                            Session::forget('success');
                                                        @endphp

                                                        </div>

                                                @endif

                                    </div>
                                    <div class="form-group row">
                                        
                                                   <div class="col-sm-12 mb-3 mb-sm-0">
                                                     
                                                         <select name="category1" id="category1" class="form-control form-control" required>
                                                       
                                                            <option value="">Select Programme</option>
                                                                @foreach($pro as $pro)
                                                                     <option value="{{ $pro->name }}">{{ $pro->name }}</option>
                                                                @endforeach
                                                      
                                                    </select>
                                                    
                                                  </div>

                                            
                                                  


                                          
                                            
                                   </div>
                                   <button class="btn px-4" id="" type="submit" style="background:#c0a062;color:white">Submit</button>

                                    <hr>

                                     
                                     </div>
                               

                                     @if($data)
                                              <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Change Programme</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME</th>
                                                                        <th>Name</th>
                                                                        <th>Old Programme</th>
                                                                        <th>New Programme</th>
                                                                   
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                       <th>SN</th>
                                                                        <th>UTME</th>
                                                                        <th>Name</th>
                                                                        <th>Old Programme</th>
                                                                        <th>New Programme</th>

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->utme }} </td>
                                                                            <td>{{ $data->surname }}  {{ $data->firstname }}</td>  
                                                                            <td> {{ $data->category1 }} </td>
                                                                            <td> {{ $data->changeprogramme }} </td>
                                                                         </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>

                                        @endif
                                                                    





                            </div>
                        </div>
                    </div>
            </form>                               
         </div>


<!-- View Category Price -->
<div class="modal fade" id="myDisplayInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-target=".bd-example-modal-lg">
   <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="edit-modal-label">View Category Type Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
              
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

          
        
            <table id="myTablePrice" class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size:12px">
                <thead>
                    <tr>
                       <th>SN</th>
                       <th>UTME </th>
                       <th>Name</th>
                       <th>Programme</th>
                   
                    </tr>
                </thead>
                <tbody>

                </tbody>
             </table>


        </div>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>


<script src="js/jquery-3.3.1.js"></script>
<script type='text/javascript'>
   
    $(document).ready(function()
    {
      $('#utme').change(function()
      {
         k=0;
            var id = $(this).val();
           $.get( "GetAdmissionInformation/" + id, function( data )
             {
                // console.log(id);
                   $('#myTable > tbody > tr').remove();
                    var rows = "";
                    //console.log(data['data'][0].name);
                    if(data['data'] != null)
                    {
                      len = data['data'].length;
                      document.getElementById("btnSubmit").style.display = "block";
                    }
                    else
                    {
                        alert("Record Not Found");
                    }
                     var k=0;
                    for (i = 0; i<len; i++) 
                    {
                        k++;
                     
                       var nam = data['data'][i].name;
                       var utme = data['data'][i].utme;
                       var prog = data['data'][i].programme;
                    }
                    if(nam)
                    {
                        alert(nam +"  "+utme+"  "+prog);
                    }
                   else
                   {
                    alert("Record Not Found");
                   }
                  
            });

      
    });

    });

</script>
@endsection
