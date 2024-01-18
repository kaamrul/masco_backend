<?php

namespace Database\Seeders\SystemData;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public const GROUP_USER = 'user';
    public const GROUP_NOTIFICATION = 'notification';
    public const GROUP_EMP = 'employee';
    public const GROUP_TICKET = 'ticket';
    public const GROUP_LOG = 'log';
    public const GROUP_ROLE = 'role';
    public const GROUP_PROFILE = 'profile';
    public const GROUP_EMERGENCY_CONTACT = 'emergency_contact';
    public const GROUP_ATTACHMENT = 'attachment';
    public const GROUP_EMPLOYEE_DETAILS = 'employee_details';
    public const GROUP_REPORT = 'report';
    public const GROUP_MENU = 'menu';
    public const GROUP_CONFIG = 'config';

    public function run()
    {
        Permission::whereNotNull('id')->delete();

        $admin_role = Role::where('slug', 'super-admin')->first();
        $admin_user = User::where('email', config('app.admin_email'))->first();

        foreach ($this->permissions() as $p) {
            $permission = new Permission();
            $permission->name = $p['name'];
            $permission->slug = $p['slug'];
            $permission->group = $p['group'];
            $permission->save();

            if ($admin_role) {
                $admin_role->permissions()->attach($permission);
            }

            if ($admin_user) {
                $admin_user->permissions()->attach($permission);
            }
        }
    }

    private function permissions()
    {
        return [

            // Common permission for User (Employee/Member)
            [
                'name'  => 'Update Status',
                'slug'  => self::GROUP_USER . '_update_status',
                'group' => self::GROUP_USER
            ],
            [
                'name'  => 'Update Password',
                'slug'  => self::GROUP_USER . '_update_password',
                'group' => self::GROUP_USER
            ],
            [
                'name'  => 'Delete',
                'slug'  => self::GROUP_USER . '_delete',
                'group' => self::GROUP_USER
            ],
            [
                'name'  => 'Restore',
                'slug'  => self::GROUP_USER . '_restore',
                'group' => self::GROUP_USER
            ],

            //notification
            // [
            //     'name'  => 'List',
            //     'slug'  => self::GROUP_NOTIFICATION . '_index',
            //     'group' => self::GROUP_NOTIFICATION
            // ],
            // [
            //     'name'  => 'Create',
            //     'slug'  => self::GROUP_NOTIFICATION . '_create',
            //     'group' => self::GROUP_NOTIFICATION
            // ],
            // [
            //     'name'  => 'Delete',
            //     'slug'  => self::GROUP_NOTIFICATION . '_delete',
            //     'group' => self::GROUP_NOTIFICATION
            // ],

            //========== permission for (Employee/Member/Supplier) ===========//
            //Employee
            [
                'name'  => 'List',
                'slug'  => self::GROUP_EMP . '_index',
                'group' => self::GROUP_EMP
            ],
            [
                'name'  => 'Create',
                'slug'  => self::GROUP_EMP . '_create',
                'group' => self::GROUP_EMP
            ],
            [
                'name'  => 'Update',
                'slug'  => self::GROUP_EMP . '_update',
                'group' => self::GROUP_EMP
            ],
            [
                'name'  => 'View',
                'slug'  => self::GROUP_EMP . '_show',
                'group' => self::GROUP_EMP
            ],

            //Profile
            [
                'name'  => 'View',
                'slug'  => self::GROUP_PROFILE . '_index',
                'group' => self::GROUP_PROFILE
            ],
            [
                'name'  => 'Update',
                'slug'  => self::GROUP_PROFILE . '_update',
                'group' => self::GROUP_PROFILE
            ],
            [
                'name'  => 'Update Password',
                'slug'  => self::GROUP_PROFILE . '_update_password',
                'group' => self::GROUP_PROFILE
            ],
            // [
            //     'name'  => 'All Notification',
            //     'slug'  => self::GROUP_PROFILE . '_all_notification',
            //     'group' => self::GROUP_PROFILE
            // ],

            // Attachment
            [
                'name'  => 'List',
                'slug'  => self::GROUP_ATTACHMENT . '_index',
                'group' => self::GROUP_ATTACHMENT
            ],
            [
                'name'  => 'Create',
                'slug'  => self::GROUP_ATTACHMENT . '_create',
                'group' => self::GROUP_ATTACHMENT
            ],
            [
                'name'  => 'Update',
                'slug'  => self::GROUP_ATTACHMENT . '_update',
                'group' => self::GROUP_ATTACHMENT
            ],
            // [
            //     'name'  => 'Delete',
            //     'slug'  => self::GROUP_ATTACHMENT . '_delete',
            //     'group' => self::GROUP_ATTACHMENT
            // ],
            [
                'name'  => 'View',
                'slug'  => self::GROUP_ATTACHMENT . '_show',
                'group' => self::GROUP_ATTACHMENT
            ],

            //Emergency Contact
            [
                'name'  => 'List',
                'slug'  => self::GROUP_EMERGENCY_CONTACT . '_index',
                'group' => self::GROUP_EMERGENCY_CONTACT
            ],
            [
                'name'  => 'Create',
                'slug'  => self::GROUP_EMERGENCY_CONTACT . '_create',
                'group' => self::GROUP_EMERGENCY_CONTACT
            ],
            [
                'name'  => 'Update',
                'slug'  => self::GROUP_EMERGENCY_CONTACT . '_update',
                'group' => self::GROUP_EMERGENCY_CONTACT
            ],
            [
                'name'  => 'View',
                'slug'  => self::GROUP_EMERGENCY_CONTACT . '_show',
                'group' => self::GROUP_EMERGENCY_CONTACT
            ],
            [
                'name'  => 'Delete',
                'slug'  => self::GROUP_EMERGENCY_CONTACT . '_delete',
                'group' => self::GROUP_EMERGENCY_CONTACT
            ],

            // Employee Details
            // [
            //     'name'  => 'Attendance List',
            //     'slug'  => self::GROUP_EMPLOYEE_DETAILS . '_attendance_list',
            //     'group' => self::GROUP_EMPLOYEE_DETAILS
            // ],
            [
                'name'  => 'Details',
                'slug'  => self::GROUP_EMPLOYEE_DETAILS . '_index',
                'group' => self::GROUP_EMPLOYEE_DETAILS
            ],
            [
                'name'  => 'Security',
                'slug'  => self::GROUP_EMPLOYEE_DETAILS . '_security',
                'group' => self::GROUP_EMPLOYEE_DETAILS
            ],

            //========== End permission for (Employee/Member/Supplier) ===========//

            // Ticket
            [
                'name'  => 'List',
                'slug'  => self::GROUP_TICKET . '_index',
                'group' => self::GROUP_TICKET
            ],
            [
                'name'  => 'Create',
                'slug'  => self::GROUP_TICKET . '_create',
                'group' => self::GROUP_TICKET
            ],
            [
                'name'  => 'View',
                'slug'  => self::GROUP_TICKET . '_show',
                'group' => self::GROUP_TICKET
            ],
            [
                'name'  => 'Reply',
                'slug'  => self::GROUP_TICKET . '_reply',
                'group' => self::GROUP_TICKET
            ],
            [
                'name'  => 'Assignee',
                'slug'  => self::GROUP_TICKET . '_assignee',
                'group' => self::GROUP_TICKET
            ],
            [
                'name'  => 'Change Status',
                'slug'  => self::GROUP_TICKET . '_change_status',
                'group' => self::GROUP_TICKET
            ],
            [
                'name'  => 'Re-Open',
                'slug'  => self::GROUP_TICKET . '_reopen',
                'group' => self::GROUP_TICKET
            ],
            [
                'name'  => 'My Ticket Menu',
                'slug'  => self::GROUP_TICKET . '_my_ticket',
                'group' => self::GROUP_TICKET
            ],
            [
                'name'  => 'All Ticket Menu',
                'slug'  => self::GROUP_TICKET . '_all_ticket',
                'group' => self::GROUP_TICKET
            ],
            
            // Report
            [
                'name'  => 'Stock Report',
                'slug'  => self::GROUP_REPORT . '_stock',
                'group' => self::GROUP_REPORT
            ],
            [
                'name'  => 'Purchase/Sale Report',
                'slug'  => self::GROUP_REPORT . '_order',
                'group' => self::GROUP_REPORT
            ],
            [
                'name'  => 'Expense Report',
                'slug'  => self::GROUP_REPORT . '_expense',
                'group' => self::GROUP_REPORT
            ],
            [
                'name'  => 'Withdraw Report',
                'slug'  => self::GROUP_REPORT . '_withdraw',
                'group' => self::GROUP_REPORT
            ],
            [
                'name'  => 'User Report',
                'slug'  => self::GROUP_REPORT . '_user',
                'group' => self::GROUP_REPORT
            ],

            // Menu
            // [
            //     'name'  => 'Notifications',
            //     'slug'  => self::GROUP_MENU . '_notifications',
            //     'group' => self::GROUP_MENU
            // ],
            [
                'name'  => 'Employees',
                'slug'  => self::GROUP_MENU . '_employees',
                'group' => self::GROUP_MENU
            ],
            // [
            //     'name'  => 'Tickets',
            //     'slug'  => self::GROUP_MENU . '_tickets',
            //     'group' => self::GROUP_MENU
            // ],
            [
                'name'  => 'Configuration',
                'slug'  => self::GROUP_MENU . '_configuration',
                'group' => self::GROUP_MENU
            ],
            [
                'name'  => 'Footprint',
                'slug'  => self::GROUP_MENU . '_footprint',
                'group' => self::GROUP_MENU
            ],
            [
                'name'  => 'Report',
                'slug'  => self::GROUP_MENU . '_report',
                'group' => self::GROUP_MENU
            ],

            //Log
            [
                'name'  => 'Footprint Menu',
                'slug'  => self::GROUP_LOG . '_footprint_menu',
                'group' => self::GROUP_LOG
            ],
            [
                'name'  => 'Login List',
                'slug'  => self::GROUP_LOG . '_login_index',
                'group' => self::GROUP_LOG
            ],
            [
                'name'  => 'Login Delete',
                'slug'  => self::GROUP_LOG . '_delete_login',
                'group' => self::GROUP_LOG
            ],
            [
                'name'  => 'Activity List',
                'slug'  => self::GROUP_LOG . '_activity_index',
                'group' => self::GROUP_LOG
            ],
            [
                'name'  => 'Activity View',
                'slug'  => self::GROUP_LOG . '_activity_show',
                'group' => self::GROUP_LOG
            ],
            // [
            //     'name'  => 'Activity Delete',
            //     'slug'  => self::GROUP_LOG . '_activity_delete',
            //     'group' => self::GROUP_LOG
            // ],
            [
                'name'  => 'Email List',
                'slug'  => self::GROUP_LOG . '_email_index',
                'group' => self::GROUP_LOG
            ],
            [
                'name'  => 'Email View',
                'slug'  => self::GROUP_LOG . '_email_show',
                'group' => self::GROUP_LOG
            ],
            // [
            //     'name'  => 'Email Delete',
            //     'slug'  => self::GROUP_LOG . '_email_delete',
            //     'group' => self::GROUP_LOG
            // ],

            //================== Config Group Start =====================//
            // Role Permissions
            [
                'name'  => 'List',
                'slug'  => self::GROUP_ROLE . '_index',
                'group' => self::GROUP_ROLE
            ],
            [
                'name'  => 'Create',
                'slug'  => self::GROUP_ROLE . '_create',
                'group' => self::GROUP_ROLE
            ],
            [
                'name'  => 'View',
                'slug'  => self::GROUP_ROLE . '_show',
                'group' => self::GROUP_ROLE
            ],
            [
                'name'  => 'Update',
                'slug'  => self::GROUP_ROLE . '_update',
                'group' => self::GROUP_ROLE
            ],
            [
                'name'  => 'Delete',
                'slug'  => self::GROUP_ROLE . '_delete',
                'group' => self::GROUP_ROLE
            ],
            [
                'name'  => 'Permission',
                'slug'  => self::GROUP_ROLE . '_permission',
                'group' => self::GROUP_ROLE
            ],
            [
                'name'  => 'Permission Update',
                'slug'  => self::GROUP_ROLE . '_permission_update',
                'group' => self::GROUP_ROLE
            ],

            // Dropdown
            [
                'name'  => 'Menu List',
                'slug'  => self::GROUP_CONFIG . '_dropdown_menu',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Dropdown List',
                'slug'  => self::GROUP_CONFIG . '_dropdown_index',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Create Dropdown',
                'slug'  => self::GROUP_CONFIG . '_dropdown_create',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Update Dropdown',
                'slug'  => self::GROUP_CONFIG . '_dropdown_update',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Delete Dropdown',
                'slug'  => self::GROUP_CONFIG . '_dropdown_delete',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Genaral Settings View',
                'slug'  => self::GROUP_CONFIG . '_genaral_settings_show',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Genaral Settings Update',
                'slug'  => self::GROUP_CONFIG . '_genaral_settings_update',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Settings View',
                'slug'  => self::GROUP_CONFIG . '_email_settings_show',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Settings Update',
                'slug'  => self::GROUP_CONFIG . '_email_settings_update',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Template List',
                'slug'  => self::GROUP_CONFIG . '_email_template_index',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Template View',
                'slug'  => self::GROUP_CONFIG . '_email_template_show',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Template Update',
                'slug'  => self::GROUP_CONFIG . '_email_templete_update',
                'group' => self::GROUP_CONFIG
            ],

            //Email Signature
            [
                'name'  => 'Email Signature List',
                'slug'  => self::GROUP_CONFIG . '_email_signature_index',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Signature Create',
                'slug'  => self::GROUP_CONFIG . '_email_signature_create',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Signature View',
                'slug'  => self::GROUP_CONFIG . '_email_signature_show',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Signature Update',
                'slug'  => self::GROUP_CONFIG . '_email_signature_update',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Email Signature Delete',
                'slug'  => self::GROUP_CONFIG . '_email_signature_delete',
                'group' => self::GROUP_CONFIG
            ],
            //End

            [
                'name'  => 'Social Link View',
                'slug'  => self::GROUP_CONFIG . '_social_link_show',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Social Link Update',
                'slug'  => self::GROUP_CONFIG . '_social_link_update',
                'group' => self::GROUP_CONFIG
            ],

            // Location
            [
                'name'  => 'Location List',
                'slug'  => self::GROUP_CONFIG . '_location_index',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Location Create',
                'slug'  => self::GROUP_CONFIG . '_location_create',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Location View',
                'slug'  => self::GROUP_CONFIG . '_location_show',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Location Update',
                'slug'  => self::GROUP_CONFIG . '_location_update',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Location Delete',
                'slug'  => self::GROUP_CONFIG . '_location_delete',
                'group' => self::GROUP_CONFIG
            ],

            // Discount
            [
                'name'  => 'Discount List',
                'slug'  => self::GROUP_CONFIG . '_discount_index',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Discount Create',
                'slug'  => self::GROUP_CONFIG . '_discount_create',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Discount Update',
                'slug'  => self::GROUP_CONFIG . '_discount_update',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Discount Change Status',
                'slug'  => self::GROUP_CONFIG . '_discount_change_status',
                'group' => self::GROUP_CONFIG
            ],
            [
                'name'  => 'Discount Delete',
                'slug'  => self::GROUP_CONFIG . '_discount_delete',
                'group' => self::GROUP_CONFIG
            ],

            // Config Group End
        ];
    }
}
