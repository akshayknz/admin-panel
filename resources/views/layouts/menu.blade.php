<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link @if(Route::is('home')) active @endif">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>
@if(auth()->user()->can('user management') || auth()->user()->can('role management'))
<li class="nav-item @if(Route::is('users') || Route::is('roles')) active menu-open @endif">
    <a href="#" class="nav-link @if(Route::is('users') || Route::is('roles')) active @endif">
        <i class="nav-icon fas fa-users"></i>
        <p>
            User Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    @can('user management')
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('users') }}" class="nav-link @if(Route::is('users')) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
            </a>
        </li>
    </ul>
    @endcan
    @can('role management')
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('roles') }}" class="nav-link @if(Route::is('roles')) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Roles and Permissions</p>
            </a>
        </li>
    </ul>
    @endcan
</li>
@endif
