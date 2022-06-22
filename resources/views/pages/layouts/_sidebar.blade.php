<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link {{ str_contains(url()->current(), '/data') ? 'c-active' : '' }}" href="{{ url('data') }}">
                <i class="c-sidebar-nav-icon fas fa-database fa-fw"></i> Data KTP
            </a>
        </li>
        @if(Auth::user()->role == 'admin')
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link {{ str_contains(url()->current(), '/import') ? 'c-active' : '' }}" href="{{ url('import') }}" href="{{ url('room') }}">
                <i class="c-sidebar-nav-icon fas fa-file-import fa-fw"></i> Impor
            </a>
        </li>
        <hr>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link {{ str_contains(url()->current(), '/log') ? 'c-active' : '' }}" href="{{ url('log') }}" href="{{ url('room') }}">
                <i class="c-sidebar-nav-icon fas fa-history fa-fw"></i> Log
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link {{ str_contains(url()->current(), '/user') ? 'c-active' : '' }}" href="{{ url('user') }}" href="{{ url('room') }}">
                <i class="c-sidebar-nav-icon fas fa-user fa-fw"></i> Pengguna
            </a>
        </li>
        @endif
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
