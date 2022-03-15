<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Auth::routes();

//User Login
Route::get('/Authuser',   [App\Http\Controllers\SignInController::class, 'Authuser'])->name('user_auth');
Route::post('/AuthIn', [App\Http\Controllers\SignInController::class, 'AuthIn'])->name('AuthIn');
Route::get('/Mys',   [App\Http\Controllers\SignInController::class, 'Mys'])->name('mylogin');
Route::post('/My', [App\Http\Controllers\SignInController::class, 'My'])->name('My');
Route::get('/logons', [App\Http\Controllers\SignInController::class, 'logons'])->name('logons');

Route::get('/Authuser',   [App\Http\Controllers\SignInController::class, 'Authuser'])->name('user_auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/index', [App\Http\Controllers\SignInController::class, 'index'])->name('index');
//Reset Password
Route::get('/ChangeUserPassword', [App\Http\Controllers\SignInController::class, 'ChangeUserPassword'])->name('changeMyPassword');
Route::post('/ResetPassword/{sta}/{}', [App\Http\Controllers\SignInController::class, 'ResetPassword'])->name('ResetPassword');
//Change Password On First Login with Default Password
Route::get('/changePassword/{guid}', [App\Http\Controllers\SignInController::class, 'changePassword'])->name('changePassword');
Route::post('/UpdatePassword', [App\Http\Controllers\SignInController::class, 'UpdatePassword'])->name('UpdatePassword');
#Change Password After Login
Route::get('/PasswordChange', [App\Http\Controllers\SignInController::class, 'PasswordChange'])->name('changeMyPassword');
Route::post('/UpdateStudentPassword', [App\Http\Controllers\SignInController::class, 'UpdateStudentPassword'])->name('UpdateStudentPassword');
//Registration Controller
Route::get('/logon', [App\Http\Controllers\RegistrationController::class, 'logon'])->name('logon');
Route::get('/Reg', [App\Http\Controllers\RegistrationController::class, 'Reg'])->name('reg');
Route::post('/SubmitRegistration', [App\Http\Controllers\RegistrationController::class, 'SubmitRegistration'])->name('SubmitRegistration');
Route::get('/SignupResponse', [App\Http\Controllers\RegistrationController::class, 'signupResponse'])->name('signupResponse');
Route::get('/ActivatedAccountResponse', [App\Http\Controllers\RegistrationController::class, 'ActivatedAccountResponse'])->name('accountActivated');
Route::get('/FinishingUp/{id}', [App\Http\Controllers\RegistrationController::class, 'FinishingUp'])->name('FinishingUp');
//UserDashboard
Route::get('/UserDashboard', [App\Http\Controllers\UserWelcomeController::class, 'UserDashboard'])->name('userHome');
//UG Biodata
Route::get('/StudentInfo', [App\Http\Controllers\RegistrationController::class, 'StudentInfo'])->name('ugbiodata');
Route::post('/StudentData', [App\Http\Controllers\RegistrationController::class, 'StudentData'])->name('StudentData');
//UG Qualification
Route::get('/PreQual', [App\Http\Controllers\RegistrationController::class, 'PreQual'])->name('ugpreQ');
Route::post('/PreQdata', [App\Http\Controllers\RegistrationController::class, 'PreQdata'])->name('PreQdata');
//Remove Prequalification Record
Route::get('/DeletePreQ/{id}', [App\Http\Controllers\RegistrationController::class, 'DeletePreQ'])->name('DeletePreQ');
//Qualification
Route::get('/Qual', [App\Http\Controllers\RegistrationController::class, 'Qual'])->name('ugQualification');
Route::post('/QuaData', [App\Http\Controllers\RegistrationController::class, 'QuaData'])->name('QuaData');
//Remove Qualification Record
Route::get('/DeleteQual/{id}', [App\Http\Controllers\RegistrationController::class, 'DeleteQual'])->name('DeleteQual');
#Confirm Screening
Route::post('/ConfirmScreening', [App\Http\Controllers\RegistrationController::class, 'ConfirmScreening'])->name('ConfirmScreening');

//UG Qualification
#Print Screening Confirmation by Candidate
Route::get('/PrintScreening', [App\Http\Controllers\PrintReportController::class, 'PrintScreening'])->name('screeningconf');
#Uploading CSV files
//Print Course Form
Route::get('/PrintFormReg', [App\Http\Controllers\PrintReportController::class, 'PrintFormReg'])->name('ugprintCourse');
Route::get('/PrintForm',   [App\Http\Controllers\PrintReportController::class, 'PrintForm'])->name('PrintForm');
Route::get('/generatePDF', [App\Http\Controllers\PrintReportController::class, 'generatePDF'])->name('generatePDF');

////ADMISSION
Route::get('/PreAdmSignup', [App\Http\Controllers\AdmissionsController::class, 'PreAdmSignup'])->name('preadmissionsignup');
Route::post('/AdmSignup', [App\Http\Controllers\AdmissionsController::class, 'AdmSignup'])->name('AdmSignup');

Route::get('/Admissions', [App\Http\Controllers\AdmissionsController::class, 'Admissions'])->name('ugapply');
Route::post('/MyAdmissions', [App\Http\Controllers\AdmissionsController::class, 'MyAdmissions'])->name('MyAdmissions');
//Create users
Route::get('/CreateUser', [App\Http\Controllers\RolesController::class, 'CreateUser'])->name('createusers');
Route::post('/AddUsers', [App\Http\Controllers\RolesController::class, 'AddUsers'])->name('AddUsers');
//Delete User Role
Route::get('/DeleteRoleBySection/{id}/{rol}', [App\Http\Controllers\RolesController::class, 'DeleteRoleBySection'])->name('DeleteRoleBySection');
Route::get('/DeleteRoleByAdmin/{id}', [App\Http\Controllers\RolesController::class, 'DeleteRoleByAdmin'])->name('DeleteRoleByAdmin');
//Suspend User Role
Route::get('/SuspendRoleByAdmin/{id}/{sta}', [App\Http\Controllers\RolesController::class, 'SuspendRoleByAdmin'])->name('SuspendRoleByAdmin');
///Load Department
//Route::get('/GetDepartment/{dep}', 'SchoolDetailsController@getClassName');
Route::get('/GetDepartment/{dep}', [App\Http\Controllers\RegistrationController::class, 'GetDepartment'])->name('GetDepartment');
Route::get('/GetProgramme/{prog}', [App\Http\Controllers\RegistrationController::class, 'GetProgramme'])->name('GetProgramme');
//======================ADMINISTRATOR=========================================

Route::get('/StudentProfile', [App\Http\Controllers\RegistrationController::class, 'StudentProfile'])->name('myprofile');
////Batching


#Student Payment History
Route::get('/PaymentHistory', [App\Http\Controllers\PrintReportController::class, 'PaymentHistory'])->name('stdpaymentHistory');
Route::get('/ReceiptSlip/{tid}', [App\Http\Controllers\PrintReportController::class, 'ReceiptSlip'])->name('ReceiptSlip');


Route::get('/PrintProfile',[App\Http\Controllers\PrintReportController::class, 'PrintProfile'])->name('printProfile');
#Create Session

Route::get('/SetSession', [App\Http\Controllers\AdministratorController::class, 'SetSession'])->name('createSession');
Route::post('/CreateSession', [App\Http\Controllers\AdministratorController::class, 'CreateSession'])->name('CreateSession');

Route::get('/EnableSession/{id}/{sta}', [App\Http\Controllers\AdministratorController::class, 'EnableSession'])->name('EnableSession');
#Curriculum
Route::get('/SetCurriculum', [App\Http\Controllers\UploaderController::class, 'SetCurriculum'])->name('uploadCurriculum');
Route::post('/CreateCurriculum', [App\Http\Controllers\UploaderController::class, 'CreateCurriculum'])->name('CreateCurriculum');

#Forget Password
Route::get('/ForgotPassword', [App\Http\Controllers\SignInController::class, 'ForgotPassword'])->name('forgotPassword');
Route::post('/ResetForgotPassword', [App\Http\Controllers\SignInController::class, 'ResetForgotPassword'])->name('ResetForgotPassword');
Route::get('/TestPay', [App\Http\Controllers\SignInController::class, 'TestPay'])->name('TestPay');
#Confirm Payment
Route::get('/confirmPay', [App\Http\Controllers\MyPaymentsController::class, 'confirmPay'])->name('confirmPay');
Route::get('/ConfirmPay', [App\Http\Controllers\MyPaymentsController::class, 'ConfirmPay'])->name('confirmPay');

Route::post('/MakePayment', [App\Http\Controllers\MyPaymentsController::class, 'MakePayment'])->name('MakePayment');
Route::get('/QueryTransaction/{id}', [App\Http\Controllers\MyPaymentsController::class, 'QueryTransaction'])->name('QueryTransaction');

Route::get('/PaymentTracker', [App\Http\Controllers\MyPaymentsController::class, 'PaymentTracker'])->name('payhistory');
#Candidate Information
Route::get('/GetCandidateInfo', [App\Http\Controllers\AdministratorController::class, 'GetCandidateInfo'])->name('viewCandidateInfo');
Route::get('/Details/{mat}', [App\Http\Controllers\AdministratorController::class, 'Details'])->name('Details');
Route::get('/CandidateProfile', [App\Http\Controllers\AdministratorController::class, 'CandidateProfile'])->name('candidateProfile');
Route::get('/GetCandidateData', [App\Http\Controllers\PrintReportController::class, 'GetCandidateData'])->name('getCandidateData');
Route::get('/ExportApplication/{ses}/{appt}', [App\Http\Controllers\PrintReportController::class, 'ExportApplication'])->name('ExportApplication');
#Upload PDS Results
Route::get('/UploadPDScore', [App\Http\Controllers\UploaderController::class, 'UploadPDScore'])->name('uploadpdsResult');
Route::post('/UploadPDSResult', [App\Http\Controllers\UploaderController::class, 'UploadPDSResult'])->name('UploadPDSResult');
#Set Cutoff Mark
Route::get('/SetCutOff', [App\Http\Controllers\AdministratorController::class, 'SetCutOff'])->name('setCutoff');
Route::post('/CreateCutoff', [App\Http\Controllers\AdministratorController::class, 'CreateCutoff'])->name('CreateCutoff');
Route::post('/UpdateCutoff/{id}', [App\Http\Controllers\AdministratorController::class, 'UpdateCutoff'])->name('UpdateCutoff');
#Admission Letter
Route::get('/GetAdmissionLetter', [App\Http\Controllers\PrintReportController::class, 'GetAdmissionLetter'])->name('admissionLetter');
#Pay Now
Route::get('/PayNow/{id}/{prod}', [App\Http\Controllers\MyPaymentsController::class, 'PayNow'])->name('PayNow');
#Activate App
Route::get('/OpenApp', [App\Http\Controllers\AdministratorController::class, 'OpenApp'])->name('appactivation');
Route::post('/ActivateApp', [App\Http\Controllers\AdministratorController::class, 'ActivateApp'])->name('ActivateApp');
#Deleye App Activation
Route::get('/RemoveAppActivation/{id}', [App\Http\Controllers\AdministratorController::class, 'RemoveAppActivation'])->name('RemoveAppActivation');
#Update App Activation
Route::post('/UpdateAppActivation/{id}', [App\Http\Controllers\AdministratorController::class, 'UpdateAppActivation'])->name('UpdateAppActivation');
Route::get('/RegConfirmation', [App\Http\Controllers\ReferenceEmailController::class, 'RegConfirmation'])->name('registrationConfrimationPage');
#Validate UTME Number
Route::get('/ValidateUTME', [App\Http\Controllers\RegistrationController::class, 'ValidateUTME'])->name('validateUTME');
Route::post('/ValidateUTMES', [App\Http\Controllers\RegistrationController::class, 'ValidateUTMES'])->name('ValidateUTMES');
#UTME Data Page
Route::get('/UTMEData', [App\Http\Controllers\RegistrationController::class, 'UTMEData'])->name('utmeDataPage');
Route::post('/UTMEDatas', [App\Http\Controllers\RegistrationController::class, 'UTMEDatas'])->name('UTMEDatas');
#DE Data Page
Route::get('/DEData', [App\Http\Controllers\RegistrationController::class, 'DEData'])->name('directEntryDataPage');
Route::post('/DEDatas', [App\Http\Controllers\RegistrationController::class, 'DEDatas'])->name('DEDatas');
#DE Data Page
Route::get('/ExamSet', [App\Http\Controllers\AdministratorController::class, 'ExamSet'])->name('examSetup');
Route::post('/ExamSets', [App\Http\Controllers\AdministratorController::class, 'ExamSets'])->name('ExamSets');
#Create Hall
Route::get('/AddHall', [App\Http\Controllers\AdministratorController::class, 'AddHall'])->name('createHall');
Route::post('/CreateHalls', [App\Http\Controllers\AdministratorController::class, 'CreateHalls'])->name('CreateHalls');
Route::get('/DeleteHallByID/{id}', [App\Http\Controllers\AdministratorController::class, 'DeleteHallByID'])->name('DeleteHallByID');
Route::get('/SuspendHalls/{id}/{sta}', [App\Http\Controllers\AdministratorController::class, 'SuspendHalls'])->name('SuspendHalls');

#Get Screen Score
Route::get('/GetScreenScore', [App\Http\Controllers\PrintReportController::class, 'GetScreenScore'])->name('GetScreenScore');
Route::get('/UTMEPrintScreening', [App\Http\Controllers\PrintReportController::class, 'UTMEPrintScreening'])->name('UTMEPrintScreening');

Route::post('/CheckUTME', [App\Http\Controllers\RegistrationController::class, 'CheckUTME'])->name('CheckUTME');
Route::post('/CheckDE',       [App\Http\Controllers\RegistrationController::class, 'CheckDE'])->name('CheckDE');

#UTME Counter
Route::get('/UTMECounter', [App\Http\Controllers\AdministratorController::class, 'UTMECounter'])->name('UTMECounter');
Route::get('/UTMERegistrations', [App\Http\Controllers\AdministratorController::class, 'UTMERegistrations'])->name('UTMERegistrations');
Route::get('/ExportPDSJUPApplication', [App\Http\Controllers\AdministratorController::class, 'ExportPDSJUPApplication'])->name('ExportPDSJUPApplication');
Route::get('/ExportRequestLogs', [App\Http\Controllers\AdministratorController::class, 'ExportRequestLogs'])->name('ExportRequestLogs');
Route::get('/ExportRequestLogs', [App\Http\Controllers\AdministratorController::class, 'ExportRequestLogs'])->name('ExportRequestLogs');
#Export POST UTME
Route::get('/ExportPOSTApplications', [App\Http\Controllers\PrintReportController::class, 'ExportPOSTApplications'])->name('ExportPOSTApplications');
#State Identity
Route::get('/GetStateIdentity', [App\Http\Controllers\PrintReportController::class, 'GetStateIdentity'])->name('stateIdentity');
#LGA
Route::get('/GetLGA/{sta}', [App\Http\Controllers\PrintReportController::class, 'GetLGA'])->name('GetLGA');
Route::get('/AddLGA', [App\Http\Controllers\PrintReportController::class, 'AddLGA'])->name('addLGA');
Route::post('/AddLGAs',     [App\Http\Controllers\PrintReportController::class, 'AddLGAs'])->name('AddLGAs');
#GetPostUTMEList
Route::get('/GetPostUTMEList', [App\Http\Controllers\PrintReportController::class, 'GetPostUTMEList'])->name('getPostUTMEList');
#GetPostUTMEListByAppType
Route::get('/GetPostUTMEAllList', [App\Http\Controllers\PrintReportController::class, 'GetPostUTMEAllList'])->name('GetPostUTMEAllList');
Route::get('/GetPostUTMEListByAppType/{ses}/{appptype}', [App\Http\Controllers\PrintReportController::class, 'GetPostUTMEListByAppType'])->name('GetPostUTMEListByAppType');
#Payment Home
Route::get('/PayHome', [App\Http\Controllers\MyPaymentsController::class, 'PayHome'])->name('paymentHome');
Route::get('/PayingNow/{id}/{prod}', [App\Http\Controllers\MyPaymentsController::class, 'PayingNow'])->name('PayingNow');
#TuitionPay
Route::post('/TuitionPay', [App\Http\Controllers\MyPaymentsController::class, 'TuitionPay'])->name('TuitionPay');
Route::get('/QueryTransactioning/{id}', [App\Http\Controllers\MyPaymentsController::class, 'QueryTransactioning'])->name('QueryTransactioning');

#PGS Registration
Route::get('/PGDataForm', [App\Http\Controllers\RegistrationController::class, 'PGDataForm'])->name('pgdataPage');
Route::post('/PGDataForms', [App\Http\Controllers\RegistrationController::class, 'PGDataForms'])->name('PGDataForms');
#Education Info
Route::get('/PGEducationForm', [App\Http\Controllers\RegistrationController::class, 'PGEducationForm'])->name('pgeducationPage');
Route::post('/PGEducationForms', [App\Http\Controllers\RegistrationController::class, 'PGEducationForms'])->name('PGEducationForms');
#Delete Education Info
Route::get('/DeleteEducation/{id}', [App\Http\Controllers\RegistrationController::class, 'DeleteEducation'])->name('DeleteEducation');
#Education Qualification
Route::get('/PGQualification', [App\Http\Controllers\RegistrationController::class, 'PGQualification'])->name('pgqualificationPage');
Route::post('/PGQualifications', [App\Http\Controllers\RegistrationController::class, 'PGQualifications'])->name('PGQualifications');
#Delete Qualification Info
Route::get('/DeleteQualification/{id}', [App\Http\Controllers\RegistrationController::class, 'DeleteQualification'])->name('DeleteQualification');
#
Route::get('/PGAppointment', [App\Http\Controllers\RegistrationController::class, 'PGAppointment'])->name('pgappointmentPage');
Route::post('/PGAppointments', [App\Http\Controllers\RegistrationController::class, 'PGAppointments'])->name('PGAppointments');
#Delete Qualification Info
Route::get('/DeleteAppointment/{id}', [App\Http\Controllers\RegistrationController::class, 'DeleteAppointment'])->name('DeleteAppointment');

Route::get('/PGPublication', [App\Http\Controllers\RegistrationController::class, 'PGPublication'])->name('pgpublicationPage');
Route::post('/PGPublications', [App\Http\Controllers\RegistrationController::class, 'PGPublications'])->name('PGPublications');
#Delete Qualification Info
Route::get('/DeletePGPublication/{id}', [App\Http\Controllers\RegistrationController::class, 'DeletePGPublication'])->name('DeletePGPublication');
#
Route::get('/PGOtherInfo', [App\Http\Controllers\RegistrationController::class, 'PGOtherInfo'])->name('pgotherinfoPage');
Route::post('/PGOtherInfos', [App\Http\Controllers\RegistrationController::class, 'PGOtherInfos'])->name('PGOtherInfos');
#Delete Qualification Info
Route::get('/DeletePGOtherInfo/{id}', [App\Http\Controllers\RegistrationController::class, 'DeletePGOtherInfo'])->name('DeletePGOtherInfo');
#

Route::get('/PGReference/{id}', [App\Http\Controllers\ReferenceEmailController::class, 'PGReference'])->name('pgreferencePage');
Route::post('/PGReferences', [App\Http\Controllers\ReferenceEmailController::class, 'PGReferences'])->name('PGReferences');
#Delete Qualification Info
Route::get('/DeletePGReference/{id}', [App\Http\Controllers\RegistrationController::class, 'DeletePGReference'])->name('DeletePGReference');
#

Route::get('/PGSendReference', [App\Http\Controllers\RegistrationController::class, 'PGSendReference'])->name('pgsendreferencePage');
Route::post('/PGSendReferences', [App\Http\Controllers\RegistrationController::class, 'PGSendReferences'])
->name('PGSendReferences');
#Delete Qualification Info
Route::get('/DeleteReferenceInfo/{id}', [App\Http\Controllers\RegistrationController::class, 'DeleteReferenceInfo'])->name('DeleteReferenceInfo');
#
Route::get('/ReferenceResponse', [App\Http\Controllers\ReferenceEmailController::class, 'ReferenceResponse'])->name('pgreferenceResponse');
#ResendReference
Route::get('/ResendReference/{id}/{uid}', [App\Http\Controllers\RegistrationController::class, 'ResendReference'])->name('ResendReference');
Route::get('/ResendRefEmail', [App\Http\Controllers\RegistrationController::class, 'ResendRefEmail'])->name('pgResendReference');
Route::post('/ResendRefEmails', [App\Http\Controllers\RegistrationController::class, 'ResendRefEmails'])->name('ResendRefEmails');
Route::get('/DeleteResendReferenceInfo/{id}', [App\Http\Controllers\RegistrationController::class, 'DeleteResendReferenceInfo'])->name('DeleteResendReferenceInfo');
#Registration Confirmation
Route::get('/RegConfirmation', [App\Http\Controllers\RegistrationController::class, 'RegConfirmation'])->name('registrationConfrimationPage');
Route::get('/TestResult', [App\Http\Controllers\AdministratorController::class, 'TestResult'])->name('testResult');
#POST UTME SCORE
Route::get('/GetUTMEResult', [App\Http\Controllers\PrintReportController::class, 'GetUTMEResult'])->name('postUTMEResult');
#Receipt
Route::get('/Receipt/{id}', [App\Http\Controllers\PrintReportController::class, 'Receipt'])->name('getReceipt');
#PrintPGData
Route::get('/PrintPGData', [App\Http\Controllers\PrintReportController::class, 'PrintPGData'])->name('PrintPGData');
#post UTME Result Upload
Route::get('/uploadPostUTMEResult', [App\Http\Controllers\UploaderController::class, 'uploadPostUTMEResult'])->name('uploadPostUTMEResult');
Route::post('/UploadPOSTUTMEResults', [App\Http\Controllers\UploaderController::class, 'UploadPOSTUTMEResults'])->name('UploadPOSTUTMEResults');

Route::get('/PGProfileList', [App\Http\Controllers\PrintReportController::class, 'PGProfileList'])->name('pgProfileList');
#editData
Route::get('/EditProfile/{mat}', [App\Http\Controllers\PrintReportController::class, 'EditProfile'])->name('EditProfile');
#PDSJUBEP
Route::get('/PdsJupeb', [App\Http\Controllers\RegistrationController::class, 'PdsJupeb'])->name('pdsjupebDataPage');
Route::post('/PdsJupebs', [App\Http\Controllers\RegistrationController::class, 'PdsJupebs'])->name('PdsJupebs');
#ValidatePDSJUPEB
Route::post('/ValidatePDSJUPEB', [App\Http\Controllers\RegistrationController::class, 'ValidatePDSJUPEB'])->name('ValidatePDSJUPEB');
#Add Brochure
Route::get('/AddBrochure', [App\Http\Controllers\AdministratorController::class, 'AddBrochure'])->name('addBrochure');
Route::post('/AddBrochures', [App\Http\Controllers\AdministratorController::class, 'AddBrochures'])->name('AddBrochures');
#changeUTMEProgramme
Route::get('/ChangeUTMEProgramme', [App\Http\Controllers\UpdatesController::class, 'ChangeUTMEProgramme'])->name('changeUTMEProgramme');
#UpdateProgramme
Route::post('/UpdateProgramme', [App\Http\Controllers\UpdatesController::class, 'UpdateProgramme'])->name('UpdateProgramme');

#UploadUTMEInfos
Route::get('/UploadUTMEInfo', [App\Http\Controllers\UploaderController::class, 'UploadUTMEInfo'])->name('uploadUtmeInfo');
Route::post('/UploadUTMEInfos', [App\Http\Controllers\UploaderController::class, 'UploadUTMEInfos'])->name('UploadUTMEInfos');
#Change Passport
Route::get('/UploadPassport', [App\Http\Controllers\UploaderController::class, 'UploadPassport'])->name('uploadPassport');
Route::post('/UploadPassports', [App\Http\Controllers\UploaderController::class, 'UploadPassports'])->name('UploadPassports');
Route::get('/ChangePassport', [App\Http\Controllers\UploaderController::class, 'ChangePassport'])->name('changePassport');
Route::post('/ChangePassports', [App\Http\Controllers\UploaderController::class, 'ChangePassports'])->name('ChangePassports');
#changeRegisteredProgramme
Route::get('/ChangeRegistered', [App\Http\Controllers\UpdatesController::class, 'ChangeRegistered'])->name('changeRegisteredProgramme');
#UpdateRegisteredProgramme
Route::post('/UpdateRegisteredProgramme', [App\Http\Controllers\UpdatesController::class, 'UpdateRegisteredProgramme'])->name('UpdateRegisteredProgramme');
#uploadUTMESubject
Route::get('/UploadUTMESubject', [App\Http\Controllers\UploaderController::class, 'UploadUTMESubject'])->name('uploadUTMESubject');
Route::post('/UploadUTMESubjects', [App\Http\Controllers\UploaderController::class, 'UploadUTMESubjects'])->name('UploadUTMESubjects');
Route::get('/UpdateUserPassword/{id}', [App\Http\Controllers\UpdatesController::class, 'UpdateUserPassword'])->name('UpdateUserPassword');
#UploadPDScreeningScores
Route::get('/UploadPDScreeningScore', [App\Http\Controllers\UploaderController::class, 'UploadPDScreeningScore'])->name('uploadPDScreeningScore');
Route::post('/UploadPDScreeningScores', [App\Http\Controllers\UploaderController::class, 'UploadPDScreeningScores'])->name('UploadPDScreeningScores');
#UploadPDScreeningScores
Route::get('/UploadPDScreeningScore', [App\Http\Controllers\UploaderController::class, 'UploadPDScreeningScore'])->name('uploadPDScreeningScore');
Route::post('/UploadPDScreeningScores', [App\Http\Controllers\UploaderController::class, 'UploadPDScreeningScores'])->name('UploadPDScreeningScores');
#PostUtmeSummary
Route::get('/PostUtmeSummary', [App\Http\Controllers\PrintReportController::class, 'PostUtmeSummary'])->name('postUtmeSummary');
Route::get('/ExportPostUTMESummary/{ses}', [App\Http\Controllers\PrintReportController::class, 'ExportPostUTMESummary'])->name('ExportPostUTMESummary');
#jupebPaymentList
Route::get('/PaymentList', [App\Http\Controllers\MyPaymentsController::class, 'PaymentList'])->name('jupebPaymentList');
#downloadJupebPayment
Route::get('/GetJupebPayment', [App\Http\Controllers\PrintReportController::class, 'GetJupebPayment'])->name('downloadJupebPayment');
#ExportJupebPayment
Route::get('/DownloadJupebPayment/{ses}/{pat}', [App\Http\Controllers\PrintReportController::class, 'DownloadJupebPayment'])->name('DownloadJupebPayment');
#Admission Letter
Route::get('/GetPDSAdmissionLetter', [App\Http\Controllers\PrintReportController::class, 'GetPDSAdmissionLetter'])->name('admissionLetterPDS');
#paymentBalance
Route::get('/BalancePayment', [App\Http\Controllers\MyPaymentsController::class, 'BalancePayment'])->name('paymentBalance');
#PDS Result Slip
Route::get('/PDSResultSlip', [App\Http\Controllers\PrintReportController::class, 'PDSResultSlip'])->name('pdsResultSlip');
Route::get('/CheckPaymentStatus/{mat}', [App\Http\Controllers\AdministratorController::class, 'CheckPaymentStatus'])->name('CheckPaymentStatus');
Route::get('/ReSenderPG', [App\Http\Controllers\AdministratorController::class, 'ReSenderPG'])->name('ReSenderPG');
Route::post('/PGApplication', [App\Http\Controllers\RegistrationController::class, 'PGApplication'])->name('PGApplication');
#Admission List
Route::get('/UploadAdmission', [App\Http\Controllers\UploaderController::class, 'UploadAdmission'])->name('uploadAdmission');
Route::post('/UploadAdmissions', [App\Http\Controllers\UploaderController::class, 'UploadAdmissions'])->name('UploadAdmissions');
#Admission UGD Letter
Route::get('/GetUGSAdmissionLetter', [App\Http\Controllers\AdmissionsController::class, 'GetUGSAdmissionLetter'])->name('admissionLetterUGD');
#Undergraduate Pay
Route::get('/UGDPayNow/{id}/{prod}/{sid}', [App\Http\Controllers\MyPaymentsController::class, 'UGDPayNow'])->name('UGDPayNow');
#Support
Route::get('/Support', [App\Http\Controllers\SupportController::class, 'Support'])->name('supportPage');
Route::post('/Supports', [App\Http\Controllers\SupportController::class, 'Supports'])->name('Supports');
#Ticket Application
Route::get('/GetTickets/{pid}', [App\Http\Controllers\SupportController::class, 'GetTickets'])->name('GetTickets');
#Ticket Application
Route::get('/GetTickets/{pid}', [App\Http\Controllers\SupportController::class, 'GetTickets'])->name('GetTickets');
Route::get('/TicketList', [App\Http\Controllers\SupportController::class, 'TicketList'])->name('ticketList');
Route::post('/ReplyTicket', [App\Http\Controllers\SupportController::class, 'ReplyTicket'])->name('ReplyTicket');
Route::get('/GetTransaction', [App\Http\Controllers\MyPaymentsController::class, 'GetTransaction'])->name('getTransaction');
Route::post('/GetTransactions', [App\Http\Controllers\MyPaymentsController::class, 'GetTransactions'])->name('GetTransactions');
Route::get('/TransactionList', [App\Http\Controllers\MyPaymentsController::class, 'TransactionList'])->name('transactionList');
#QueryTransactAdmin
Route::get('/QueryTransactAdmin/{id}', [App\Http\Controllers\MyPaymentsController::class, 'QueryTransactAdmin'])->name('QueryTransactAdmin');
#Reply
Route::post('/ReplyTickets', [App\Http\Controllers\SupportController::class, 'ReplyTickets'])->name('ReplyTickets');
#GetPaymentRecord
Route::get('/GetPaymentRecord/{id}', [App\Http\Controllers\MyPaymentsController::class, 'GetPaymentRecord'])->name('GetPaymentRecord');
#GetPaymentRecord
Route::get('/GetPaymentRecord/{id}', [App\Http\Controllers\MyPaymentsController::class, 'GetPaymentRecord'])->name('GetPaymentRecord');
#DocumentScreenings
Route::get('/DocumentScreening', [App\Http\Controllers\AdmissionsController::class, 'DocumentScreening'])->name('documentScreening');
Route::post('/DocumentScreenings', [App\Http\Controllers\AdmissionsController::class, 'DocumentScreenings'])->name('DocumentScreenings');
#AdmissionProcess
Route::get('/AdmissionProcess/{utme}', [App\Http\Controllers\AdmissionsController::class, 'AdmissionProcess'])->name('AdmissionProcess');
#documentScreeningList
Route::get('/DocScreeningList', [App\Http\Controllers\AdmissionsController::class, 'DocScreeningList'])->name('documentScreeningList');
#paymentReport
Route::get('/PaymentReport', [App\Http\Controllers\PrintReportController::class, 'PaymentReport'])->name('paymentReport');
Route::post('/GeneratePayments', [App\Http\Controllers\PrintReportController::class, 'GeneratePayments'])->name('GeneratePayments');
#downloadPDSPayment
Route::get('/GetPDSPayment', [App\Http\Controllers\PrintReportController::class, 'GetPDSPayment'])->name('downloadPDSPayment');
#ExportPDSPayment
Route::get('/DownloadPDSPayment/{ses}/{pat}', [App\Http\Controllers\PrintReportController::class, 'DownloadPDSPayment'])->name('DownloadPDSPayment');
#PDSPaymentList
Route::get('/PDSPaymentList', [App\Http\Controllers\MyPaymentsController::class, 'PDSPaymentList'])->name('pdsPaymentList');
#ExportPDSPayment
Route::get('/DownloadPDSPayment/{ses}/{pat}', [App\Http\Controllers\PrintReportController::class, 'DownloadPDSPayment'])->name('DownloadPDSPayment');
Route::get('/PaymentBiodata', [App\Http\Controllers\MyPaymentsController::class, 'PaymentBiodata'])->name('paymentBiodata');
Route::post('/PaymentBiodatas', [App\Http\Controllers\MyPaymentsController::class, 'PaymentBiodatas'])->name('PaymentBiodatas');
#GetAdmissionInformation
Route::get('/GetAdmissionInformation/{utme}', [App\Http\Controllers\PrintReportController::class, 'GetAdmissionInformation'])->name('GetAdmissionInformation');
#BiodataBatchingClearance
Route::get('/BiodataBatchingClearance', [App\Http\Controllers\PrintReportController::class, 'BiodataBatchingClearance'])->name('BiodataBatchingClearance');
#LockAccess
Route::get('/LockAccess', [App\Http\Controllers\AdministratorController::class, 'LockAccess'])->name('lockAccess');
Route::post('/LockAccesss', [App\Http\Controllers\AdministratorController::class, 'LockAccesss'])->name('LockAccesss');
#ptRegisteredList
Route::get('/PTRegisteredList', [App\Http\Controllers\PrintReportController::class, 'PTRegisteredList'])->name('ptRegisteredList');
#DownloadPTList
Route::get('/DownloadPTList/{ses}', [App\Http\Controllers\PrintReportController::class, 'DownloadPTList'])->name('DownloadPTList');
#AssigMatricNo
Route::get('/AssignMatricNo', [App\Http\Controllers\AdministratorController::class, 'AssignMatricNo'])->name('AssignMatricNo');
#Changeprogramme
Route::get('/ChangeProgramme', [App\Http\Controllers\AdmissionsController::class, 'ChangeProgramme'])->name('changeProgramme');
Route::post('/ChangeProgrammes', [App\Http\Controllers\AdmissionsController::class, 'ChangeProgrammes'])->name('ChangeProgrammes');
#UpdateLGA
Route::get('/UpdateLGA', [App\Http\Controllers\UpdatesController::class, 'UpdateLGA'])->name('updateLGA');
Route::post('/UpdateLGAs', [App\Http\Controllers\UpdatesController::class, 'UpdateLGAs'])->name('UpdateLGAs');
Route::get('/LGAList', [App\Http\Controllers\UpdatesController::class, 'LGAList'])->name('lgaList');
#RejectedDocument
Route::get('/RejectedDocument/{utme}', [App\Http\Controllers\AdmissionsController::class, 'RejectedDocument'])->name('RejectedDocument');
#RemoveProgrammes
Route::get('/RemoveProgramme', [App\Http\Controllers\AdmissionsController::class, 'RemoveProgramme'])->name('removeChangedProgramme');
Route::post('/RemoveProgrammes', [App\Http\Controllers\AdmissionsController::class, 'RemoveProgrammes'])->name('RemoveProgrammes');
Route::get('/CancelMyTransaction/{tid}', [App\Http\Controllers\MyPaymentsController::class, 'CancelMyTransaction'])->name('CancelMyTransaction');
#RemoveProgrammes
Route::get('/CancelTransaction', [App\Http\Controllers\AdministratorController::class, 'CancelTransaction'])->name('cancelTransaction');
Route::post('/CancelTransactions', [App\Http\Controllers\AdministratorController::class, 'CancelTransactions'])->name('CancelTransactions');
Route::get('/CancelTransactionList', [App\Http\Controllers\AdministratorController::class, 'CancelTransactionList'])->name('cancelTransactionList');
#CanceledTransaction
Route::get('/CanceledTransaction/{tid}', [App\Http\Controllers\AdministratorController::class, 'CanceledTransaction'])->name('CanceledTransaction');
Route::get('/CancelMyTransaction/{tid}', [App\Http\Controllers\MyPaymentsController::class, 'CancelMyTransaction'])->name('CancelMyTransaction');
#GetRefereeRecord
Route::get('/GetRefereeRecord/{mat}', [App\Http\Controllers\PrintReportController::class, 'GetRefereeRecord'])->name('GetRefereeRecord');
#SendEmails
Route::get('/SendEmail', [App\Http\Controllers\AdministratorController::class, 'SendEmail'])->name('sendEmail');
Route::post('/SendEmails', [App\Http\Controllers\AdministratorController::class, 'SendEmails'])->name('SendEmails');
Route::get('/ActiveUsers', [App\Http\Controllers\AdministratorController::class, 'ActiveUsers'])->name('activeUsers');
#uploadBiodataUpdates
Route::get('/UploadBiodataUpdate', [App\Http\Controllers\UploaderController::class, 'UploadBiodataUpdate'])->name('uploadBiodataUpdates');
Route::post('/UploadBiodataUpdates', [App\Http\Controllers\UploaderController::class, 'UploadBiodataUpdates'])->name('UploadBiodataUpdates');
#AdmissionStatus
Route::get('/AdmissionsCheck', [App\Http\Controllers\AdmissionsController::class, 'AdmissionsCheck'])->name('admissionStatus');
Route::post('/AdmissionStatus', [App\Http\Controllers\AdmissionsController::class, 'AdmissionStatus'])->name('AdmissionStatus');
#displayAdmissionStatus
Route::get('/DisplayAdmissionStatus', [App\Http\Controllers\AdmissionsController::class, 'DisplayAdmissionStatus'])->name('displayAdmissionStatus');
#GenerateJUBEPPayments
Route::get('/JupebPaymentReport', [App\Http\Controllers\PrintReportController::class, 'JupebPaymentReport'])->name('jupebPaymentReport');
Route::post('/GenerateJUBEPPayments', [App\Http\Controllers\PrintReportController::class, 'GenerateJUBEPPayments'])->name('GenerateJUBEPPayments');
#pgApplicantList
Route::get('/PGApplicantList', [App\Http\Controllers\PrintReportController::class, 'PGApplicantList'])->name('pgApplicantList');
#DownloadPTList
Route::post('/DownloadPGList', [App\Http\Controllers\PrintReportController::class, 'DownloadPGList'])->name('DownloadPGList');
#UploadPGAdmission
Route::get('/UploadPGAdmission', [App\Http\Controllers\UploaderController::class, 'UploadPGAdmission'])->name('uploadPGAdmission');
Route::post('/UploadPGAdmissions', [App\Http\Controllers\UploaderController::class, 'UploadPGAdmissions'])->name('UploadPGAdmissions');
Route::get('/PGAdmission', [App\Http\Controllers\HomeController::class, 'PGAdmission'])->name('admissionPGHome');
Route::get('/PGAdmissionLetter', [App\Http\Controllers\PrintReportController::class, 'PGAdmissionLetter'])->name('admissionLetterPG');
Route::get('/PGAcceptanceForm', [App\Http\Controllers\PrintReportController::class, 'PGAcceptanceForm'])->name('pgAcceptanceForm');
#DownloadPostUTME
Route::get('/DownloadPostUTME', [App\Http\Controllers\PrintReportController::class, 'DownloadPostUTME'])->name('downloadPostUTME');
Route::post('/DownloadPostUTMES', [App\Http\Controllers\PrintReportController::class, 'DownloadPostUTMES'])->name('DownloadPostUTMES');
#StudentInformation
Route::get('/StudentInformation',   [App\Http\Controllers\UpdatesController::class, 'StudentInformation'])->name('studentInfo');
Route::post('/StudentInformations', [App\Http\Controllers\UpdatesController::class, 'StudentInformations'])->name('StudentInformations');

Route::get('/UpdateStudentInfo',   [App\Http\Controllers\UpdatesController::class, 'UpdateStudentInfo'])->name('updateStudentInfo');
Route::post('/UpdateStudentInfos',   [App\Http\Controllers\UpdatesController::class, 'UpdateStudentInfos'])->name('UpdateStudentInfos');
#UploadPTAdmissions
Route::get('/UploadPTAdmission', [App\Http\Controllers\UploaderController::class, 'UploadPTAdmission'])->name('uploadPTAdmission');
Route::post('/UploadPTAdmissions', [App\Http\Controllers\UploaderController::class, 'UploadPTAdmissions'])->name('UploadPTAdmissions');
Route::get('/PTAdmissionLetter', [App\Http\Controllers\PrintReportController::class, 'PTAdmissionLetter'])->name('admissionLetterPT');
Route::get('/PTAdmission', [App\Http\Controllers\HomeController::class, 'PTAdmission'])->name('admissionPTHome');
#Post Graduate Pay
Route::get('/PGPayNow/{id}/{prod}/{sid}/{prefix}', [App\Http\Controllers\MyPaymentsController::class, 'PGPayNow'])->name('PGPayNow');
#Part Time Pay
Route::get('/PTPayNow/{id}/{prod}/{sid}/{prefix}', [App\Http\Controllers\MyPaymentsController::class, 'PTPayNow'])->name('PTPayNow');
Route::get('/BursaryHome', [App\Http\Controllers\HomeController::class, 'BursaryHome'])->name('bursaryHome');
Route::get('/PDSAdmission', [App\Http\Controllers\HomeController::class, 'PDSAdmission'])->name('admissionHomePDS');
#PDS
Route::get('/PDSPayNow/{id}/{prod}/{sid}/{prefix}', [App\Http\Controllers\MyPaymentsController::class, 'PDSPayNow'])->name('PDSPayNow');
Route::get('/StudentDressCode', [App\Http\Controllers\PrintReportController::class, 'StudentDressCode'])->name('studentDressCode');
Route::get('/StudentOath', [App\Http\Controllers\PrintReportController::class, 'StudentOath'])->name('studentOath');
Route::get('/StateIdentityUGD', [App\Http\Controllers\PrintReportController::class, 'StateIdentityUGD'])->name('stateIdentityUGD');


















