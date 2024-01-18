<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Employee\PostController;
use App\Http\Controllers\Employee\HealthController;
use App\Http\Controllers\Employee\MemberController;
use App\Http\Controllers\Employee\TicketController;
use App\Http\Controllers\Employee\AddressController;
use App\Http\Controllers\Employee\ProfileController;
use App\Http\Controllers\Employee\ReferralController;
use App\Http\Controllers\Employee\TrainingController;
use App\Http\Controllers\Employee\HouseholdController;
use App\Http\Controllers\Employee\HauoraPlanController;
use App\Http\Controllers\Employee\MedicationController;
use App\Http\Controllers\Employee\ClientAlertController;
use App\Http\Controllers\Employee\StockAssignController;
use App\Http\Controllers\Employee\ImmunizationController;
use App\Http\Controllers\Employee\NotificationController;
use App\Http\Controllers\Employee\PrescriptionController;
use App\Http\Controllers\Employee\ClientFamilyTreeController;
use App\Http\Controllers\Employee\EmergencyContactController;

/*
|--------------------------------------------------------------------------
| Web Routes || Employee Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'role:employee'], function () {

    Route::get('/', function () {
        return redirect()->route('employee.login');
    });

    Route::get('/cache/clear', [CacheController::class, 'clear'])->name('clear.cache');

    Route::get('/dashboard', 'HomeController@dashboard')->name('home.dashboard');

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'controller' => ProfileController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/update', 'showUpdateForm')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::get('/update-password', 'showUpdatePasswordForm')->name('update_password');
        Route::post('/update-password', 'updatePassword');
        Route::get('/notification/all', 'showAllNotifications')->name('notification');
        Route::get('/attendance', 'attendance')->name('attendance');
        Route::post('/security/update', 'securityUpdate')->name('security.update');
    });

    Route::group(['prefix' => 'address', 'as' => 'address.', 'controller' => AddressController::class], function () {
        Route::post('/update', 'update')->name('update');
    });

    // Emergency Contact
    Route::group(['prefix' => 'emergency', 'as' => 'emergency.', 'controller' => EmergencyContactController::class], function () {

        Route::get('/create', 'showCreateForm')->name('create');
        Route::post('/create', 'create');
        Route::get('/{emergency}/update', 'showUpdateForm')->name('update');
        Route::post('/{emergency}/update', 'update');
        Route::post('/{emergency}/delete-api', 'deleteApi')->name('delete.api');
    });

    // Household
    Route::group(['prefix' => 'house_hold', 'as' => 'house_hold.', 'controller' => HouseholdController::class], function () {
        Route::get('/create', 'showCreateForm')->name('create');
        Route::post('/create', 'store');
        Route::get('/{house_hold}/update', 'showUpdateForm')->name('update');
        Route::post('/{house_hold}/update', 'update');
    });

    // Health
    Route::group(['prefix' => 'health', 'as' => 'health.', 'controller' => HealthController::class], function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store');
        Route::get('/{health}/update', 'edit')->name('update');
        Route::post('/{health}/update', 'update');
    });

    // Certificate
    Route::group(['prefix' => 'certificates', 'as' => 'certificate.', 'controller' => TrainingController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{training}/edit', 'edit')->name('edit');
        Route::post('/{training}/update', 'update')->name('update');
        Route::post('/{training}/delete', 'destroy')->name('delete');
    });

    // Attachment
    Route::group(['prefix' => 'attachments', 'as' => 'attachment.', 'controller' => AttachmentController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{attachment}/edit', 'edit')->name('edit');
        Route::post('/{attachment}/update', 'update')->name('update');
        Route::post('/{attachment}/delete', 'destroy')->name('delete');
    });

    // Notifications
    Route::group(['prefix' => 'notifications', 'as' => 'notification.', 'controller' => NotificationController::class], function () {
        Route::get('/', 'index')->name('index');
    });

    // Tickets
    Route::group(['prefix' => 'tickets', 'as' => 'ticket.', 'controller' => TicketController::class], function () {

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'showCreateForm')->name('create');
        Route::post('/create', 'create');
        Route::get('/{ticket}/update', 'showUpdateForm')->name('update');
        Route::post('/{ticket}/update', 'update');
        Route::get('/{ticket}/show', 'show')->name('show');
        Route::post('/{ticket}/reply', 'reply')->name('reply');
        Route::post('/{ticket}/assignee', 'changeAssignee')->name('assignee');
        Route::post('/{ticket}/change-status', 'changeStatus')->name('change_status');
        Route::get('/{ticket}/reopen', 'reOpen')->name('reopen');
        Route::get('/assigned', 'assignedTicket')->name('assigned_ticket');
    });

    // Post
    Route::group(['prefix' => 'posts', 'as' => 'post.', 'controller' => PostController::class], function () {

        Route::get('/', 'index')->name('index');
        Route::get('/{post}/show', 'show')->name('show');
        Route::get('/{post}/test', 'postTest')->name('test');
        Route::post('/{post}/answer', 'answerSubmit')->name('answer');
    });

    // Stock Assign
    Route::group(['prefix' => 'stock/assign', 'as' => 'stock_assign.', 'controller' => StockAssignController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{stock_assign}/show', 'show')->name('show');
        Route::post('/{stock_assign}/accept', 'acceptStock')->name('accept_stock');
        Route::post('/status/change', 'stockStatusChange')->name('stock_status_change');
        Route::post('/accept-all', 'acceptAllStock')->name('accept_all_stock');
    });

    // Referral
    Route::group(['prefix' => '/referrals', 'as' => 'referral.', 'controller' => ReferralController::class], function () {

        Route::get('/', 'index')->name('index');
        Route::get('/{referral}/edit', 'edit')->name('edit');
        Route::post('/{referral}/update', 'update')->name('update');
        Route::get('/{referral}/show', 'show')->name('show');
        Route::post('/{referral}/status-update-api', 'statusUpdate')->name('status.update.api');
        Route::post('/{referral}/rerefer-api', 'reRefer')->name('reefer.api');
    });

    // Attendance
    Route::group(['prefix' => 'attendance', 'as' => 'attendance.', 'controller' => AttendanceController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });

    // Members
    Route::group(['prefix' => 'members', 'as' => 'member.', 'controller' => MemberController::class], function () {
        Route::get('/{member}/show', 'show')->name('show');
        Route::get('/{member}/show/details', 'showDetails')->name('show.details');
        Route::get('/{member}/show/address', 'showAddress')->name('show.address');
        Route::get('/{member}/show/contact', 'showContact')->name('show.contact');
        Route::get('/{member}/show/household', 'showHousehold')->name('show.household');
        Route::get('/{member}/show/health', 'showHealth')->name('show.health');
        Route::get('/{member}/show/client_alert', 'showAlert')->name('show.alert');
        Route::get('/{member}/show/note', 'showNote')->name('show.note');

        Route::get('/{member}/show/hauora_plan', 'showHauoraPlan')->name('show.hauora.plan');
        Route::get('/{member}/show/medication', 'showMedication')->name('show.medication');
        Route::get('/{member}/show/immunization', 'showImmunization')->name('show.immunization');
        Route::get('/{member}/show/family_tree', 'showFamilyTree')->name('show.family.tree');

        Route::get('/prescriptions/{member}', 'prescriptions')->name('prescription');
        Route::get('/prescriptions/private/{member}', 'privatePrescriptions')->name('private.prescription');
        Route::get('/prescriptions/mynote/{member}', 'myNote')->name('mynote');

        // Hauora Plan
        Route::group(['prefix' => 'hauora_plan', 'as' => 'hauora_plan.', 'controller' => HauoraPlanController::class], function () {
            Route::get('/{member}', 'index')->name('index');
            Route::get('/{member}/create', 'create')->name('create');
            Route::post('/store/{member}', 'store')->name('store');
            Route::get('/{hauora_plan}/edit', 'edit')->name('edit');
            Route::get('/{hauora_plan}/show', 'show')->name('show');
            Route::post('/{hauora_plan}/update', 'update')->name('update');
            Route::post('/{hauora_plan}/delete', 'destroy')->name('delete');
            Route::post('/{hauora_plan}/update-status', 'updateStatus')->name('update_status');
            Route::get('/{hauora_plan}/follow_up', 'followUp')->name('follow_up.create');
            Route::post('/{hauora_plan}/follow_up', 'followUpStore')->name('follow_up.store');
            Route::get('/follow_up/edit/{hauoraPlanDetail}', 'followUpEdit')->name('follow_up.edit');
            Route::post('/follow_up/update/{hauoraPlanDetail}', 'followUpUpdate')->name('follow_up.update');
        });

        // Client Alert
        Route::group(['prefix' => 'client_alert', 'as' => 'client_alert.', 'controller' => ClientAlertController::class], function () {
            Route::get('/{member}', 'index')->name('index');
            Route::post('/store/{member}', 'store')->name('store');
            Route::get('/{alert}/show', 'show')->name('show');
            Route::post('/{client_alert}/update', 'update')->name('update');
            Route::post('/{client_alert}/delete', 'destroy')->name('delete');
        });

        // Medication
        Route::group(['prefix' => 'medication', 'as' => 'medication.', 'controller' => MedicationController::class], function () {
            Route::get('/{member}', 'index')->name('index');
            Route::get('/{member}/create', 'create')->name('create');
            Route::post('/store/{member}', 'store')->name('store');
            Route::get('/{medication}/edit', 'edit')->name('edit');
            Route::get('/{medication}/show', 'show')->name('show');
            Route::post('/{medication}/update', 'update')->name('update');
            Route::post('/{medication}/delete', 'destroy')->name('delete');
        });

        // Immunization
        Route::group(['prefix' => 'immunization', 'as' => 'immunization.', 'controller' => ImmunizationController::class], function () {

            Route::get('/{member}', 'index')->name('index');
            Route::get('/{member}/create', 'create')->name('create');
            Route::post('/store/{member}', 'store')->name('store');
            Route::get('/{immunization}/edit', 'edit')->name('edit');
            Route::post('/{immunization}/update', 'update')->name('update');
            Route::get('/{immunization}/show', 'show')->name('show');
            Route::post('/{immunization}/delete', 'destroy')->name('delete');
            Route::get('/{immunization}/done', 'done')->name('done');
            Route::post('/{immunization}/status-update-api', 'statusUpdate')->name('status.update.api');
        });

        // Client Family Tree
        Route::group(['prefix' => 'family', 'as' => 'family.', 'controller' => ClientFamilyTreeController::class], function () {

            Route::get('/{user_id}', 'index')->name('index');
            Route::post('/store/{member}', 'store')->name('store');
            Route::get('/', 'familyTree')->name('list');
            Route::get('/{family}/edit', 'edit')->name('edit');
            Route::post('/{family}/update', 'update')->name('update');
        });

        // prescription
        Route::group(['prefix' => 'prescriptions', 'as' => 'prescription.', 'controller' => PrescriptionController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{member}/create', 'create')->name('create');
            Route::post('/store/{member}', 'store')->name('store');
            Route::get('/{prescription}/edit', 'edit')->name('edit');
            Route::get('/{prescription}/show', 'show')->name('show');
            Route::post('/{prescription}/update', 'update')->name('update');
            Route::post('/{prescription}/delete', 'destroy')->name('delete');
        });
    });
});
