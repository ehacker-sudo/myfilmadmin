@extends('layouts.app')

@section('css')
        <link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css')}}"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css')}}"
		/>
        <link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/sweetalert2/sweetalert2.css') }}"
		/>
@endsection

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Danh sách người dùng</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="https://ytebox.vn">Trang chủ</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Danh sách người dùng 
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a 
                            href="#" 
                            class="btn btn-primary" 
                            data-toggle="modal" 
                            data-target="#add-user" 
                            type="button" 
                        > 
                            Thêm người dùng 
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Thông tin tài khoản người dùng</h4>
                </div>
                <div class="pb-20">
                    <table class="table hover multiple-select-row">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort" width="2%">STT</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Vai trò - Vị trí</th>
                                <th>Tên đăng nhập</th>
                                <th>Đăng nhập lần cuối</th>
                                <th class="datatable-nosort">Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($user))
                            @foreach ($user as $key => $item)
                            <tr>
                                <td class="table-plus">{{$key +1}}</td>
                                <td>{{$item->fullname ?? ''}}</td>
                                <td>{{$item->email ?? ''}}</td>
                                <td>{{$role[$item->role] ?? ''}}</td>
                                <td>{{$item->name ?? ''}}</td>
                                <td>{{$item->last_login_time ?? ''}}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a
                                                onclick="take_url_edit_user('{{$item->_id}}')"
                                                href="#"
                                                class="dropdown-item"
                                                data-toggle="modal"
                                                data-target="#edit-user"
                                                type="button"
                                            >
                                                <i class="dw dw-edit2"></i> Sửa người dùng
                                            </a>
                                            <a class="dropdown-item" href="{{route('manager.delete.user',['user' => $item->_id])}}"><i class="dw dw-delete-3"></i> Xóa người dùng</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @include('management.modal.user.edit')
                            @endforeach    
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        @include('layouts.bar.footer')
    </div>
</div>
<!-- modals-->
@include('management.modal.user.create')

@endsection

@section('script')
    <!-- js -->
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- buttons for Export datatable -->
    <script src="{{ asset('src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/vfs_fonts.js') }}"></script>

    <script src="{{ asset('vendors/scripts/datatable-setting.js') }}"></script>

    <script src="{{ asset('src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('src/plugins/sweetalert2/sweet-alert.init.js') }}"></script>
    <noscript
        ><iframe
            src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS"
            height="0"
            width="0"
            style="display: none; visibility: hidden"
        ></iframe
    ></noscript>
    <!-- End Google Tag Manager (noscript) -->
@endsection