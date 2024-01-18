@php
use App\Library\Helper;
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>


        @if(Helper::hasAuthRolePermission('employee_index'))
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#return" aria-expanded="false" aria-controls="tables">
                <i class="fa-solid fa-users menu-icon"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="return">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('employee_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.employee.index') }}">Employees</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if(false)
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-money-check-dollar menu-icon"></i>
                <span class="menu-title">Demo</span>
            </a>
        </li>
        @endif


        @if( Helper::hasAuthRolePermission('ticket_index') )
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.ticket.index') }}">
                <i class="far fa-envelope menu-icon"></i>
                <span class="menu-title">Tickets</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('menu_configuration') )
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                <i class="fas fa-cogs menu-icon"></i>
                <span class="menu-title">Settings</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('config_genaral_settings_show') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.general_settings.systemDetails') }}">General Settings</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('role_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.role.index') }}"> Manage Roles </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('config_dropdown_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.dropdown.menu') }}"> Dropdown List</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.more_settings.index') }}">More Settings</a>
                    </li>

                </ul>
            </div>
        </li>
        @endif

        
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#website" aria-expanded="false" aria-controls="website">
                <i class="fas fa-cogs menu-icon"></i>
                <span class="menu-title">Website</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="website">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('config_genaral_settings_show') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.general_settings.systemDetails') }}">Media</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('role_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.role.index') }}"> Job Post </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('config_dropdown_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.dropdown.menu') }}"> Contact Us</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.more_settings.index') }}">Subscriber</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.more_settings.index') }}">Brochure</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.more_settings.index') }}">Others</a>
                    </li>

                </ul>
            </div>
        </li>


        @if( Helper::hasAuthRolePermission('menu_footprint') )
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#footprints" aria-expanded="false"
                aria-controls="footprints">
                <i class="fas fa-shoe-prints menu-icon"></i>
                <span class="menu-title">Foot Print</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="footprints">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('log_login_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.log.login.index') }}">Login History</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('log_activity_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.log.activity.index') }}">Activity Logs</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('log_email_index') && false)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.log.email.index') }}">Email History</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('menu_report') && false)
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports">
                <i class="fa-solid fa-chart-line menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="reports">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('report_stock') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.report.stock') }}">Stock Reports</a>
                        </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('report_order') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.report.order', ['type' => \App\Library\Enum::ORDER_TYPE_PURCHASE]) }}">Purchase Reports</a>
                        </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('report_order') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.order', ['type' => \App\Library\Enum::ORDER_TYPE_SALE]) }}">Sale Reports</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('report_expense') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.expense') }}">Expense Reports</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('report_withdraw') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.withdraw') }}">Withdraw Reports</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('report_user') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.report.users') }}">User Reports</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>
