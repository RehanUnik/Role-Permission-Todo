<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{route('dashboard')}}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('roles')}}">
                <i class="icon-columns menu-icon fa-solid fa-lock"></i>
                <span class="menu-title">Roles</span>
                <i class="mdi mdi-account"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('users')}}">
                <i class="icon-columns menu-icon fa-solid fa-user"></i>
                <span class="menu-title">Users</span>
                <i class="menu-calendar"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('projects')}}">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Projects</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('tasks')}}">
                <i class="icon-grid-2 menu-icon fa-solid fa-list-check"></i>
                <span class="menu-title">Tasks</span>
            </a>
        </li>

    </ul>
</nav>