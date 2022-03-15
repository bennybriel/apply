
<?php $__env->startSection('content'); ?>
<?php
    $psurname   = session('psurname');
    $pfirstname = session('pfirstname');
    $pemail   = session('pemail');
    $relation = session('relation');
    $pphone   = session('pphone');
    $paddress = session('paddress');

    $dob   = session('dob');
    $phone = session('phone');
    $address   = session('address');
    $gender = session('gender');
    $marital   = session('marital');
    $town = session('town');
    $state = session('state');

    $faculty   = session('faculty');
    $photo = session('photo');
    $religion   = session('religion');
    $admissiontype = session('admissiontype');
    $category1   = session('category1');
    $category2 = session('category2');
    $department = session('department');
    $matricno = Auth::user()->matricno;

    $sname   = session('sname');
    $saddress = session('saddress');
    $semail   = session('semail');
    $sphone   = session('sphone');

    $ap = DB::SELECT('CALL GetStudentAccountInfo(?)',array($matricno));
  
  $apt = Auth::user()->apptype;

?>
<script src="js/jquery-3.3.1.js"></script>
<div class="card o-hidden border-0 shadow-lg my-5">
 
            <div class="card-body p-0">
            <div class="col-xl-3 col-md-6 mb-4">
           
            </div>
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('PGDataForms')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">
  

                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Data Page Post Graduate</h1>
                                        <h6 style="color:red">Note: Your Passport Should Not Be More Than 20KB </h6>
                                    </div>
                                    <?php if(Session::has('error')): ?>
                                                 <div class="alert alert-danger">
                                                        <?php echo e(Session::get('error')); ?>

                                                        <?php
                                                            Session::forget('error');
                                                        ?>
                                                        </div>
                                                   <?php endif; ?>
                                                        <?php if(Session::has('success')): ?>
                                                     <div class="alert alert-success">
                                                        <?php echo e(Session::get('success')); ?>

                                                        <?php
                                                            Session::forget('success');
                                                        ?>

                                                        </div>

                                                <?php endif; ?>

                                      
                                        <div class="form-group row">

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <?php if($data): ?>
                                                    <input type="text" name="surname" value="<?php echo e($data[0]->surname); ?>" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" readonly>
                                                <?php else: ?>
                                                <input type="text" name="surname" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                                <?php endif; ?>

                                            </div>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <?php if($data): ?>
                                                    <input type="text" name="firstname" locked="false" value="<?php echo e($data[0]->firstname); ?>" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="First Name" readonly>
                                                <?php else: ?>
                                                    <input type="text" name="firstname" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="First Name" required>
                                                <?php endif; ?>
                                            </div>

                                           
                                        </div>
                                        <div class="form-group row">
                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                <?php if($data): ?>
                                                    <input type="text" name="othername" locked="false" value="<?php echo e($data[0]->othername); ?>" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="Other Name" readonly>
                                                <?php else: ?>
                                                    <input type="text" name="othername" value="<?php echo e($othername); ?>" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="Other Name">
                                                <?php endif; ?>
                                            </div>
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                <?php if($data): ?>
                                                    <input type="hidden" value="<?php echo e($data[0]->matricno); ?>" name="utme" class="form-control form-control"
                                                    id="exampleInputPassword" placeholder="UTME Reg/MatricNo" readonly>
                                                <?php else: ?>
                                                    <input type="hidden" name="utme" class="form-control form-control"
                                                    id="exampleInputPassword" placeholder="UTME Registration Number" required>
                                                <?php endif; ?>

                                            </div>

                                         </div>
                                            

                                        <div class="form-group">
                                            <?php if($data): ?>
                                                <input type="email" name="email" value="<?php echo e($data[0]->email); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" readonly>
                                            <?php else: ?>
                                                <input type="email" name="email" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            <?php endif; ?>
                                        </div>



                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
											<?php if($result): ?>
                                                 <input type="date" name="dob" value="<?php echo e($result[0]->dob); ?>" class="form-control form-control"
                                                        id="exampleRepeatPassword" placeholder="Date of DOB">
									        <?php else: ?>
												        <input type="date" name="dob" value="<?php echo e($dob); ?>" class="form-control form-control"
                                                        id="exampleRepeatPassword" placeholder="Date of DOB" required>
											
											<?php endif; ?>

                                            </div>
                                          
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              <?php if($result): ?>
                                                <input type="text" name="phone" value=<?php echo e($result[0]->phone); ?> class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
										     <?php else: ?>
												  <input type="text" value="<?php echo e($phone); ?>" name="phone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
											 <?php endif; ?>
                                            </div>
                                        </div>


                                        <div class="form-group">
										 <?php if($result): ?>
                                            <input type="text" name="address" value="<?php echo e($result[0]->address); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address">
										<?php else: ?>
											  <input type="text" name="address" value="<?php echo e($address); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address" required>
										<?php endif; ?>
                                        </div>
                                        <div class="form-group row">  
                                         <?php if($result): ?>
                                          <div class="col-sm-6 mb-3 mb-sm-0">
                                         
                                               <select name="gender" id="" class="form-control form-control" required>
                                                    <option value="<?php echo e($result[0]->gender); ?>"><?php echo e($result[0]->gender); ?></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                           </div>  
                                          <?php else: ?>
                                           <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="gender" id="" class="form-control form-control" required>
                                                   <?php if($gender): ?>
                                                       <option value="<?php echo e($gender); ?>"><?php echo e($gender); ?></option>
                                                       <option value="Male">Male</option>
                                                       <option value="Female">Female</option>
                                                   <?php else: ?>
                                                      <option value="">Gender</option>
                                                   <?php endif; ?>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select> 
                                           
                                            </div>
                                         <?php endif; ?>
                                          <?php if($result): ?>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <select name="maritalstatus" id="" class="  form-control form-control" required>
                                                        <option value="<?php echo e($result[0]->maritalstatus); ?>"><?php echo e($result[0]->maritalstatus); ?></option>  
                                                    
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Divorced">Divorced</option>
                                                 
                                                       
                                                   </select>
                                             </div> 
                                             <?php else: ?>
                                               <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <select name="maritalstatus" id="" class="  form-control form-control" required>
                                                       
                                                        <?php if($marital): ?>
                                                          <option value="<?php echo e($marital); ?>"><?php echo e($marital); ?></option>
                                                          <option value="Single">Single</option>
                                                          <option value="Married">Married</option>
                                                          <option value="Divorced">Divorced</option>
                                                        <?php else: ?>
                                                          <option value="">Marital Status</option>
                                                        <?php endif; ?>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Divorced">Divorced</option>
                                                   </select>
                                                </div>
                                           <?php endif; ?>
                                          </div> 
                                       
                                          <div class="form-group row">
                                             <?php if($result): ?>

                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                  <select name="state" id="state" class="form-control form-control" required>
                                                    <option value="<?php echo e($result[0]->state); ?>"><?php echo e($result[0]->state); ?></option>
                                                      
                                                       <?php $__currentLoopData = $rec; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <option value="<?php echo e($rec->name); ?>"><?php echo e($rec->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                  </select>
                                                </div>
                                             <?php else: ?>
                                                 <div class="col-sm-6 mb-3 mb-sm-0">
                                                  <select name="state" id="state" class="form-control form-control" required>
                                                   <?php if($state): ?>
                                                        <option value="<?php echo e($state); ?>"><?php echo e($state); ?></option>
                                                         <?php $__currentLoopData = $rec; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <option value="<?php echo e($rec->name); ?>"><?php echo e($rec->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                   <?php else: ?>

                                                     <option value="">State</option>
                                                       <?php $__currentLoopData = $rec; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <option value="<?php echo e($rec->name); ?>"><?php echo e($rec->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  <?php endif; ?>
                                                  </select>

                                                </div>
                                              <?php endif; ?> 
                                               <?php if($result): ?>  

                                                 <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" name="town" value="<?php echo e($result[0]->town); ?>" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Town" required>
                                                  </div>
                                               <?php else: ?>
                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" name="town" value="<?php echo e($town); ?>" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Town" required>
                                                  </div>
                                                <?php endif; ?>  


                                            </div>

                                            

                                    <div class="form-group row">
                                        
                                        <?php if($result): ?>  

                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                             <select name="department" id="department" class="form-control form-control" required>
                                               <option value="<?php echo e($result[0]->department); ?>"><?php echo e($result[0]->department); ?></option>
                                           
                                               <?php $__currentLoopData = $dep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($dep->departmentid); ?>"><?php echo e($dep->department); ?></option>
                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </select>
                                          </div>
                                          <?php else: ?>
                                           <div class="col-sm-12 mb-3 mb-sm-0">
                                             <select name="department" id="department" class="form-control form-control" required>
                                             <?php if($department): ?>
                                                   <option value="<?php echo e($department); ?>"><?php echo e($department); ?></option>
                                                   <?php $__currentLoopData = $dep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <option value="<?php echo e($dep->departmentid); ?>"><?php echo e($pro->department); ?></option>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                   <option value=""> Select Department</option>
                                         
                                                   <?php $__currentLoopData = $dep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                   <option value="<?php echo e($dep->departmentid); ?>"><?php echo e($dep->department); ?></option>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                             </select>
                                          </div>
                                         <?php endif; ?>  
                                     </div>






                                          <div class="form-group row">
                                        
                                             <?php if($result): ?>  

                                               <div class="col-sm-12 mb-3 mb-sm-0">
                                                  <select name="category1" id="category1" class="form-control form-control" required>
                                                    <option value="<?php echo e($result[0]->category1); ?>"><?php echo e($result[0]->category1); ?></option>
                                                    <option value=""> </option>
                                                    
                                                  </select>
                                               </div>
                                               <?php else: ?>
                                                <div class="col-sm-12 mb-3 mb-sm-0">
                                                  <select name="category1" id="category1" class="form-control form-control" required>
                                                  <?php if($category1): ?>
                                                        <option value="<?php echo e($category1); ?>"><?php echo e($category1); ?></option>
                                                        <option value=""></option>
                                                     <?php else: ?>
                                                        <option value=""> Programme</option>
                                              
                                                      
                                                     <?php endif; ?>
                                                  </select>
                                               </div>
                                              <?php endif; ?>  
                                          </div>
                                       
                                        
                                        <div class="form-group row">
                                         <?php if($result): ?>  
                                               <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="religion" id="religion" class="form-control form-control" required>
                                                   <option value="<?php echo e($result[0]->religion); ?>"><?php echo e($result[0]->religion); ?></option>
                                                   <option value="Christianity">Christianity</option>
                                                   <option value="Muslim">Muslim</option>
                                                   <option value="Traditional">Traditional</option>
                                                   <option value="Others">Others</option>
                                                   </select>
                                                </div>
                                         <?php else: ?>
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="religion" id="religion" class="form-control form-control" required>
                                                  <?php if($religion): ?>

                                                     <option value="<?php echo e($religion); ?>"><?php echo e($religion); ?></option>
                                                     <option value="Christianity">Christianity</option>
                                                     <option value="Muslim">Muslim</option>
                                                     <option value="Traditional">Traditional</option>
                                                     <option value="Others">Others</option>
                                                  <?php else: ?>                                                 
                                                   <option value="">Religion</option>
                                                   <option value="Christianity">Christianity</option>
                                                   <option value="Muslim">Muslim</option>
                                                   <option value="Traditional">Traditional</option>
                                                   <option value="Others">Others</option>
                                                   <?php endif; ?>
                                                   </select>
                                                </div>
                                         <?php endif; ?>     

                                           <?php if($result): ?>  

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="admissiontype" id="admissiontype" class="form-control form-control" required>
                                                  <option value="{ $result[0]->admissiontype }}"><?php echo e($result[0]->admissiontype); ?></option>
                                                  <option value="UTME">UTME</option>
                                                  <option value="PreDegree">Predegree</option>
                                                  <option value="Transfer">Transfer</option>
                                                   <option value="Direct Entry">Direct Entry</option>
                                               </select>
                                            </div>

                                           <?php else: ?>

                                           <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="admissiontype" id="admissiontype" class="form-control form-control" required>
                                                 <?php if($admissiontype): ?>
                                                      <option value="<?php echo e($admissiontype); ?>"><?php echo e($admissiontype); ?></option>
                                                      <option value="PGD">Post Graduate Diploma</option>
                                                      <option value="Masters">Masters</option>
                                                      <option value="PHD">PHD</option>
                                                    
                                                 <?php else: ?>
                                                      <option value="">Admmission Type</option>
                                                      <option value="PG">Post Graduate Diploma</option>
                                                      <option value="PG">Masters</option>
                                                      <option value="PG">PHD</option>
                                                <?php endif; ?>
                                               </select>
                                            </div>
                                            
                                           <?php endif; ?>
                                           
                                           
                                           
                                           
                                         </div>
                                              <div class="form-group row">
											     <div class="col-sm-6 mb-3 mb-sm-0">                                                 
                                                    <?php if($data): ?>
                                                      <select name="session" id="session" class="form-control form-control" readonly>
                                                       <option value="<?php echo e($data[0]->activesession); ?>"><?php echo e($data[0]->activesession); ?></option>
                                                    <?php else: ?>
                                                    <select name="session" id="session" class="form-control form-control" required>
                                                       <option value="">Session</option>
                                                        <?php $__currentLoopData = $ses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($ses->name); ?>"><?php echo e($ses->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?> 

                                              </select>
                                            </div>

                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                   <label>Passport</label>
                                                    <?php if($result): ?>

                                                      <input type="file" value="<?php echo e($result[0]->photo); ?>" name="photo" class="form-control form-control"
                                                       id="exampleRepeatPassword" placeholder="passport" required>
                                                    <?php else: ?>
                                                       <input type="file" name="photo" value="<?php echo e($photo); ?>" class="form-control form-control"
                                                       id="exampleRepeatPassword" placeholder="passport" required>
                                                    <?php endif; ?>


                                               </div>
                                             </div>
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Sponsor</h1>
                                    </div>
                                    <div class="form-group">
                                           <?php if($spor): ?>

                                             <input type="text" value="<?php echo e($spor[0]->sname); ?>" name="sname" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Full Name" required>
                                           <?php else: ?>
                                            <input type="text" name="sname" value="<?php echo e($sname); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Full Name" required>
                                            <?php endif; ?>
                                        </div>
                                       <div class="form-group">
                                           <?php if($spor): ?>

                                             <input type="text" value="<?php echo e($spor[0]->saddress); ?>" name="saddress" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Home Address" required>
                                           <?php else: ?>
                                            <input type="text" name="saddress" value="<?php echo e($saddress); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Home Address" required>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                           <?php if($spor): ?>

                                             <input type="email" value="<?php echo e($spor[0]->semail); ?>" name="semail" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Email Address" required>
                                           <?php else: ?>
                                            <input type="email" name="semail" value="<?php echo e($semail); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Email Address" required>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                             <?php if($spor): ?>
                                                <input type="text" value="<?php echo e($spor[0]->sphone); ?>" name="sphone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                              <?php else: ?>
                                                <input type="text" name="sphone" value="<?php echo e($sphone); ?>" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Sponsor Phone" required>
                                              <?php endif; ?>
                                        </div>

                                            <div class="text-center">
                                                <h1 class="h4  mb-4" style="color:#da251d">Parents/Guardian</h1>
                                            </div>

                                        <div class="form-group row">

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              <?php if($item): ?>
                                                 <input type="text" value="<?php echo e($item[0]->othername); ?>" name="pfirstname" class="form-control form-control" id="exampleFirstName"
                                                    placeholder="First Name" required>
                                              <?php else: ?>
                                                <input type="text" name="pfirstname" value="<?php echo e($pfirstname); ?>" class="form-control form-control" id="exampleFirstName"
                                                    placeholder="First Name" required>
                                               <?php endif; ?>       
                                            </div>


                                            <div class="col-sm-6">
                                                <?php if($item): ?>
                                                    <input type="text" value="<?php echo e($item[0]->surname); ?>" name="psurname" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                                <?php else: ?>
                                                     <input type="text" name="psurname" value="<?php echo e($psurname); ?>" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                           <?php if($item): ?>

                                             <input type="email" value="<?php echo e($item[0]->email); ?>" name="pemail" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                           <?php else: ?>
                                            <input type="email" name="pemail" value="<?php echo e($pemail); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                           <?php if($item): ?>
                                             <input type="text" value="<?php echo e($item[0]->address); ?>" name="paddress" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address" required>
                                           <?php else: ?>
                                            <input type="text" name="paddress" value="<?php echo e($paddress); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address" required>
                                           <?php endif; ?>
                                        </div>
                                        <div class="form-group row">

                                          <?php if($item): ?>
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="relation" id="" class="form-control form-control" required>
                                                    <option value="<?php echo e($item[0]->relation); ?>"><?php echo e($item[0]->relation); ?></option>
                                                        <?php $__currentLoopData = $rel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($rel->name); ?>"><?php echo e($rel->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                          <?php else: ?>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                  <?php if($item): ?>
                                                      <select name="relation" id="relation" class="form-control form-control" readonly>
                                                       <option value="<?php echo e($item[0]->relation); ?>"><?php echo e($item[0]->relation); ?></option>
                                                    <?php else: ?>
                                                    <select name="relation" id="relation" class="form-control form-control" required>
                                                       <option value="">Relationship</option>
                                                        <?php $__currentLoopData = $rel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($rel->name); ?>"><?php echo e($rel->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      </select>
                                                    <?php endif; ?> 
                                            </div>
                                            <?php endif; ?>

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              <?php if($item): ?>
                                                <input type="text" value="<?php echo e($item[0]->phone); ?>" name="pphone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                              <?php else: ?>
                                                <input type="text" name="pphone" value="<?php echo e($pphone); ?>" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                              <?php endif; ?>
                                            </div>

                                        </div>


                                        <?php if($result): ?>
                                             <a href="<?php echo e(route('ugpreQ')); ?>" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                                  Proceed To Education
                                            </a>
                                        <?php else: ?>
                                            <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit Info</button>

                                        <?php endif; ?>
                                        
                                        <hr>




                                </div>

                               

                            </div>
                        </div>
                    </div>
            </form>
        </div>

<?php
  function GetFaculty($fac)
  {
     $fa = DB::table('faculty')->where('facultyid', $fac)->first();
     return $fa->Faculty;
  }
?>
<script type='text/javascript'>
$(document).ready(function(){
  $('#faculty').change(function(){

     
     var id = $(this).val();
     //alert(id);
     // Empty the dropdown
     $('#department').find('option').not(':first').remove();


     $.ajax({
       url: 'GetDepartment/'+id,
       type: 'get',
       dataType: 'json',
       success: function(response){

         var len = 0;
         if(response['data'] != null)
         {
           len = response['data'].length;
         }

         if(len > 0){
           // Read data and create <option >
           for(var i=0; i<len; i++){

             var id = response['data'][i].departmentid;
             var name = response['data'][i].department;

             var option = "<option value='"+id+"'>"+name+"</option>"

             $("#department").append(option); 
             $("#programme").append(option); 
           }
         }

       }
    });
  });

});




$(document).ready(function(){
  $('#department').change(function(){

     
     var id = $(this).val();

     // Empty the dropdown
     $('#category1').find('option').not(':first').remove();
     //alert(id);

     $.ajax({
       url: 'GetProgramme/'+id,
       type: 'get',
       dataType: 'json',
       success: function(response){

         var len = 0;
         if(response['data'] != null)
         {
           len = response['data'].length;
         }
        
         if(len > 0)
         {
           // Read data and create <option >
           for(var i=0; i<len; i++){

             var id = response['data'][i].programmeid;
             var name = response['data'][i].programme;
             var deg = response['data'][i].degree;
             // alert(name);
             var option = "<option value='"+id+"'>"+name+ ' - '+ deg + "</option>"

             $("#category1").append(option); 
           }
         }

       }
    });
  });

});



</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WebApps\ApplyApp\resources\views/pgdataPage.blade.php ENDPATH**/ ?>