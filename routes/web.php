<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BUHController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\ContactsImportController;
use App\Http\Controllers\CSVDownloadController;
use App\Http\Controllers\DiscardController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HubspotContactController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Default Route
Route::get('/', function () {
    return view('Login');
})->name('login');
// Microsoft Login Route
Route::post('/microsoft-login', [AuthController::class, 'microsoftLogin'])->name('microsoft.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth:sanctum', 'verified'])->get('/view-user', function () {

    if (Auth::check()) {
        if (Auth::user()->role == 'Sales_Agent') {
            return redirect()->route('contact-listing');
        } elseif (Auth::user()->role == 'Admin') {
            return redirect()->route('admin#index');
        } else if (Auth::user()->role == 'BUH') {
            return redirect()->route('buh#index');
        }
    }
    return redirect()->route('login')->withErrors(['role' => 'Unauthorized access.']);
});

Route::group(['prefix' => 'Admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin#index');
    Route::get('/view-user', [AdminController::class, 'viewUser'])->name('user#view-user');
    Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('user#edit-user');
    Route::post('/update-user/{id}', [AdminController::class, 'updateUser'])->name('user#update-user');
    Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('user#delete-user');
    Route::post('/save-user', [AdminController::class, 'saveUser'])->name('user#save-user');
});
Route::group(['prefix' => 'Sales_Agent'], function () {
    Route::get('/', [ContactController::class, 'contactsByOwner'])->name('contact-listing');
    Route::get('/contact-listing', [ContactController::class, 'contactsByOwner'])->name('contact-listing');
    Route::get('view-contact/{contact_pid}', [ContactController::class, 'viewContact'])->name('contact#view');
    Route::get('/edit-contact/{contact_pid}', [ContactController::class, 'editContact'])->name('contact#edit');
    Route::post('/save-contact/{contact_pid}', [ContactController::class, 'updateContact'])->name('contact#update-contact');
    Route::get('/edit-archive/{contact_archive_pid}', [ArchiveController::class, 'editArchive'])->name('archive#edit');
    Route::get('/view-archive/{contact_archive_pid}', [ArchiveController::class, 'viewArchive'])->name('archive#view');
    Route::post('save-archive/{contact_archive_pid}', [ArchiveController::class, 'updateArchive'])->name('archive#update-archive');
    Route::get('/edit-discard/{contact_discard_pid}', [DiscardController::class, 'editDiscard'])->name('discard#edit');
    Route::get('/view-discard/{contact_discard_pid}', [DiscardController::class, 'viewDiscard'])->name('discard#view');
    Route::post('/save-discard/{contact_discard_pid}', [DiscardController::class, 'updateDiscard'])->name('discard#update-discard');
    Route::post('/save-activity/{contact_pid}', [ContactController::class, 'saveActivity'])->name('contact#save-activity');
    Route::get('/edit-activity/{contact_id}/{activity_id}', [ContactController::class, 'editActivity'])->name('contact#update-activity');
    Route::post('/contact/{contact_pid}/activity/{activity_id}/update', [ContactController::class, 'saveUpdateActivity'])
        ->name('contact#save-update-activity');
    Route::post('/save-discard-activity/{contact_discard_pid}', [
        DiscardController::class,
        'saveDiscardActivity'
    ])->name('discard#save-discard-activity');
});

Route::group(['prefix' => 'BUH'], function () {
    Route::get('/', [BUHController::class, 'index'])->name('buh#index');
    Route::get('/view-user', [UserController::class, 'viewUser'])->name('view-user');
    // Import Copy Route
    Route::get('/import-csv', function () {
        return view('csv_import_form');
    })->name('importcsv');
    Route::post('/import', [BUHController::class, 'import'])->name('import');
    // Edit Contact Detail Route
    Route::get('/edit-contact-detail', function () {
        return view('Edit_Contact_Detail_Page');
    })->name('edit-contac-detail');
    //get csv format
    Route::get('/get-csv', [CSVDownloadController::class, 'downloadCSV'])->name('get-csv');
    Route::get('/hubspot-contact', [ContactController::class, 'hubspotContacts'])->name('hubspot.contacts');
    Route::post('/submit-hubspot-contacts', [HubspotContactController::class, 'submitHubspotContacts'])->name('submit-hubspot-contacts');
    // Sales Agent Route
    Route::get('/owner', [OwnerController::class, 'owner'])->name('owner#view');
    Route::get('/view-owner/{owner_pid}', [OwnerController::class, 'viewOwner'])->name('owner#view-owner');
    Route::get('/edit-owner/{owner_pid}', [OwnerController::class, 'editOwner'])->name('owner#update');
    Route::post('/update-owner/{owner_pid}', [OwnerController::class, 'updateOwner'])->name('owner#update-owner');
});
