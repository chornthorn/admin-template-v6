<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>61471022</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN WORKS</li>
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
           {{-- <li class="{{ Request::is('assets*') ? 'active' : '' }}">
                <a href="{{ route('assets.index') }}">
                    <i class="fa fa-list-alt"></i> <span>Asset Manager</span>
                </a>
            </li>--}}
            <li class="header">SETTINGS</li>
            @can('user.view')
            <li class="{{ Request::is('user*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-user-circle"></i> <span> Manager User</span>
                </a>
            </li>
            @endcan
            @can('role.view')
            <li class="{{ Request::is('role*') ? 'active' : '' }}">
                <a href="{{ url('/role') }}">
                    <i class="fa fa-user-circle"></i> <span> Role & Permission</span>
                </a>
            </li>
            @endcan
            <li class="header">LABELS</li>
            <li>
                <a onclick="logout()"><i class="fa fa-power-off text-red"></i> <span>Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    @method('POST')
                </form>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
