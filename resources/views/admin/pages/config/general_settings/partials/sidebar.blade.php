@php
    use App\Library\Helper;
    $urlArray = url()->full();
    $segments = explode('/', $urlArray);
    $numSegments = count($segments);
    $currentSegment = $segments[$numSegments - 1];
@endphp

<div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 pb-4">
    <!-- SideBar Start -->
    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="nav nav-tabss nav-tabs-vertical" role="tablist">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'system-details' ? 'active' : ''}}"
                        href="{{ route('admin.config.general_settings.systemDetails') }}">
                        <i class="fa-solid fa-border-all ms-2 mr-1"></i> System Details
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'address' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.address') }}">
                        <i class="fa-solid fa-location-dot"></i> Address
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'communication' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.communication') }}">
                        <i class="fa-solid fa-paper-plane"></i> Communication
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'multimedia' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.multimedia') }}">
                        <i class="fa-solid fa-images"></i> Multimedia
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'date-time' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.date_time') }}">
                        <i class="fa-solid fa-calendar-days"></i> Date & Time
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ $currentSegment === 'currency' ? 'active' : ''}}"
                    href="{{ route('admin.config.general_settings.currency') }}">
                        <i class="fa-solid fa-coins"></i> Currency
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <!-- Sidebar End -->
</div>
