<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        <!-- <img src="{{ asset("/images/logo.png") }}"
             alt="AdminLTE Logo"
             class="brand-image elevation-3 w-75"> -->
        <span class="brand-text font-weight-light">TTH Admin</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
