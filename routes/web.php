<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Customer\ContactController;
use App\Http\Controllers\Customer\ReservationController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Admin\InvoiceController;


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
Route::middleware(['auth'])->prefix('admin')->group(function(){
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('',[DashboardController::class,'Index']);
    // Route::get('notification',[NotificationController::class,'markAsRead'])->name('mark-as-read');
    // Route::get('notification-read',[NotificationController::class,'read'])->name('read');
    Route::get('profile',[UserController::class,'profile'])->name('profile');
    Route::post('profile/{user}',[UserController::class,'updateProfile'])->name('profile.update');
    Route::put('profile/update-password/{user}',[UserController::class,'updatePassword'])->name('update-password');
    Route::post('logout',[LogoutController::class,'index'])->name('logout');

    Route::resource('users',UserController::class);
    
    Route::resource('permissions',PermissionController::class)->only(['index','store','destroy']);
    Route::put('permission',[PermissionController::class,'update'])->name('permissions.update');

    Route::resource('roles',RoleController::class);

    Route::resource('suppliers',SupplierController::class);
    
    Route::resource('categories',CategoryController::class)->only(['index','store','destroy']);
    Route::put('categories',[CategoryController::class,'update'])->name('categories.update');

    Route::resource('purchases',PurchaseController::class)->except('show');
    Route::get('purchases/reports',[PurchaseController::class,'reports'])->name('purchases.report');
    Route::post('purchases/reports',[PurchaseController::class,'generateReport']);

    Route::resource('products',ProductController::class)->except('show');
    Route::get('products/outstock',[ProductController::class,'outstock'])->name('outstock');
    Route::get('products/expired',[ProductController::class,'expired'])->name('expired');

    Route::resource('sales',SaleController::class)->except('show');
    Route::get('sales/reports',[SaleController::class,'reports'])->name('sales.report');
    Route::post('sales/reports',[SaleController::class,'generateReport']);

    Route::get('backup', [BackupController::class,'index'])->name('backup.index');
    Route::put('backup/create', [BackupController::class,'create'])->name('backup.store');
    Route::get('backup/download/{file_name?}', [BackupController::class,'download'])->name('backup.download');
    Route::delete('backup/delete/{file_name?}', [BackupController::class,'destroy'])->where('file_name', '(.*)')->name('backup.destroy');
    Route::prefix('demand-forecast')->name('demand-forecast.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DemandForecastController::class, 'index'])->name('index');
    Route::post('/predict', [App\Http\Controllers\Admin\DemandForecastController::class, 'predict'])->name('predict');
    Route::post('/batch-predict', [App\Http\Controllers\Admin\DemandForecastController::class, 'batchPredict'])->name('batch-predict');
    Route::get('/historical-sales', [App\Http\Controllers\Admin\DemandForecastController::class, 'getHistoricalSales'])->name('historical-sales');
    Route::get('/history', [App\Http\Controllers\Admin\DemandForecastController::class, 'history'])->name('history');
    Route::delete('/prediction/{prediction}', [App\Http\Controllers\Admin\DemandForecastController::class, 'deletePrediction'])->name('delete-prediction');
    });
    Route::get('settings',[SettingController::class,'index'])->name('settings');
});

Route::middleware(['guest'])->prefix('admin')->group(function () {
    Route::get('',[DashboardController::class,'Index']);

    Route::get('login',[LoginController::class,'index'])->name('login');
    Route::post('login',[LoginController::class,'login']);

    Route::get('register',[RegisterController::class,'index'])->name('register');
    Route::post('register',[RegisterController::class,'store']);

    Route::get('forgot-password',[ForgotPasswordController::class,'index'])->name('password.request');
    Route::post('forgot-password',[ForgotPasswordController::class,'requestEmail']);
    Route::get('reset-password/{token}',[ResetPasswordController::class,'index'])->name('password.reset');
    Route::post('reset-password',[ResetPasswordController::class,'resetPassword'])->name('password.update');
});
// Notification routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/notifications/expired', [NotificationController::class, 'notifyExpired']);
    Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/mark-as-read/{id}', [NotificationController::class, 'read'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
    Route::get('/notifications/out-stock', [NotificationController::class, 'notifyOutStock'])->name('notifications.out-stock');
});
// Route::prefix('notifications')->group(function () {
//     Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
//     Route::delete('/delete-all', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
// Route::get('/expired', [NotificationController::class, 'notifyExpired'])->name('notifications.expired');
//     Route::get('/out-stock', [NotificationController::class, 'notifyOutStock'])->name('notifications.out-stock');
// });


Route::get('/test-expiry', function() {
    $purchase = App\Models\Purchase::first();
    $purchase->expiry_date = now()->subDay();
    $purchase->save();
    
    return response()->json([
        'message' => 'Purchase expired!',
        'notifications' => App\Models\User::find(1)->notifications
    ]);
});

// Barcode Management Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/barcode/management', [App\Http\Controllers\Admin\BarcodeController::class, 'index'])->name('barcode.index');
    Route::post('/barcode/scan', [App\Http\Controllers\Admin\BarcodeController::class, 'scan'])->name('barcode.scan');
    Route::post('/barcode/generate-all', [App\Http\Controllers\Admin\BarcodeController::class, 'generateAllBarcodes']);
    Route::post('/qrcode/generate-all', [App\Http\Controllers\Admin\BarcodeController::class, 'generateAllQRCodes']);
    Route::get('/barcode/print', [App\Http\Controllers\Admin\BarcodeController::class, 'printBarcodes'])->name('barcode.print');
});

//customer routes
Route::get('/customer', [HomeController::class, 'index'])->name('home');
Route::get('/medicines', [HomeController::class, 'medicines'])->name('medicines');
Route::get('/symptom-checker', [HomeController::class, 'symptomChecker'])->name('symptom-checker');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/my-reservations', [ReservationController::class, 'index'])->name('my-reservations');



// Invoice Management Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::resource('invoices', InvoiceController::class);
    Route::patch('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::post('invoices/convert-sales', [InvoiceController::class, 'convertSalesToInvoices'])->name('invoices.convert-sales');
});


Route::get('/', function () {
    return view('welcome');
});

