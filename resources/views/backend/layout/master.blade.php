@include('backend.layout.header')

    @include('backend.layout.sidebar')

    @include('backend.layout.message')

    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                    <li class="breadcrumb-item active">@yield('page')</li>
                                </ol>
                            </div>

                            <h4 class="mb-sm-0">@yield('page')</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                @yield('page-content')

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('backend.layout.footer')
