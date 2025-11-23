<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registrar\{
    UserController,
    DashboardController,
    RequestController,
    PaymentController,
    ProfileAccountController,
    StudentTransactionHistoryController,
    AnnouncementController
};

use App\Http\Controllers\Student\{
    HomepageController,
    DocumentPaymentController,
    DocumentRequestController,
    DocumentRequestStatusController,
    TransactionHistoryController,
    AccountController,
    StudentAnnouncementController
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:registrar'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('profile-account')->name('registrar-profile.')->group(function () {
        Route::get('/', [ProfileAccountController::class, 'index'])->name('index');
        Route::put('/update', [ProfileAccountController::class, 'update'])->name('update');
    });

    Route::prefix('announcement')->name('announcement.')->group(function(){
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::post('/store', [AnnouncementController::class, 'store'])->name('store');
        Route::get('/record', [AnnouncementController::class, 'AllAnnouncement'])->name('fetch');
        Route::get('/view', [AnnouncementController::class, 'ViewAnnouncement'])->name('show');
        Route::post('/update', [AnnouncementController::class, 'update'])->name('update');
        Route::delete('/delete', [AnnouncementController::class, 'delete'])->name('delete');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/create', [UserController::class, 'store'])->name('store');
        Route::get('/record', [UserController::class, 'UserRecord'])->name('fetch');
        Route::delete('/delete', [UserController::class, 'delete'])->name('delete');
        Route::get('/view', [UserController::class, 'view'])->name('view');
        Route::post('/update', [UserController::class, 'update'])->name('update');
    });

    Route::prefix('request')->name('request.')->group(function () {
        Route::get('/', [RequestController::class, 'index'])->name('index');
        Route::get('/all-request', [RequestController::class, 'AllRequest'])->name('fetch');
        Route::get('/document/view', [RequestController::class, 'ViewRequestedDocument'])->name('view-document');
        Route::post('/update-status', [RequestController::class, 'UpdateStatus'])->name('update-status');
        Route::get('/view/status', [RequestController::class, 'ViewStatus'])->name('view-status');
        Route::delete('/delete', [RequestController::class, 'delete'])->name('delete');
    });

    Route::prefix('document-payment')->name('payment.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/all-payment', [PaymentController::class, 'AllPayment'])->name('fetch');
        Route::get('/status', [PaymentController::class, 'ViewPaymentStatus'])->name('status');
        Route::post('/update-status', [PaymentController::class, 'UpdatePaymentStatus'])->name('update-status');
    });

     Route::prefix('transaction')->name('transactions.')->group(function () {
        Route::get('/', [StudentTransactionHistoryController::class, 'index'])->name('index');
        Route::get('/all-transaction', [StudentTransactionHistoryController::class, 'AllTransactionHistory'])->name('fetch');
        Route::get('/download', [StudentTransactionHistoryController::class, 'download'])->name('download');

    });



});

Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/student/homepage', [HomepageController::class, 'index'])->name('student.homepage.index');

    Route::prefix('account')->name('student-account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::put('/update', [AccountController::class, 'update'])->name('update');
    });

      Route::prefix('today-announcement')->name('today-announcement.')->group(function(){
        Route::get('/', [StudentAnnouncementController::class, 'index'])->name('index');

    });


    Route::prefix('document')->name('document.')->group(function () {
        Route::get('/request', [DocumentRequestController::class, 'index'])->name('request.index');
        Route::post('/store', [DocumentRequestController::class, 'store'])->name('request.store');
        Route::get('/request/slip/{ref_no}', [DocumentRequestController::class, 'generateSlip'])->name('request.slip');
        Route::get('/request/download-slip/{ref_no}', [DocumentRequestController::class, 'downloadSlip'])->name('request.download');

        Route::get('/request/all-request', [DocumentRequestController::class, 'AllRequestIndex'])->name('request.record.index');
        Route::get('/request/record'  , [DocumentRequestController::class, 'AllRequestRecord'])->name('request.record');
        Route::get('/request/view', [DocumentRequestController::class, 'ViewRequestItem'])->name('request.view-item');
        Route::get('/view', [DocumentRequestController::class, 'ViewPayment'])->name('request.view-payment');
        Route::post('/request/cancel', [DocumentRequestController::class, 'DocumentRequestCancel'])->name('request.cancel');
    });

    Route::prefix('payment')->name('document.')->group(function () {
        Route::post('/store', [DocumentPaymentController::class, 'store'])->name('request.payment');

    });

     Route::prefix('document-request')->name('document-request-status.')->group(function () {
        Route::get('/status', [DocumentRequestStatusController::class, 'index'])->name('index');

    });

    Route::prefix('transaction-history')->name('transactions-history.')->group(function () {
        Route::get('/', [TransactionHistoryController::class, 'index'])->name('index');
        Route::get('/all-transaction', [TransactionHistoryController::class, 'AllTransaction'])->name('fetch');
    });

});


require __DIR__.'/auth.php';
