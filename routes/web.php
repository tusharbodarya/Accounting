<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\PurchaseReturnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');
// Auth Routes 

// Route::get('/auth/login', [AuthController::class, 'login'])->name('auth.login');
// Route::get('/auth/register', [AuthController::class, 'register'])->name('auth.register');
// Route::post('/auth/add', [AuthController::class, 'add'])->name('auth.add');
// Route::post('/auth/check', [AuthController::class, 'check'])->name('auth.check');
// Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::group(['middleware'=>['AuthCheck']],function(){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/welcome', function () {
        return view('welcome');
    });
// Add-Files
    Route::post('/add-files/addacgroup', [AccountsController::class, 'addacgroup'])->name('add-files.addacgroup');
    Route::post('/add-files/addaccount', [AccountsController::class, 'addaccount'])->name('add-files.addaccount');
    Route::post('/add-files/fetchaccountsgroup', [AccountsController::class, 'fetchaccountsgroup'])->name('add-files.fetchaccountsgroup');

    Route::get('/add-accounts', function () {
        return view('add-files/add-accounts');
    });
     Route::get('/add-accountsgroup', function () {
        return view('add-files/add-accountsgroup');
    });

    //tbl-file
    Route::get('/tbl-accounts', [AccountsController::class, 'tbl_fetchaccounts'])->name('tbl-files.tbl-accounts');
    Route::get('/tbl-accountsgroup', [AccountsController::class, 'tbl_fetchaccountsgroup'])->name('tbl-files.tbl-accountsgroup');
    Route::post('/tbl-files/fetchacdetails', [AccountsController::class, 'fetchacdetails'])->name('tbl-files.fetchacdetails');
    Route::post('/tbl-files/fetchacgroupdetails', [AccountsController::class, 'fetchacgroupdetails'])->name('tbl-files.fetchacgroupdetails');
    Route::get('/tbl-productCatagories', [ProductController::class, 'tbl_fetchproductCatagories'])->name('tbl-files.tbl-productCatagories');
//edit-file

    Route::get('/edit-account/{id}', [AccountsController::class, 'edit_accounts']);
    Route::post('/update_ac', [AccountsController::class, 'update_ac'])->name('update_ac');
    Route::get('/edit-accountgroup/{id}', [AccountsController::class, 'edit_accountsgroup']);
    Route::post('/update_acgroup', [AccountsController::class, 'update_acgroup'])->name('update_acgroup');
    
    //Delete-Routs
    Route::get('/delete-account/{id}', [AccountsController::class, 'delete_account']);
    Route::get('/delete-accountgroup/{id}', [AccountsController::class, 'delete_accountgroup']);
    
    
    // Sales
    Route::resource('saleinvoice', SalesController::class);
    Route::get('/saleinvoice-delete/{id}', [SalesController::class, 'saleInvoiceDelete']);
    Route::post('/fetchaccounts', [SalesController::class, 'fetchaccount'])->name('fetchaccounts');
    Route::post('/fetchac-details', [SalesController::class, 'fetchac_details'])->name('fetchac-details');
    Route::post('/fetch-product', [SalesController::class, 'fetch_product'])->name('fetch-product');
    Route::post('/fetch-productsdetails', [SalesController::class, 'fetch_productsdetails'])->name('fetch-productsdetails');
    Route::get('/send-mail', [SalesController::class, 'sendInvoice'])->name('send-mail');
    // Sales Challan
    Route::get('/salechallan', [SalesController::class, 'salechallan'])->name('salechallan');
    Route::get('/salechallan-view/{id}', [SalesController::class, 'saleChallanView']);
    Route::get('/salechallan/{id}', [SalesController::class, 'saleChallan_edit']);
    Route::get('/salechallan-delete/{id}', [SalesController::class, 'saleChallanDelete']);
    Route::post('/salechallan_update/{id}', [SalesController::class, 'salechallan_update']);
    Route::post('/add-salechallan', [SalesController::class, 'salechallan_store'])->name('add-salechallan');
    Route::get('/show-salechallan', [SalesController::class, 'salechallan_show'])->name('show-salechallan');
    // Sales Return
    Route::resource('salesreturn', SalesReturnController::class);
    Route::get('/salesreturn-delete/{id}', [SalesReturnController::class, 'salesReturnDelete']);
    // Purchase Return
    Route::resource('purchasereturn', PurchaseReturnController::class);
    Route::get('/purchasereturn-delete/{id}', [PurchaseReturnController::class, 'purchaseReturnDelete']);
    //products
    Route::resource('product', ProductController::class);
    Route::get('/add-productCategory', function () {
        return view('add-files/add-productCategory');
    });
    Route::post('/add-productCatagories', [ProductController::class, 'add_productCatagories'])->name('add-productCatagories');
    Route::get('/edit-productCatagories/{id}', [ProductController::class, 'edit_productCatagories']);
    Route::post('/update-productCatagories', [ProductController::class, 'update_productCatagories'])->name('update-productCatagories');
    Route::get('/delete-productCatagories/{id}', [ProductController::class, 'delete_productCatagories']);
    //Purchase
    Route::resource('purchaseinvoice', PurchaseController::class);
    Route::get('/purchaseinvoice-delete/{id}', [PurchaseController::class, 'purchaseInvoiceDelete']);
    //purchase challan
    Route::get('/purchasechallan', [PurchaseController::class, 'purchasechallan'])->name('purchasechallan');
    Route::get('/purchasechallan-view/{id}', [PurchaseController::class, 'purchaseChallanView']);
    Route::get('/purchasechallan/{id}', [PurchaseController::class, 'purchaseChallan_edit']);
    Route::get('/purchasechallan-delete/{id}', [PurchaseController::class, 'purchaseChallanDelete']);
    Route::post('/purchasechallan_update/{id}', [PurchaseController::class, 'purchasechallan_update']);
    Route::post('/add-purchasechallan', [PurchaseController::class, 'purchasechallan_store'])->name('add-purchasechallan');
    Route::get('/show-purchasechallan', [PurchaseController::class, 'purchasechallan_show'])->name('show-purchasechallan');
    // Transactions
    Route::get('/add-transaction', [AccountsController::class, 'transactions']);
    Route::post('/fetch-transactionac', [AccountsController::class, 'fetch_transactionac'])->name('fetch-transactionac');
    Route::post('/fetch-transactionacdetails', [AccountsController::class, 'fetch_transactionacdetails'])->name('fetch-transactionacdetails');
    Route::post('/store-transaction', [AccountsController::class, 'store_transaction'])->name('fetch-transaction');
    Route::get('/transaction', [AccountsController::class, 'index_transaction'])->name('transaction');
    Route::get('/transaction-view/{id}', [AccountsController::class, 'transaction_view'])->name('transaction-view');
    Route::get('/accountstatement', [AccountsController::class, 'accountstatement'])->name('accountstatement');
    
    //Reports
    Route::get('/trading', [ReportController::class, 'trading'])->name('trading');
    Route::get('/balancesheet', [ReportController::class, 'balancesheet'])->name('balancesheet');
    Route::get('/profit_loss', [ReportController::class, 'profit_loss'])->name('profit_loss');

});




Auth::routes();

Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
