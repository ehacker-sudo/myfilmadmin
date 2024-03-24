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
			href="{{ asset('src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}"
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
                            <h4>Danh sách lịch sử xem</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="https://ytebox.vn">Trang chủ</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Danh sách lịch sử xem
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a
                            href="#"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#add-history"
                            type="button"
                        >
                            Thêm lịch sử xem
                        </a>    
                    </div>
                </div>
            </div>
            
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Thông tin lịch sử xem</h4>
                </div>
                <div class="pb-20">
                    <table class="table hover multiple-select-row">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort" width="2%">ID</th>
                                <th>Film_id</th>
                                <th>Season_id</th>
                                <th>Episode_id</th>
                                <th>Person_id</th>
                                <th>Media_Type</th>
                                <th>user_id</th>
                                <th>Thời gian tạo</th>
                                <th>Thời gian cập nhật</th>
                                <th class="datatable-nosort">Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($histories))
                            @foreach ($histories as $key => $item)
                                <tr>
                                    <td class="table-plus">{{$key +1}}</td>
                                    <td>{{$item->film_id ?? ''}}</td>
                                    <td>{{$item->season_id ?? ''}}</td>
                                    <td>{{$item->episode_id ?? ''}}</td>
                                    <td>{{$item->person_id ?? ''}}</td>
                                    <td>{{$item->media_type ?? ''}}</td>
                                    <td>{{$item->user_id ?? ''}}</td>
                                    <td>{{$item->created_at ?? ''}}</td>
                                    <td>{{$item->updated_at ?? ''}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a
                                                    onclick="take_url_edit_key('{{$item->_id}}')"
                                                    href="#"
                                                    class="dropdown-item"
                                                    data-toggle="modal"
                                                    data-target="#edit-rate"
                                                    type="button"
                                                >
                                                    <i class="dw dw-edit2"></i> Sửa tài khoản API
                                                </a>
                                                <a class="dropdown-item" href="{{route('manager.delete.history',['history' => $item->_id])}}"><i class="dw dw-delete-3"></i> Xóa tài khoản API</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr> 
                                {{-- @include('management.modal.history.edit') --}}
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
@include('management.modal.history.create')

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
    <script src="{{ asset('src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
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