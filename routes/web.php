<?php

use App\Http\Controllers\Publisher\WithdrawController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Publisher\TaskController;
use App\Http\Controllers\Advertiser\InvoiceController;
use App\Http\Controllers\Publisher\EarningsController;
use App\Http\Controllers\Advertiser\CampaignController;
use App\Http\Controllers\Advertiser\DashboardController;
use App\Http\Controllers\Advertiser\CampaignTaskController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WithdrawRequestController;
use App\Http\Controllers\Advertiser\TaskController as AdvertiserTaskController;
use App\Http\Controllers\Advertiser\ProfileController as AdvertiserProfileController;
use App\Http\Controllers\Publisher\CampaignController as PublisherCampaignController;
use App\Http\Controllers\Publisher\ProfileController as PublisherProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/************************************************************************************
 * ****************************** admin routes **************************************
 ***********************************************************************************/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])
    ->group(function () {
        // Dashboard
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Campaigns
        Route::get('campaigns', [AdminCampaignController::class, 'index'])->name('campaigns.index');
        Route::get('campaigns/{campaign}', [AdminCampaignController::class, 'show'])->name('campaigns.show');
        Route::post('campaigns/{campaign}/approve', [AdminCampaignController::class, 'approve'])->name('campaigns.approve');
        Route::post('campaigns/{campaign}/reject', [AdminCampaignController::class, 'reject'])->name('campaigns.reject');
        Route::delete('campaigns/{campaign}', [AdminCampaignController::class, 'destroy'])->name('campaigns.destroy');

        // Users
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::get('users/{user}/edit_balance', [UserController::class, 'edit_balance'])->name('users.edit.balance');
        Route::put('users/{user}', [UserController::class, 'charge_balance'])->name('users.charge');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Invoices
        Route::get('invoices', [AdminInvoiceController::class, 'index'])->name('invoices.index');
        Route::get('invoices/{invoice}', [AdminInvoiceController::class, 'show'])->name('invoices.show');
        Route::post('invoices/{invoice}/paid', [AdminInvoiceController::class, 'markPaid'])->name('invoices.markPaid');

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');


         Route::get('/withdraw-requests', [WithdrawRequestController::class, 'index'])->name('withdraw.index');
    Route::post('/withdraw-requests/{request}/approve', [WithdrawRequestController::class, 'approve'])->name('withdraw.approve');
    Route::post('/withdraw-requests/{request}/reject', [WithdrawRequestController::class, 'reject'])->name('withdraw.reject');
    });
/*****************************************************************************************
 ******************************** advertiser routes **************************************
 *****************************************************************************************/
Route::group(['prefix' => 'advertiser', 'as' => 'advertiser.', 'middleware'
=> ['auth', 'role:advertiser']], function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

    // Campaigns
    Route::resource('campaigns', CampaignController::class);
    Route::get('/campaigns/{campaign}/tasks', [CampaignTaskController::class, 'edit'])->name('campaigns.tasks.edit');
    Route::post('/campaigns/{campaign}/tasks/update', [CampaignTaskController::class, 'update'])->name('campaigns.tasks.update');
    Route::delete('/media/{media}', [CampaignController::class, 'deleteCampaignMedia'])->name('campaign.media.delete');

    // Tasks
    Route::get('/tasks', [AdvertiserTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}/review', [AdvertiserTaskController::class, 'review'])->name('tasks.review');
    Route::post('/tasks/{task}/approve', [AdvertiserTaskController::class, 'approve'])->name('tasks.approve');
    Route::post('/tasks/{task}/reject', [AdvertiserTaskController::class, 'reject'])->name('tasks.reject');

    // Advertiser Profile
    Route::get('/profile', [AdvertiserProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [AdvertiserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [AdvertiserProfileController::class, 'updatePassword'])->name('profile.password');
});

/*************************************************************************************
 ********************************* publisher routes **********************************
 ************************************************************************************/

Route::prefix('publisher')->name('publisher.')->middleware(['auth', 'role:publisher'])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Publisher\DashboardController::class, 'index'])->name('dashboard');

    /** campaign tasks */
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

    /** publisher tasks */
    Route::get('/campaigns', [PublisherCampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/{campaign}', [PublisherCampaignController::class, 'show'])->name('campaigns.show');

    /** task execute */
    Route::post('/tasks/{task}/execute', [TaskController::class, 'execute'])->name('tasks.execute');
    Route::post('/tasks/{task}/submit', [TaskController::class, 'submit'])->name('tasks.submit');


    Route::get('/earnings', [EarningsController::class, 'index'])->name('earnings.index');

    /** publisher profile */
    Route::get('/profile', [PublisherProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [PublisherProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [PublisherProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/withdraw/request', [WithdrawController::class, 'store'])->name('withdraw.store');
});
require __DIR__ . '/auth.php';
