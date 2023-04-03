<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('/home');
// })->middleware('auth');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
});
// Route::group(['middleware' => ['auth', 'ADMIN']], function () {
//     Route::resource('matrix/user', UserController::class);
// });


Route::middleware(['auth'])->group(function () {
    Route::get('/partrepair', [PartrepairController::class, 'index'])->name('partrepair');
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
        Route::resource('/finishrepair', FinishrepairController::class);
        Route::resource('/stockout', StockoutController::class);
        Route::resource('/waitingapprove', WaitingApprovalController::class);
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
    Route::get('/getmachine', [InfoController::class, 'getmachine'])->name('get-machine');
    Route::get('/getlabour', [InfoController::class, 'getlabour'])->name('get-labour');
    Route::get('/get-number-of-repair', [InfoController::class, 'getNumberOfRepair'])->name('get-number-of-repair');
    Route::get('/getMaker', [InfoController::class, 'getmaker'])->name('get-maker');
    Route::get('/getTypeOfPart', [InfoController::class, 'getTyoeOfPart'])->name('get-type-of-part');
    Route::get('/getSubcont', [InfoController::class, 'getSubcont'])->name('get-subcont');
    Route::get('/getcategory', [InfoController::class, 'getcategory'])->name('get-category');
    Route::get('/report', 'HomeController@reportHome')->name('report');
    Route::get('/partrepair/masterdelete', [InfoController::class, 'masterdelete'])->name('part-repair-master-delete');
    Route::get('/getmaster', [InfoController::class, 'getmaster'])->name('get-master');
    Route::get('/mymodel', [InfoController::class, 'mymodel'])->name('mymodel');
    Route::get('/mymodelrevision', [InfoController::class, 'mymodelrevision'])->name('mymodelrevision');
    Route::patch('/updatemodel/{id}', [InfoController::class, 'updatemodel']);
    Route::post('/export', [ExportController::class, 'export'])->name('export');
});

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/partrepair', 'PartrepairController@index')->name('partrepair');
//     Route::get('/partrepair/request', 'PartrepairController@request')->name('request');
//     Route::get('/partrepair/ganttchart', 'GanttchartController@index')->name('ganttchart');
//     Route::get('/partrepair/deletedtable', 'WaitingrepairController@deleted')->name('deletedtable');
//     Route::get('/partrepair/finishtable', 'WaitingrepairController@finish')->name('finishtable');
//     Route::get('/partrepair/waitingtable', 'WaitingrepairController@index')->name('partrepair.waitingtable.index');
//     Route::get('/partrepair/registeredticket', 'RegisteredTicketController@index')->name('partrepair.registeredticket.index');
//     Route::get('/partrepair/waitingtable/{id}', 'WaitingrepairController@waitingRepairForm1')->name('partrepair.waitingtable.show');
//     Route::get('/partrepair/waitingtable/form2/{id}', 'WaitingrepairController@waitingRepairForm2')->name('partrepair.waitingtable.show.form2');
//     Route::get('/partrepair/waitingtable/form3/{id}', 'WaitingrepairController@waitingRepairForm3')->name('partrepair.waitingtable.show.form3');
//     Route::get('/partrepair/waitingtable/form4/{id}', 'WaitingrepairController@waitingRepairForm4')->name('partrepair.waitingtable.show.form4');
//     Route::get('/partrepair/waitingtable/form5/{id}', 'WaitingrepairController@waitingRepairForm5')->name('partrepair.waitingtable.show.form5');
//     Route::delete('/partrepair/waitingtable/{id}', 'WaitingrepairController@destroy')->name('partrepair.waitingtable.destroy');
//     Route::post('/partrepair/waitingtable', 'WaitingrepairController@store')->name('partrepair.waitingtable.store');
//     Route::put('/partrepair/progresstable/revision/{id}', 'ProgressrepairController@revision')->name('partrepair.progress.revision');
//     Route::put('/partrepair/progresstable/delay/{id}', 'ProgressrepairController@delay')->name('partrepair.progress.delay');
//     Route::resource('partrepair/progresstable', 'ProgressrepairController');
//     Route::resource('partrepair/progresspemakaian', 'ProgresspemakaianController');
//     Route::resource('partrepair/progresstrial', 'ProgresstrialController');
//     Route::resource('partrepair/finishrepair', 'FinishrepairController');
//     Route::resource('partrepair/stockout', 'StockoutController');
    
//     Route::resource('matrix/section', 'SectionController');
//     Route::resource('matrix/line', 'LineController');
//     Route::resource('matrix/machine', 'MachineController');
//     Route::resource('matrix/maker', 'MakerController');
//     Route::resource('matrix/master_spare_part', 'MastersparepartController');
//     Route::resource('matrix/standard_pengecekan', 'StandardpengecekanController');
//     Route::resource('matrix/repair_kit', 'RepairkitController');
//     Route::resource('matrix/subcont', 'SubcontController');
//     Route::resource('matrix/item_standard', 'ItemstandardController');
//     Route::resource('matrix/code_part_repair', 'CodepartrepairController');
//     Route::resource('matrix/category_code', 'CategoryCodeController');
//     Route::resource('Auth/profile', 'ProfileController');
//     Route::resource('partrepair/waitingapprove', 'WaitingApprovalController');

//     Route::get('/ajax', 'InfoController@index')->name('ajax');
//     Route::get('/getline', 'InfoController@getline')->name('get-line');
//     Route::get('/getmachine', 'InfoController@getmachine')->name('get-machine');
//     Route::get('/getlabour', 'InfoController@getlabour')->name('get-labour');
//     Route::get('/get-number-of-repair', 'InfoController@getNumberOfRepair')->name('get-number-of-repair');
//     Route::get('/getMaker', 'InfoController@getMaker')->name('get-maker');
//     Route::get('/getTypeOfPart', 'InfoController@getTypeOfPart')->name('get-type-of-part');
//     Route::get('/getSubcont', 'InfoController@getSubcont')->name('get-subcont');
//     Route::get('/getcategory', 'InfoController@getcategory')->name('get-category');
//     Route::get('/report', 'HomeController@reportHome')->name('report');
//     Route::get('/partrepair/masterdelete', 'InfoController@masterdelete')->name('part-repair-master-delete');
//     Route::get('/getmaster', 'InfoController@getmaster')->name('get-master');
//     Route::get('/mymodel', 'InfoController@mymodel')->name('mymodel');
//     Route::get('/mymodelrevision', 'InfoController@mymodelrevision')->name('mymodelrevision');
//     Route::patch('/updatemodel/{id}', 'InfoController@updatemodel');
//     Route::post('/export', 'ExportController@export')->name('export');
// });
