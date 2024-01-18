<?php

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\SaleReturnController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\MemberProfileController;
use App\Http\Controllers\Admin\StockTransferController;
use App\Http\Controllers\Admin\EmailSignatureController;
use App\Http\Controllers\Admin\PurchaseReturnController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\EmergencyContactController;

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

Auth::routes();

Route::group(['middleware' => 'role:admin'], function () {

    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    Route::get('/dashboard', 'HomeController@dashboard')->name('home.dashboard');
    //cache
    Route::get('/cache/clear/fd', [CacheController::class, 'clear'])->name('clear.cache');

    // Users
    Route::group(['prefix' => 'users', 'as' => 'user.', 'controller' => UserController::class], function () {

        Route::post('/{user}/update-status-api', 'updateStatusApi')->name('update_status.api')->middleware('permission:user_update_status');
        Route::post('/{user}/update-password-api', 'updatePasswordApi')->name('update_password.api')->middleware('permission:user_update_password');
        Route::post('/{user}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:user_delete');
        Route::post('/{id}/restore-api', 'restoreApi')->name('restore.api')->middleware('permission:user_restore');
        Route::get('/{user}', 'show');
    });

    // Customer
    Route::group(['prefix' => 'customers', 'as' => 'member.', 'controller' => MemberController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:customer_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:customer_create');
        Route::post('/create', 'create')->name('store')->middleware('permission:customer_create');
        Route::get('/{user}/update', 'showUpdateForm')->name('update')->middleware(['permission:customer_update']);
        Route::post('/{user}/update', 'update')->middleware(['permission:customer_update']);
        Route::get('/{user}/show', 'show')->name('show');

        Route::group(['controller' => MemberProfileController::class], function () {
            Route::get('/{user}/show/details', 'showDetails')->name('show.details')->middleware('permission:customer_show');
            Route::get('/{user}/show/address', 'showAddress')->name('show.address')->middleware('permission:customer_show');
            Route::get('/{user}/show/contact', 'showContact')->name('show.contact')->middleware('permission:customer_show');
        });

        Route::group(['controller' => OrderController::class], function () {
            Route::get('/{user}/orders', 'customerOrders')->name('order')->middleware('permission:order_index');
            Route::get('/order/{order}/details', 'showCustomerOrder')->name('order.show')->middleware('permission:order_show');
        });
    });

    Route::group(['prefix' => '{user_type}', 'as' => 'user.'], function () {
        // User Edit Address
        Route::group(['prefix' => 'address', 'as' => 'address.', 'controller' => AddressController::class], function () {
            Route::post('/create', 'store')->name('create');
            Route::post('/{address}/update', 'update')->name('update');
        });
    });

    // Employees
    Route::group(['prefix' => 'employees', 'as' => 'employee.', 'controller' => EmployeeController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:employee_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:employee_create');
        Route::post('/create', 'create')->middleware('permission:employee_create');
        Route::get('/{employee}/update', 'showUpdateForm')->name('update')->middleware('permission:employee_update');
        Route::post('/{employee}/update', 'update')->middleware('permission:employee_update');
        Route::post('/{employee}/security/update', 'securityUpdate')->name('security.update')->middleware('permission:employee_update');
        Route::get('/{employee}/show', 'show')->name('show')->middleware('permission:employee_show');

        Route::get('/{employee}/tickets', 'ticketIndex')->name('ticketIndex')->middleware('permission:ticket_index');
        Route::post('/{assign}/stock/accept', 'acceptStock')->name('accept_stock')->middleware(['permission:employee_update']);
        Route::post('{stock}/stock/status/change', 'stockStatusChange')->name('stock_status_change')->middleware(['permission:employee_update']);

        // Attachment
        Route::group(['prefix' => 'attachment', 'as' => 'attachment.', 'controller' => AttachmentController::class], function () {
            Route::get('/{employee}', 'index')->name('index')->middleware('permission:attachment_index');
            Route::get('/create/{employee}', 'create')->middleware('permission:attachment_create');
            Route::post('/store/{employee}', 'store')->name('store')->middleware('permission:attachment_create');
            Route::get('/{attachment}/edit', 'edit')->name('edit')->middleware('permission:attachment_update');
            Route::post('/{attachment}/update', 'update')->name('update')->middleware('permission:attachment_update');
            Route::post('/{attachment}/delete', 'destroy')->name('delete')->middleware('permission:attachment_delete');
        });
    });

    // Emergency Contact
    Route::group(['prefix' => 'emergency', 'as' => 'emergency.', 'controller' => EmergencyContactController::class], function () {

        Route::get('/{user}/create', 'showCreateForm')->name('create')->middleware('permission:emergency_contact_create');
        Route::post('/{user}/create', 'create')->middleware('permission:emergency_contact_create');
        Route::get('/{emergency}/update', 'showUpdateForm')->name('update')->middleware('permission:emergency_contact_update');
        Route::post('/{emergency}/update', 'update')->middleware('permission:emergency_contact_update');
        Route::post('/{emergency}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:emergency_contact_delete');
    });

    // Logins & Activities
    Route::group(['prefix' => 'logs', 'as' => 'log.', 'controller' => LogController::class], function () {

        Route::get('/logins', 'loginIndex')->name('login.index')->middleware('permission:log_login_index');
        Route::post('/{login}/delete-api', 'deleteLoginApi')->name('delete_login.api')->middleware('permission:log_delete_login');

        Route::get('/activity', 'activityIndex')->name('activity.index')->middleware('permission:log_activity_index');
        Route::get('/activity/{activity}/show', 'activityShow')->name('activity.show')->middleware('permission:log_activity_show');
        Route::post('/activity/{activity}/delete', 'deleteActivity')->name('activity.delete')->middleware('permission:log_activity_delete');

        Route::get('/emails', 'emailIndex')->name('email.index')->middleware('permission:log_email_index');
        Route::get('/emails/{email}/show', 'emailShow')->name('email.show')->middleware('permission:log_email_show');
        Route::post('/emails/{email}/delete', 'deleteEmail')->name('email.delete')->middleware('permission:log_email_delete');
    });

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'controller' => ProfileController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:profile_index');
        Route::get('/update', 'showUpdateForm')->name('update')->middleware('permission:profile_update');
        Route::post('/update', 'update')->middleware('permission:profile_update');
        Route::get('/update-password', 'showUpdatePasswordForm')->name('update_password')->middleware('permission:profile_update_password');
        Route::post('/update-password', 'updatePassword')->middleware('permission:profile_update_password');
        Route::get('/notification/all', 'showAllNotifications')->name('notification')->middleware('permission:profile_all_notification');
    });

    // Tickets
    Route::group(['prefix' => 'tickets', 'as' => 'ticket.', 'controller' => TicketController::class], function () {

        Route::get('/my-tickets', 'index')->name('index')->middleware('permission:ticket_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:ticket_create');
        Route::post('/create', 'create')->middleware('permission:ticket_create');
        Route::get('/{ticket}/update', 'showUpdateForm')->name('update')->middleware('permission:profile_update');
        Route::post('/{ticket}/update', 'update')->middleware('permission:profile_update');
        Route::get('/{ticket}/show', 'show')->name('show')->middleware('permission:ticket_show');
        Route::post('/{ticket}/reply', 'reply')->name('reply')->middleware('permission:ticket_reply');
        Route::post('/{ticket}/assignee', 'changeAssignee')->name('assignee')->middleware('permission:ticket_assignee');
        Route::post('/{ticket}/change-status', 'changeStatus')->name('change_status')->middleware('permission:ticket_change_status');
        Route::get('/{ticket}/reopen', 'reOpen')->name('reopen')->middleware('permission:ticket_reopen');

        Route::get('/all-tickets', 'allTickets')->name('all')->middleware('permission:ticket_index');
    });

    // Config
    Route::group(['prefix' => 'configs', 'as' => 'config.', 'controller' => ConfigController::class], function () {

        // Roles & Permissions
        Route::group(['prefix' => 'roles', 'as' => 'role.', 'controller' => RoleController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:role_index');
            Route::get('/{role}/show-api', 'showApi')->name('show.api')->middleware('permission:role_show');
            Route::post('/create', 'createApi')->name('create.api')->middleware('permission:role_create');
            Route::post('/{role}/update-api', 'updateApi')->name('update.api')->middleware('permission:role_update');
            Route::post('/{role}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:role_delete');
            Route::get('/{role}/permissions', 'permissions')->name('permission')->middleware('permission:role_permission');
            Route::post('/{role}/permissions/update', 'updatePermissions')->name('permission.update')->middleware('permission:role_permission_update');
        });

        // Dropdowns
        Route::group(['prefix' => 'dropdowns', 'as' => 'dropdown.'], function () {
            Route::get('/', 'dropdownMenu')->name('menu')->middleware('permission:config_dropdown_menu');
            Route::get('/{dropdown}', 'dropdowns')->name('index')->middleware('permission:config_dropdown_index');
            Route::post('/{dropdown}/create-api', 'createDropdownApi')->name('create.api')->middleware('permission:config_dropdown_create');
            Route::post('/{dropdown}/{id}/update-api', 'updateDropdownApi')->name('update.api')->middleware('permission:config_dropdown_update');
            Route::post('/{dropdown}/{id}/delete-api', 'deleteDropdownApi')->name('delete.api')->middleware('permission:config_dropdown_delete');
        });

        Route::group(['prefix' => 'general-settings', 'as' => 'general_settings.', 'controller' => GeneralSettingsController::class], function () {
            Route::get('/system-details', 'systemDetails')->name('systemDetails')->middleware('permission:config_genaral_settings_show');
            Route::get('/address', 'address')->name('address')->middleware('permission:config_genaral_settings_show');
            Route::get('/communication', 'communication')->name('communication')->middleware('permission:config_genaral_settings_show');
            Route::get('/multimedia', 'multimedia')->name('multimedia')->middleware('permission:config_genaral_settings_show');
            Route::get('/date-time', 'date_time')->name('date_time')->middleware('permission:config_genaral_settings_show');
            Route::get('/currency', 'currency')->name('currency')->middleware('permission:config_genaral_settings_show');
            Route::get('/pos-settings', 'posSettings')->name('pos_settings')->middleware('permission:config_genaral_settings_show');

            Route::post('/update', 'updateGeneralSettings')->name('update')->middleware('permission:config_genaral_settings_update');
        });

        Route::group(['prefix' => 'more-settings', 'as' => 'more_settings.', 'controller' => ConfigController::class], function () {
            Route::get('/', 'moreSettings')->name('index');
            Route::get('/email-settings', 'emailSettings')->name('email.settings')->middleware('permission:config_email_settings_show');
            Route::post('/update-email-settings', 'updateEmailSettings')->name('email.settings.update')->middleware('permission:config_email_settings_update');
            Route::post('/send-test-email', 'sendTestMail')->name('send.test.email')->middleware('permission:config_email_settings_show');
            Route::get('/social-link', 'socialLink')->name('social.link')->middleware('permission:config_social_link_show');
            Route::post('/social-link', 'updateSocialLink')->name('social.link.update')->middleware('permission:config_social_link_update');

            // Location
            Route::group(['prefix' => 'location', 'as' => 'location.', 'controller' => LocationController::class], function () {
                Route::get('/', 'index')->name('index')->middleware('permission:config_location_index');
                Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:config_location_create');
                Route::post('/create', 'create')->middleware('permission:config_location_create');
                Route::get('/{location}/update', 'showUpdateForm')->name('update')->middleware('permission:config_location_update');
                Route::post('/{location}/update', 'update')->middleware('permission:config_location_update');
                Route::get('/{location}/show', 'show')->middleware('permission:config_location_show');
                Route::post('/{location}/delete', 'delete')->name('delete')->middleware('permission:config_location_delete');
            });

            // Email templates
            Route::group(['prefix' => 'email-templates', 'as' => 'email_template.'], function () {
                Route::get('/', 'emailTemplates')->name('index')->middleware('permission:config_email_template_index');
                Route::get('/{email_template}/update', 'updateEmailTemplateForm')->name('update')->middleware('permission:config_email_templete_update');
                Route::post('/{email_template}/update', 'updateEmailTemplate')->middleware('permission:config_email_templete_update');
            });

            // Email Signature
            Route::group(['prefix' => 'email-signature', 'as' => 'email_signature.', 'controller' => EmailSignatureController::class], function () {
                Route::get('/', 'index')->name('index')->middleware('permission:config_email_signature_index');
                Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:config_email_signature_create');
                Route::post('/create', 'create')->middleware('permission:config_email_signature_create');
                Route::get('/{emailSignature}/update', 'showUpdateForm')->name('update')->middleware('permission:config_email_signature_update');
                Route::post('/{emailSignature}/update', 'update')->middleware('permission:config_email_signature_update');
                Route::get('/{emailSignature}/show-api', 'show')->name('show')->middleware('permission:config_email_signature_show');
                Route::post('/{emailSignature}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:config_email_signature_delete');
            });


            // Discount
            Route::group(['prefix' => 'discount', 'as' => 'discount.', 'controller' => DiscountController::class], function () {
                Route::get('/', 'index')->name('index')->middleware('permission:config_discount_index');
                Route::get('/create', 'create')->name('create')->middleware('permission:config_discount_create');
                Route::post('/create', 'store')->middleware('permission:config_discount_create');
                Route::get('/{discount}/update', 'edit')->name('update')->middleware('permission:config_discount_update');
                Route::post('/{discount}/update', 'update')->middleware('permission:config_discount_update');
                Route::post('/{discount}/delete', 'delete')->name('delete')->middleware('permission:config_discount_delete');
                Route::post('/{discount}/status-change', 'changeStatus')->name('change_status')->middleware('permission:config_discount_change_status');
            });
        });
    });

    // Notifications
    Route::group(['prefix' => 'notifications', 'as' => 'notification.', 'controller' => NotificationController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:notification_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:notification_create');
        Route::post('/create', 'create')->middleware('permission:notification_create');
        Route::get('/{notification}/show', 'show')->name('show')->middleware('permission:notification_index');
        Route::post('/{notification}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:notification_delete');
        Route::get('/{notification}/recipients', 'recipients')->name('recipients')->middleware('permission:notification_index');
        Route::post('/{recipient}/resend-api', 'resend')->name('resend.api')->middleware('permission:notification_index');
    });

    // Category
    Route::group(['prefix' => 'category', 'as' => 'category.', 'controller' => CategoryController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:category_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:category_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:category_create');
        Route::get('/{category}/edit', 'edit')->name('edit')->middleware('permission:category_update');
        Route::post('/{category}/update', 'update')->name('update')->middleware('permission:category_update');
        Route::get('/{category}/delete', 'destroy')->name('delete')->middleware('permission:category_delete');
        Route::post('/{category}/status-change', 'changeStatus')->name('change_status')->middleware('permission:category_status');
    });

    // Supplier
    Route::group(['prefix' => 'supplier', 'as' => 'supplier.', 'controller' => SupplierController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:supplier_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:supplier_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:supplier_create');
        Route::get('/{supplier}/edit', 'edit')->name('edit')->middleware('permission:supplier_update');
        Route::post('/{supplier}/update', 'update')->name('update')->middleware('permission:supplier_update');
        Route::get('/{supplier}/delete', 'destroy')->name('delete')->middleware('permission:supplier_delete');
        Route::post('/{supplier}/status-change', 'changeStatus')->name('change_status')->middleware('permission:supplier_status');
    });

    // Product
    Route::group(['prefix' => 'product', 'as' => 'product.', 'controller' => ProductController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:product_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:product_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:product_create');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:product_update');
        Route::post('/{product}/update', 'update')->name('update')->middleware('permission:product_update');
        Route::post('/{product}/delete', 'destroy')->name('delete')->middleware('permission:product_delete');
        Route::get('/{product}/show', 'show')->name('show')->middleware('permission:product_show');
        Route::post('/{product}/status-change', 'changeStatus')->name('change_status')->middleware('permission:product_status');
        Route::post('/{product}/feature-change', 'changeFeature')->name('change_feature')->middleware('permission:product_status');
    });

    // Stock
    Route::group(['prefix' => 'stocks', 'as' => 'stock.', 'controller' => StockController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:stock_index');
        Route::post('/supplier', 'getSupplier')->name('supplier')->middleware('permission:stock_create');
        Route::get('/create', 'create')->name('create')->middleware('permission:stock_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:stock_create');
        Route::get('/{stock}/edit', 'edit')->name('edit')->middleware('permission:stock_update');
        Route::post('/{stock}/update', 'update')->name('update')->middleware('permission:stock_update');
        Route::post('/{stock}/delete', 'destroy')->name('delete')->middleware('permission:stock_delete');
        Route::get('/{stock}', 'showApi');
        Route::get('/{stock}/show', 'show')->name('show')->middleware('permission:stock_show');
        Route::post('/{stock}/change-status', 'changeStatus')->name('change_status')->middleware('permission:stock_change_status');
        Route::get('/by/{location}', 'getStockByLocation');

        Route::get('/{stock}/history', 'history')->name('history')->middleware('permission:stock_show');
    });

    // Stock Transfer
    Route::group(['prefix' => 'stock-transfer', 'as' => 'stock_transfer.', 'controller' => StockTransferController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:stock_transfer_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:stock_transfer_create');
        Route::get('/get-stock/{branchId}', 'getStock')->name('get_stock')->middleware('permission:stock_transfer_create');

        Route::post('/store', 'store')->name('store')->middleware('permission:stock_transfer_create');
        Route::get('/{stock_transfer}/edit', 'edit')->name('edit')->middleware('permission:stock_transfer_update');
        Route::post('/{stock_transfer}/update', 'update')->name('update')->middleware('permission:stock_transfer_update');
        Route::get('/{stock_transfer}/delete', 'destroy')->name('delete')->middleware('permission:stock_transfer_delete');
        Route::post('/{stock_transfer}/status-change', 'changeStatus')->name('change_status')->middleware('permission:stock_transfer_status');
        // Route::post('/get-stock', 'getStock')->name('get_stock')->middleware('permission:stock_transfer_status');
    });

    // Order
    Route::group(['prefix' => 'order', 'as' => 'order.', 'controller' => OrderController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:order_index');
        Route::get('/{order}/show', 'show')->name('show')->middleware('permission:order_show');
        Route::get('/{order}/update', 'showUpdateForm')->name('update')->middleware('permission:order_update');
        Route::post('/{order}/update', 'update')->middleware('permission:order_update');
        Route::post('/{order}/pay', 'pay')->name('pay')->middleware('permission:order_update');
        Route::post('/{order}/status-change', 'changeStatus')->name('change_status')->middleware('permission:order_update');

        Route::get('/{order}/invoice/view', 'invoiceView')->name('invoice.view')->middleware('permission:order_invoice');
        Route::get('/{order}/invoice/download', 'invoiceDownload')->name('invoice.download')->middleware('permission:order_invoice');
    });

    // Report
    Route::group(['prefix' => 'report', 'as' => 'report.', 'controller' => ReportController::class], function () {
        Route::get('/stock', 'stock')->name('stock')->middleware('permission:report_stock');
        Route::get('/{type}/order', 'order')->name('order')->middleware('permission:report_order');
        Route::get('/expense', 'expense')->name('expense')->middleware('permission:report_expense');
        Route::get('/withdraw', 'withdraw')->name('withdraw')->middleware('permission:report_withdraw');
        Route::get('/users', 'users')->name('users')->middleware('permission:report_user');
    });

    // Branch
    Route::group(['prefix' => 'branches', 'as' => 'branch.', 'controller' => BranchController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:branch_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:branch_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:branch_create');
        Route::get('/{branch}/edit', 'edit')->name('edit')->middleware('permission:branch_update');
        Route::post('/{branch}/update', 'update')->name('update')->middleware('permission:branch_update');
        Route::post('/{branch}/delete', 'destroy')->name('delete')->middleware('permission:branch_delete');
        Route::post('/{branch}/status-change', 'changeStatus')->name('change_status')->middleware('permission:branch_status');
        Route::get('/{branch}/show', 'show')->name('show')->middleware('permission:branch_show');

        Route::post('/{branch}/employee', 'branchEmployee')->name('employee')->middleware('permission:branch_employee_create');
        Route::get('/employee/{employeeBranch}/edit', 'editBranchEmployee')->name('editBranchEmployee')->middleware('permission:branch_employee_update');
        Route::post('/employee/{employeeBranch}/update', 'updateBranchEmployee')->name('editBranchEmployee')->middleware('permission:branch_employee_update');
        Route::post('/employee/{employeeBranch}/delete', 'destroyBranchEmployee')->name('deleteBranchEmployee')->middleware('permission:branch_employee_delete');
    });

    // Expense
    Route::group(['prefix' => 'expenses', 'as' => 'expense.', 'controller' => ExpenseController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:expense_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:expense_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:expense_create');
        Route::get('/{expense}/edit', 'edit')->name('edit')->middleware('permission:expense_update');
        Route::post('/{expense}/update', 'update')->name('update')->middleware('permission:expense_update');
        Route::post('/{expense}/delete', 'destroy')->name('delete')->middleware('permission:expense_delete');
    });

    //============== POS Module Start ==================//
    Route::group(['prefix' => 'pos', 'as' => 'pos.', 'controller' => PosController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:pos_index');
        Route::get('/initial-data', 'getInitialData')->middleware('permission:pos_index');
        Route::get('/stocks', 'getStocks')->middleware('permission:pos_index');
        Route::get('/customers', 'getCustomers')->middleware('permission:pos_index');
        Route::post('/customer', 'storeCustomer')->middleware('permission:pos_index');
        Route::post('/order', 'placeOrder')->middleware('permission:pos_index');
    });

    // Order
    Route::group(['prefix' => 'order', 'as' => 'order.', 'controller' => OrderController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:order_index');
        Route::get('/{order}/show', 'show')->name('show')->middleware('permission:order_show');
        Route::get('/{order}/update', 'showUpdateForm')->name('update')->middleware('permission:order_update');
        Route::post('/{order}/update', 'update')->middleware('permission:order_update');
        Route::post('/{order}/pay', 'pay')->name('pay')->middleware('permission:order_update');
        Route::post('/{order}/status-change', 'changeStatus')->name('change_status')->middleware('permission:order_update');

        Route::get('/{order}/invoice/view', 'invoiceView')->name('invoice.view')->middleware('permission:order_show');
        Route::get('/{order}/invoice/download', 'invoiceDownload')->name('invoice.download')->middleware('permission:order_show');
    });

    //Purchase
    Route::group(['prefix' => 'purchase', 'as' => 'purchase.', 'controller' => PurchaseController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:purchase_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:purchase_create');
        Route::post('/create', 'create')->middleware('permission:purchase_create');
        Route::get('/{order}/update', 'showUpdateForm')->name('update')->middleware('permission:purchase_update');
        Route::post('/{order}/update', 'update')->middleware('permission:purchase_update');
        Route::get('/{order}/show', 'show')->name('show')->middleware('permission:purchase_show');

        Route::get('/{order}/invoice/view', 'invoiceView')->name('invoice.view')->middleware('permission:purchase_show');
        Route::get('/{order}/invoice/download', 'invoiceDownload')->name('invoice.download')->middleware('permission:purchase_show');
    });

    //Quotations
    Route::group(['prefix' => 'quotations', 'as' => 'quotation.', 'controller' => QuotationController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:order_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:order_index');
        Route::post('/create', 'create')->middleware('permission:order_index');
        Route::get('/{order}/show', 'show')->name('show')->middleware('permission:order_show');
        Route::get('/{order}/update', 'showUpdateForm')->name('update')->middleware('permission:order_update');
        Route::post('/{order}/update', 'update')->middleware('permission:order_update');
        Route::post('/{order}/make/order', 'makeOrder')->name('make.order')->middleware('permission:order_update');
        Route::post('/{order}/status-change', 'changeStatus')->name('change_status')->middleware('permission:order_update');

        Route::get('/{order}/invoice/view', 'invoiceView')->name('invoice.view')->middleware('permission:order_show');
        Route::get('/{order}/invoice/download', 'invoiceDownload')->name('invoice.download')->middleware('permission:order_show');
    });

    // Return Module
    Route::group(['prefix' => 'returns', 'as' => 'return.'], function () {

        // Sale Return
        Route::group(['prefix' => 'sale', 'as' => 'sale.', 'controller' => SaleReturnController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:return_sale_index');
            Route::post('/get', 'getSale')->name('get')->middleware('permission:return_sale_create');
            Route::get('/{order}/create', 'showCreateForm')->name('create')->middleware('permission:return_sale_create');
            Route::post('/{order}/create', 'create')->middleware('permission:return_sale_create');
            Route::get('/{order_return}/show', 'show')->name('show')->middleware('permission:return_purchase_show');

            Route::get('/{order}/update', 'showUpdateForm')->name('update')->middleware('permission:return_sale_update');
            Route::post('/{order}/update', 'update')->middleware('permission:return_sale_update');
        });

        // Purchase Return
        Route::group(['prefix' => 'purchase', 'as' => 'purchase.', 'controller' => PurchaseReturnController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:return_purchase_index');
            Route::get('/{order}/create', 'showCreateForm')->name('create')->middleware('permission:return_purchase_create');
            Route::post('/{order}/create', 'create')->middleware('permission:return_purchase_create');
            Route::post('/get/purchase', 'getPurchase')->name('getPurchase')->middleware('permission:return_purchase_create');
            Route::get('/{order}/update', 'showUpdateForm')->name('update')->middleware('permission:return_purchase_update');
            Route::post('/{order}/update', 'update')->middleware('permission:return_purchase_update');
            Route::get('/{order_return}/show', 'show')->name('show')->middleware('permission:return_purchase_show');
        });
    });

    // Withdraws
    Route::group(['prefix' => 'withdraws', 'as' => 'withdraw.', 'controller' => WithdrawController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:withdraw_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:withdraw_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:withdraw_create');
        Route::get('/{withdraw}/edit', 'edit')->name('edit')->middleware('permission:withdraw_update');
        Route::post('/{withdraw}/update', 'update')->name('update')->middleware('permission:withdraw_update');
        Route::get('/{withdraw}/delete', 'destroy')->name('delete')->middleware('permission:withdraw_delete');
        Route::post('/{withdraw}/status-change', 'changeStatus')->name('change_status')->middleware('permission:withdraw_status');
    });
});
