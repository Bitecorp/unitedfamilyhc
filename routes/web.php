<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;

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

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('patientes', App\Http\Controllers\PatienteController::class);

Route::get('/patientes/pdf/{id}/{idPdf}', [App\Http\Controllers\PatienteController::class, 'getPDF'])->name('patientes.pdf');

Route::post('/patientes/updateState/{id}', [App\Http\Controllers\PatienteController::class, 'updateState'])->name('patientes.updateState');

Route::resource('workers', App\Http\Controllers\WorkerController::class);

Route::get('/workers/pdf/{id}/{idPdf}', [App\Http\Controllers\WorkerController::class, 'getPDF'])->name('workers.pdf');

Route::post('/workers/updateState/{id}', [App\Http\Controllers\WorkerController::class, 'updateState'])->name('workers.updateState');

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

Route::resource('salaryServiceAssigneds', App\Http\Controllers\SalaryServiceAssignedsController::class);

Route::resource('alertDocuments', App\Http\Controllers\AlertDocumentsController::class);

Route::resource('subServices', App\Http\Controllers\SubServicesController::class);

Route::get('/subServices/list/{idService}', [App\Http\Controllers\SubServicesController::class, 'list'])->name('subServices.list');

Route::get('/subServices/addSubService/{idService}', [App\Http\Controllers\SubServicesController::class, 'addSubService'])->name('subServices.addSubService');
