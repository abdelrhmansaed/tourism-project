<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">

            @if (auth('admin')->check())
                @include('Dashboard.layouts.main-sidebar.admin-main-sidebar')
            @endif

            @if (auth('agent')->check())
                @include('Dashboard.layouts.main-sidebar.agent-main-sidebar')
            @endif

            @if (auth('provider')->check())
                @include('Dashboard.layouts.main-sidebar.provider-main-sidebar')
            @endif

		</aside>
<!-- main-sidebar -->
