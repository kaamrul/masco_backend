@extends('admin.layouts.master')

@section('title', __('New Notification'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">

        {!! \App\Library\Html::linkBack(route('admin.notification.index')) !!}

        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Notification')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.notification.create') }}" enctype="multipart/form-data"
                id="notificationCreateForm">
                @csrf
                <div class="row">
                    <div class="col-xxl-6 col-lg-6 col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label required">{{ __('Member Type') }} </label>
                            <div class="col-sm-9">
                                <div class="d-inline-flex justify-content-start">
                                    <div class="form-check form-check-secondary mr-5">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input user-type-radio"
                                                name="member_type" value="1" required
                                                {{ (!old('member_type') || old('member_type') == '1') ? 'checked' : '' }}>
                                            General
                                            <i class="input-helper"></i></label>
                                    </div>

                                    <div class="form-check form-check-secondary ">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input user-type-radio"
                                                name="member_type" value="2" required
                                                {{ old('member_type') == '2' ? 'checked' : '' }}>
                                            Tournament
                                            <i class="input-helper"></i></label>
                                    </div>

                                    @error('member_type')
                                    <p class="error-message text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div
                            class="form-group member-select row @error('user_type') error @enderror general @if(old('member_type') == 2) d-none @endif">

                            <p class="warning-text col-md-12">
                                Select Any One From User Type or User Status
                            </p>

                            <label class="col-sm-3 col-form-label">{{ __('User Type') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="user_type[]" id="user_type" multiple>
                                    @foreach($user_types as $key => $user_type)
                                    <option value="{{ $key }}" {{(old("user_type") == $key) ? "selected" : ""}}>
                                        {{ $user_type }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_type')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="form-group member-select row @error('user_status') error @enderror general @if(old('member_type') == 2) d-none @endif">
                            <label class="col-sm-3 col-form-label">{{ __('User Status') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="user_status[]" id="user_status" multiple>
                                    @foreach($user_status as $key => $status)
                                    <option value="{{ $key }}" {{(old("user_status") == $key) ? "selected" : ""}}>
                                        {{ $status }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_status')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="form-group member-select row @error('tournament') error @enderror tournament @if(old('member_type') != 2) d-none @endif">
                            <label class="col-sm-3 col-form-label required">{{ __('Tournament') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="tournament[]" id="tournament" multiple>
                                    @foreach($tournaments as $key => $tournament)
                                    <option value="{{ $tournament->id }}"
                                        {{ collect(old('tournament'))->contains($tournament->id) ? 'selected' : '' }}>
                                        {{ $tournament->tournament_name }} - {{ $tournament->tournament_uid }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('tournament')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('subject') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Subject') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="subject" value="{{ old('subject') }}"
                                    placeholder="{{ __('Notification Subject') }}" required>
                                @error('subject')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('send_date') error @enderror">
                            <label class="col-sm-3 col-form-label">{{ __('Send Date') }}</label>
                            <div class="col-sm-9">

                                <div class="input-group with-icon">
                                    <input type="text" class="form-control datetimepicker-min-today" name="send_date"
                                        value="{{ old('send_date') }}"
                                        placeholder="{{ settings('date_format') }}">
                                    <i class="date-icon fa-solid fa-calendar-days"></i>
                                </div>

                                @error('send_date')
                                <p class="error-message">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-6 col-lg-6 col-md-12">
                        <div class="form-group row @error('message') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Message') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="exampleTextarea1" name="message" rows="5"
                                    placeholder="Notification Message" required>{{ old('message') }}</textarea>
                                @error('message')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-footer text-center">
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>

            </form>
        </div>
    </div>
</div>
@stop
@include('admin.assets.summernote-text-editor')
@include('admin.assets.datetimepicker')
@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/notification/create.js')
@endpush
