@php
    use App\Library\Helper;
@endphp

@extends('admin.layouts.master')

@section('title', 'More Settings')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('More Settings' )) }}</h4>
        </div>
    </div>
    <div class="card shadow-sm col-md-12">
        <div class="card-body">

            <div class="row">

                @if( Helper::hasAuthRolePermission('config_social_link_show') )
                <div class="col-lg-3 col-md-6 col-sm-6 m-b30 pt-4">
                    <div class="rounded-team">
                        <a href="{{ route('admin.config.more_settings.social.link') }}">
                            <div class="round-box bg-light2-secondary">
                                <div class="team-mamber">
                                    <div class="team-mamber">
                                    <i class="fa-sharp fa-solid fa-link"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="border-1 team-info text-center p-4 p-t40">
                            <h4 class="dlab-title" style="padding-top: 15px">
                                <b> <a href="{{ route('admin.config.more_settings.social.link') }}" style="color:black">Social Link</a></b>
                            </h4>
                        </div>
                    </div>
                </div>
                @endif

                @if( Helper::hasAuthRolePermission('config_email_settings_show') )
                <div class="col-lg-3 col-md-6 col-sm-6 m-b30 pt-4">
                    <div class="rounded-team">
                        <a href="{{ route('admin.config.more_settings.email.settings') }}">
                            <div class="round-box bg-light2-secondary">
                                <div class="team-mamber">
                                    <div class="team-mamber">
                                        <i class="fa-solid fa-envelope-circle-check"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="border-1 team-info text-center p-4 p-t40">
                            <h4 class="dlab-title" style="padding-top: 15px">
                                <b> <a href="{{ route('admin.config.more_settings.email.settings') }}" style="color:black">Email Settings</a></b>
                            </h4>
                        </div>
                    </div>
                </div>
                @endif

                @if( Helper::hasAuthRolePermission('config_email_template_index') )
                <div class="col-lg-3 col-md-6 col-sm-6 m-b30 pt-4">
                    <div class="rounded-team">
                        <a href="{{ route('admin.config.more_settings.email_template.index') }}">
                            <div class="round-box bg-light2-secondary">
                                <div class="team-mamber">
                                    <div class="team-mamber">
                                    <i class="fa-solid fa-envelope-open-text"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="border-1 team-info text-center p-4 p-t40">
                            <h4 class="dlab-title" style="padding-top: 15px">
                                <b> <a href="{{ route('admin.config.more_settings.email_template.index') }}" style="color:black">Email Templates</a></b>
                            </h4>
                        </div>
                    </div>
                </div>
                @endif

                @if( Helper::hasAuthRolePermission('config_email_signature_index') )
                <div class="col-lg-3 col-md-6 col-sm-6 m-b30 pt-4">
                    <div class="rounded-team">
                        <a href="{{ route('admin.config.more_settings.email_signature.index') }}">
                            <div class="round-box bg-light2-secondary">
                                <div class="team-mamber">
                                    <div class="team-mamber">
                                    <i class="fa-solid fa-signature"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="border-1 team-info text-center p-4 p-t40">
                            <h4 class="dlab-title" style="padding-top: 15px">
                                <b> <a href="{{ route('admin.config.more_settings.email_signature.index') }}" style="color:black">Email Signature</a></b>
                            </h4>
                        </div>
                    </div>
                </div>
                @endif

                @if( Helper::hasAuthRolePermission('config_location_index') )
                <div class="col-lg-3 col-md-6 col-sm-6 m-b30 pt-4">
                    <div class="rounded-team">
                        <a href="{{ route('admin.config.more_settings.location.index') }}">
                            <div class="round-box bg-light2-secondary">
                                <div class="team-mamber">
                                    <div class="team-mamber">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="border-1 team-info text-center p-4 p-t40">
                            <h4 class="dlab-title" style="padding-top: 15px">
                                <b> <a href="{{ route('admin.config.more_settings.location.index') }}" style="color:black">Location and IP settings</a></b>
                            </h4>
                        </div>
                    </div>
                </div>
                @endif

                @if( Helper::hasAuthRolePermission('team_index') && false)
                <div class="col-lg-3 col-md-6 col-sm-6 m-b30 pt-4">
                    <div class="rounded-team">
                        <a href="{{ route('admin.team.index') }}">
                            <div class="round-box bg-light2-secondary">
                                <div class="team-mamber">
                                    <div class="team-mamber">
                                        <i class="fa-solid fa-people-group"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="border-1 team-info text-center p-4 p-t40">
                            <h4 class="dlab-title" style="padding-top: 15px">
                                <b> <a href="{{ route('admin.team.index') }}" style="color:black">Team</a></b>
                            </h4>
                        </div>
                    </div>
                </div>
                @endif

                @if( Helper::hasAuthRolePermission('team_chart') && false)
                <div class="col-lg-3 col-md-6 col-sm-6 m-b30 pt-4">
                    <div class="rounded-team">
                        <a href="{{ route('admin.team.chart') }}">
                            <div class="round-box bg-light2-secondary">
                                <div class="team-mamber">
                                    <div class="team-mamber">
                                        <i class="fa-solid fa-people-group"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="border-1 team-info text-center p-4 p-t40">
                            <h4 class="dlab-title" style="padding-top: 15px">
                                <b> <a href="{{ route('admin.team.chart') }}" style="color:black">Organisational Chart</a></b>
                            </h4>
                        </div>
                    </div>
                </div>
                @endif
                
                @if( Helper::hasAuthRolePermission('menu_notifications') && false)
                <div class="col-lg-3 col-md-6 col-sm-6 m-b30 pt-4">
                    <div class="rounded-team">
                        <a href="{{ route('admin.notification.index') }}">
                            <div class="round-box bg-light2-secondary">
                                <div class="team-mamber">
                                    <div class="team-mamber">
                                        <i class="fa-regular fa-bell"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="border-1 team-info text-center p-4 p-t40">
                            <h4 class="dlab-title" style="padding-top: 15px">
                                <b> <a href="{{ route('admin.notification.index') }}" style="color:black">Notifications</a></b>
                            </h4>
                        </div>
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</div>
@stop

@push('scripts')

@endpush
