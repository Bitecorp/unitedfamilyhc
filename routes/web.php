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
    return view('auth/login');
});

Route::get('/register', function () {
    return view('auth/register');
});

Route::post('/registerWorker', [App\Http\Controllers\WorkerController::class, 'storeExternal'])->name('registerWorker');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('agents', App\Http\Controllers\AgentController::class);

Route::get('/agents/pdf/{id}/{idPdf}', [App\Http\Controllers\AgentController::class, 'getPDF'])->name('agent.pdf');

Route::post('/agents/updateState/{id}', [App\Http\Controllers\AgentController::class, 'updateState'])->name('agents.updateState');

Route::resource('patientes', App\Http\Controllers\PatienteController::class);

Route::get('/patientes/pdf/{id}/{idPdf}', [App\Http\Controllers\PatienteController::class, 'getPDF'])->name('patientes.pdf');

Route::post('/patientes/updateState/{id}', [App\Http\Controllers\PatienteController::class, 'updateState'])->name('patientes.updateState');

Route::resource('workers', App\Http\Controllers\WorkerController::class);

Route::get('/workers/pdf/{id}/{idPdf}', [App\Http\Controllers\WorkerController::class, 'getPDF'])->name('workers.pdf');

Route::post('/workers/updateState/{id}', [App\Http\Controllers\WorkerController::class, 'updateState'])->name('workers.updateState');

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

Route::resource('companies', App\Http\Controllers\CompaniesController::class);

Route::resource('serviceAssigneds', App\Http\Controllers\ServiceAssignedsController::class);

Route::get('/assignedService/{id}', [App\Http\Controllers\ServiceAssignedsController::class, 'assignedCreate'])->name('serviceAssigneds.assignedCreate');
Route::post('/assignedService/{id}', [App\Http\Controllers\ServiceAssignedsController::class, 'assigned'])->name('serviceAssigneds.assigned');

Route::resource('documentUserFiles', App\Http\Controllers\DocumentUserFilesController::class);

Route::get('/documentUserFiles/{id}', [App\Http\Controllers\DocumentUserFilesController::class, 'docsFileList'])->name('documentUserFiles.docsFileList');
Route::get('/documentUserFiles/{userID}/{docID}', [App\Http\Controllers\DocumentUserFilesController::class, 'docFileCreate'])->name('documentUserFiles.uploadFile');
Route::get('/documentUserFiles/{userID}/{fileID}/{docID}', [App\Http\Controllers\DocumentUserFilesController::class, 'docFileUpdate'])->name('documentUserFiles.uploadFileUpdate');

Route::post('/documentUserFiles/{userID}/{docID}', [App\Http\Controllers\DocumentUserFilesController::class, 'docFileUpload'])->name('documentUserFiles.docFileUpload');
Route::post('/documentUserFiles/{userID}/{fileID}/{docID}', [App\Http\Controllers\DocumentUserFilesController::class, 'docFileUploadUpdate'])->name('documentUserFiles.docFileUploadUpdate');

Route::resource('settings/PDFs/documentsEditors', App\Http\Controllers\documentsEditorsController::class);

Route::resource('settings/PDFs/imagesDocuments', App\Http\Controllers\ImagesDocumentsController::class);

Route::resource('settings/PDFs/externalsDocuments', App\Http\Controllers\ExternalsDocumentsController::class);

Route::resource('salaryServiceAssigneds', App\Http\Controllers\SalaryServiceAssignedsController::class);

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
