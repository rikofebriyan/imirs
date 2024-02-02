<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MakerController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubcontController;
use App\Http\Controllers\StockoutController;
use App\Http\Controllers\RepairkitController;
use App\Http\Controllers\GanttchartController;
use App\Http\Controllers\PartrepairController;
use App\Http\Controllers\CategoryCodeController;
use App\Http\Controllers\FinishrepairController;
use App\Http\Controllers\ItemstandardController;
use App\Http\Controllers\ProgresstrialController;
use App\Http\Controllers\WaitingrepairController;
use App\Http\Controllers\CodepartrepairController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProgressrepairController;
use App\Http\Controllers\MastersparepartController;
use App\Http\Controllers\WaitingApprovalController;
use App\Http\Controllers\RegisteredTicketController;
use App\Http\Controllers\ProgresspemakaianController;
use App\Http\Controllers\StandardpengecekanController;

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


// Auth::routes();
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'submitLogin'])->name('login');
Route::post('/register', [LoginController::class, 'submitRegister'])->name('submit-register');
Route::get('/reset-password', [LoginController::class, 'resetPassword'])->name('reset-password');
Route::post('/send-reset-password', [LoginController::class, 'sendResetPassword'])->name('send-reset-password');
Route::get('/recovery-password', [LoginController::class, 'recoveryPassword'])->name('recovery-password');
Route::post('/password-update', [LoginController::class, 'passwordRecovery'])->name('password-recovery');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/partrepair/request', [PartrepairController::class, 'request'])->name('request');
Route::get('/partrepair/ganttchart', [GanttchartController::class, 'index'])->name('ganttchart');
Route::get('/partrepair/deletedtable', [WaitingrepairController::class, 'deleted'])->name('deletedtable');
Route::get('/partrepair/finishtable', [WaitingrepairController::class, 'finish'])->name('finishtable');
Route::prefix('partrepair')->name('partrepair.')->group(function () {
    Route::get('/waitingtable', [WaitingrepairController::class, 'index'])->name('waitingtable.index');
    Route::get('/registeredticket', [RegisteredTicketController::class, 'index'])->name('registeredticket.index');
    Route::get('/waitingtable/{id}', [WaitingrepairController::class, 'waitingRepairForm1'])->name('waitingtable.show');
    Route::get('/waitingtable/form2/{id}', [WaitingrepairController::class, 'waitingRepairForm2'])->name('waitingtable.show.form2');
    Route::get('/waitingtable/form3/{id}', [WaitingrepairController::class, 'waitingRepairForm3'])->name('waitingtable.show.form3');
    Route::get('/waitingtable/form4/{id}', [WaitingrepairController::class, 'waitingRepairForm4'])->name('waitingtable.show.form4');
    Route::get('/waitingtable/form5/{id}', [WaitingrepairController::class, 'waitingRepairForm5'])->name('waitingtable.show.form5');
    Route::delete('/waitingtable/{id}', [WaitingrepairController::class, 'destroy'])->name('waitingtable.destroy');
    Route::post('/waitingtable', [WaitingrepairController::class, 'store'])->name('waitingtable.store');
    Route::put('/progresstable/revision/{id}', [ProgressrepairController::class, 'revision'])->name('progress.revision');
    Route::put('/progresstable/delay/{id}', [ProgressrepairController::class, 'delay'])->name('progress.delay');
    Route::resource('/progresstable', ProgressrepairController::class);
    Route::resource('/progresspemakaian', ProgresspemakaianController::class);
    Route::resource('/progresstrial', ProgresstrialController::class);
    Route::get('/progresstrial/delete/{id}', [ProgresstrialController::class, 'deleteTrial'])->name('progresstrial.delete');
    Route::post('/progresstrial/update/{id}', [ProgresstrialController::class, 'updateTrial'])->name('progresstrial.update');
    Route::resource('/finishrepair', FinishrepairController::class);
    Route::resource('/stockout', StockoutController::class);
    Route::resource('/waitingapprove', WaitingApprovalController::class);
    Route::get('/progress-subcont-table', [WaitingrepairController::class, 'progressSubcontTable'])->name('progress-subcont-table');
});

Route::resource('matrix/user', UserController::class);
Route::resource('matrix/section', SectionController::class);
Route::resource('matrix/line', LineController::class);
Route::resource('matrix/machine', MachineController::class);
Route::resource('matrix/maker', MakerController::class);
Route::resource('matrix/master_spare_part', MastersparepartController::class);
Route::resource('matrix/standard_pengecekan', StandardpengecekanController::class);
Route::resource('matrix/repair_kit', RepairkitController::class);
Route::resource('matrix/subcont', SubcontController::class);
Route::resource('matrix/item_standard', ItemstandardController::class);
Route::resource('matrix/code_part_repair', CodepartrepairController::class);
Route::resource('matrix/category_code', CategoryCodeController::class);
Route::resource('Auth/profile', ProfileController::class);

Route::get('/ajax', [InfoController::class, 'index'])->name('ajax');
Route::get('/getline', [InfoController::class, 'getline'])->name('get-line');
Route::get('/getstorage', [InfoController::class, 'getstorage'])->name('get-storage');
Route::get('/getmachine', [InfoController::class, 'getmachine'])->name('get-machine');
Route::get('/getlabour', [InfoController::class, 'getlabour'])->name('get-labour');
Route::get('/get-number-of-repair', [InfoController::class, 'getNumberOfRepair'])->name('get-number-of-repair');
Route::get('/getMaker', [InfoController::class, 'getmaker'])->name('get-maker');
Route::get('/getTypeOfPart', [InfoController::class, 'getTypeOfPart'])->name('get-type-of-part');
Route::get('/getSubcont', [InfoController::class, 'getSubcont'])->name('get-subcont');
Route::get('/getcategory', [InfoController::class, 'getcategory'])->name('get-category');
Route::get('/report', [HomeController::class, 'reportHome'])->name('report');
Route::get('/partrepair/masterdelete', [InfoController::class, 'masterdelete'])->name('part-repair-master-delete');
Route::get('/getmaster', [InfoController::class, 'getmaster'])->name('get-master');
Route::get('/mymodel', [InfoController::class, 'mymodel'])->name('mymodel');
Route::get('/mymodelrevision', [InfoController::class, 'mymodelrevision'])->name('mymodelrevision');
Route::patch('/updatemodel/{id}', [InfoController::class, 'updatemodel']);
Route::post('/export', [ExportController::class, 'export'])->name('export');
Route::post('/export_finish', [ExportController::class, 'export_finish'])->name('export_finish');
Route::post('/export_waiting', [ExportController::class, 'export_waiting'])->name('export_waiting');
Route::get('/ticket', [ExportController::class, 'ticket'])->name('ticket');
Route::get('/ticket_finish/{id}', [ExportController::class, 'ticket_finish'])->name('ticket_finish');
Route::post('/sendemail', [EmailController::class, 'sendEmail'])->name('sendemail');
Route::get('/getUnitMeasurement', [InfoController::class, 'getUnitMeasurement'])->name('get-unit-measurement');
Route::get('/reconditionSheet', [ExportController::class, 'reconditionSheet'])->name('recondition_sheet');
Route::get('/getStandardPengecekan', [PartrepairController::class, 'getStandardPengecekan'])->name('get-standard-pengecekan');
