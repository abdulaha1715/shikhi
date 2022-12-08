
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index-2.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('./backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('./backend/assets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index-2.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('./backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('./backend/assets/images/logo-light.png') }}" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('dashboard.*') ? 'active' : ''}}" href="{{ route('dashboard') }}" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboards</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('course.*') ? 'active' : ''}}"   href="#courseLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="courseLayouts">
                                <i class="mdi mdi-view-carousel-outline"></i> <span data-key="t-layouts">Courses</span>
                            </a>
                            <div class="collapse menu-dropdown {{ request()->routeIs('course.*') ? 'show' : ''}}" id="courseLayouts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('course.index') }}" class="nav-link {{ request()->routeIs('course.index') ? 'active' : ''}}" target="" data-key="t-horizontal">View All</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('course.create') }}" class="nav-link {{ request()->routeIs('course.create') ? 'active' : ''}}" target="" data-key="t-two-column">Create Course</a>
                                    </li>
                                </ul>
                            </div>
                        </li> <!-- end Course Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('category.*') ? 'active' : ''}}" href="{{ route('category.index') }}" role="button">
                                <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-apps">Category</span>
                            </a>
                        </li> <!-- end Category Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('tag.*') ? 'active' : ''}}" href="{{ route('tag.index') }}" role="button">
                                <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-apps">Tag</span>
                            </a>
                        </li> <!-- end Tag Menu -->

                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('profile.*') ? 'active' : ''}}" href="{{ route( 'profile.show', auth()->id() ) }}" role="button">
                                <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-apps">User</span>
                            </a>
                        </li> <!-- end User Menu -->

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                                <i class="mdi mdi-view-carousel-outline"></i> <span data-key="t-layouts">Settings</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="layouts-horizontal.html" class="nav-link" target="_blank" data-key="t-horizontal">Horizontal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="layouts-detached.html" class="nav-link" target="_blank" data-key="t-detached">Detached</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="layouts-two-column.html" class="nav-link" target="_blank" data-key="t-two-column">Two Column</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="layouts-vertical-hovered.html" class="nav-link" target="_blank" data-key="t-hovered">Hovered</a>
                                    </li>
                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
