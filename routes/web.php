<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\resetPassword;

use App\Http\Controllers\HomeController;

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
    return view('auth/login');
});

Route::get('/register', function () {
    return view('auth/register');
});

Route::get('/resetPassword', function () {
    return view('auth/passwords/email');
})->name('resetPassword');

Route::get('/recoveryPassword', function () {
    return view('auth/passwords/reset');
})->name('recoveryPassword');

Auth::routes();

Route::controller(HomeController::class)->group(function () {

    Route::get('/dashboard', 'index')->name('home');
    
    Route::get('/matchAndControl', 'matchAndControlFilter');

    //Route::get('/settings/{idUser}', 'settings');

    Route::get('/myProfile/{idUser}', 'myProfile');

    //Route::post('/settings/{idUser}', 'postSettings')->name('home.settings');

    Route::post('/myProfile/{idUser}', 'postMyProfile')->name('home.MyProfile');

    Route::get('/manageBillAndPay', 'matchAndControlFilter');

    Route::get('/generate1099', 'generate1099Filters');

    Route::post('/generate1099', 'dataConsultGenerate1099');
    
    Route::post('/matchAndControl', 'matchAndControlSearch'); 

    Route::post('/cobrarPatiente', 'cobrar');

    Route::post('/pagarWorker', 'pagar'); 

    Route::post('/revertirCobrarPatiente', 'revertirCobrar');

    Route::post('/revertirPagarWorker', 'revertirPagar');
    
    Route::post('/generateDocumentOfPai', 'generateDocumentOfPay');

    Route::post('/searchServicesWorker', 'searchServicesWorker');

    Route::post('/searchPatienteService', 'searchPatienteService');

    Route::post('/searchSubServicesPatiente', 'searchSubServicesPatiente');

    Route::post('/registerAttentions', 'registerAttentions');

    Route::post('/createMultiRegister', 'createMultiRegister');

});

Route::resource('notesSubServices', App\Http\Controllers\NotesSubServicesRegisterController::class);

Route::post('/notesSubServices', [App\Http\Controllers\NotesSubServicesRegisterController::class, 'search'])->name('notesSubServices.search');

Route::post('notesSubService/{idNota}/update', [App\Http\Controllers\NotesSubServicesRegisterController::class, 'update']);

Route::resource('agents', App\Http\Controllers\AgentController::class);

Route::get('/agents/pdf/{id}/{idPdf}', [App\Http\Controllers\AgentController::class, 'getPDF'])->name('agent.pdf');

Route::post('/agents/updateState/{id}', [App\Http\Controllers\AgentController::class, 'updateState'])->name('agents.updateState');

Route::resource('patientes', App\Http\Controllers\PatienteController::class);

Route::get('/patientes/pdf/{id}/{idPdf}', [App\Http\Controllers\PatienteController::class, 'getPDF'])->name('patientes.pdf');

Route::post('/patientes/updateState/{id}', [App\Http\Controllers\PatienteController::class, 'updateState'])->name('patientes.updateState');

Route::post('/patientes/assingWorker/{idPatiente}/{idWorker}', [App\Http\Controllers\PatienteController::class, 'assingWorker'])->name('patientes.assingWorker');

Route::resource('workers', App\Http\Controllers\WorkerController::class);

Route::get('/workers/pdf/{id}/{idPdf}', [App\Http\Controllers\WorkerController::class, 'getPDF'])->name('workers.pdf');

Route::post('/sendXml', [App\Http\Controllers\WorkerController::class, 'sendXml']);

Route::post('/workers/updateState/{id}', [App\Http\Controllers\WorkerController::class, 'updateState'])->name('workers.updateState');

Route::post('/emailReset', [App\Http\Controllers\WorkerController::class, 'sendEmailRecovery']);

Route::post('/recoveryPassword', [App\Http\Controllers\WorkerController::class, 'changePass']);

Route::get('/sendEmailRegister/emailRegisterWorker', [App\Http\Controllers\SendEmailRegisterController::class, 'emailRegisterWorker'])->name('sendEmailRegisterController.emailRegisterWorker');

Route::post('/sendEmailRegister/emailRegisterWorker', [App\Http\Controllers\SendEmailRegisterController::class, 'sendEmailRegisterWorker'])->name('sendEmailRegisterController.sendEmailRegisterWorker');

Route::resource('settings/roles', App\Http\Controllers\RoleController::class);

Route::resource('settings/status', App\Http\Controllers\StatuController::class);

Route::resource('contactEmergencies', App\Http\Controllers\ContactEmergencyController::class);

Route::resource('jobInformations', App\Http\Controllers\JobInformationController::class);

Route::resource('confirmationIndependents', App\Http\Controllers\ConfirmationIndependentController::class);

Route::resource('education', App\Http\Controllers\EducationController::class);

Route::resource('settings/maritalStatuses', App\Http\Controllers\MaritalStatusController::class);

Route::resource('settings/titleJobs', App\Http\Controllers\TitleJobsController::class);

Route::resource('referencesPersonales', App\Http\Controllers\ReferencesPersonalesController::class);

Route::resource('referencesJobs', App\Http\Controllers\ReferencesJobsController::class);

Route::resource('referencesPersonalesTwos', App\Http\Controllers\ReferencesPersonalesTwoController::class);

Route::resource('referencesJobsTwos', App\Http\Controllers\ReferencesJobsTwoController::class);

Route::resource('settings/typeDocs', App\Http\Controllers\TypeDocController::class);

Route::resource('settings/locations', App\Http\Controllers\LocationController::class);

Route::resource('settings/services', App\Http\Controllers\ServiceController::class);

Route::resource('settings/connectionsExternals', App\Http\Controllers\ConnectionsExternalsController::class);

Route::resource('companies', App\Http\Controllers\CompaniesController::class);

Route::resource('serviceAssigneds', App\Http\Controllers\ServiceAssignedsController::class);

Route::get('/assignedService/{id}', [App\Http\Controllers\ServiceAssignedsController::class, 'assignedCreate'])->name('serviceAssigneds.assignedCreate');
Route::post('/assignedService/{id}', [App\Http\Controllers\ServiceAssignedsController::class, 'assigned'])->name('serviceAssigneds.assigned');

Route::resource('documentUserFiles', App\Http\Controllers\DocumentUserFilesController::class);

Route::get('/documentUserFiles/{id}', [App\Http\Controllers\DocumentUserFilesController::class, 'docsFileList'])->name('documentUserFiles.docsFileList');
Route::get('/documentUserFiles/{userID}/{docID}', [App\Http\Controllers\DocumentUserFilesController::class, 'docFileCreate'])->name('documentUserFiles.uploadFile');
Route::get('/documentUserFiles/{userID}/{fileID}/{docID}', [App\Http\Controllers\DocumentUserFilesController::class, 'docFileUpdate'])->name('documentUserFiles.uploadFileUpdate');
Route::post('/docIsSol', [App\Http\Controllers\DocumentUserFilesController::class, 'docIsSol']);
Route::post('/documentUserFiles/{userID}/{docID}', [App\Http\Controllers\DocumentUserFilesController::class, 'docFileUpload'])->name('documentUserFiles.docFileUpload');
Route::post('/documentUserFiles/{userID}/{fileID}/{docID}', [App\Http\Controllers\DocumentUserFilesController::class, 'docFileUploadUpdate'])->name('documentUserFiles.docFileUploadUpdate');

Route::resource('settings/PDFs/documentsEditors', App\Http\Controllers\documentsEditorsController::class);

Route::resource('settings/PDFs/templatesEditors', App\Http\Controllers\documentsEditorsController::class);

Route::resource('settings/PDFs/imagesDocuments', App\Http\Controllers\ImagesDocumentsController::class);

Route::resource('settings/PDFs/externalsDocuments', App\Http\Controllers\ExternalsDocumentsController::class);

Route::resource('salaryServiceAssigneds', App\Http\Controllers\SalaryServiceAssignedsController::class);

Route::post("/returnValuesDefault", [App\Http\Controllers\SalaryServiceAssignedsController::class, 'returnValues']);

Route::resource('alertDocuments', App\Http\Controllers\AlertDocumentsController::class);

Route::get('/alertDocuments/sendEmail/{userID}', [App\Http\Controllers\AlertDocumentsController::class, 'sendEmail'])->name('alertDocuments.sendEmail');
Route::get('sendEmailFull', [App\Http\Controllers\AlertDocumentsController::class, 'sendEmailFull'])->name('sendEmailFull');

Route::resource('subServices', App\Http\Controllers\SubServicesController::class);

Route::post('/subServices/assignSubService/{userId}/{subServiceId}', [App\Http\Controllers\SubServicesController::class, 'assignSubService'])->name('subServices.assignSubService');

Route::get('/subServices/list/{idService}', [App\Http\Controllers\SubServicesController::class, 'list'])->name('subServices.list');

Route::get('/subServices/addSubService/{idService}', [App\Http\Controllers\SubServicesController::class, 'addSubService'])->name('subServices.addSubService');

Route::resource('settings/taskSubServices', App\Http\Controllers\TaskSubServicesController::class);

Route::resource('settings/units', App\Http\Controllers\UnitsController::class);

Route::resource('configSubServicesPatientes', App\Http\Controllers\ConfigSubServicesPatienteController::class);
