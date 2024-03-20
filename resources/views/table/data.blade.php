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
@endsection

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            
            <x-page-header title="Lấy đơn thuốc" />
            
            <div class="pd-20 card-box mb-30">
                <form action="{{ route('render')}}">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Số điện thoại</label>
                        <div class="col-sm-8 col-md-8">
                            <input class="form-control @error('phone_number') form-control-danger @enderror" name="phone_number" @if (isset($phone_number)) value="{{$phone_number}}" @endif type="number" />
                            @error('phone_number')
                                <div class="form-control-feedback has-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <button type="submit" class="btn btn-primary">Lấy đơn thuốc</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Thông tin đơn thuốc khám bệnh</h4>
                </div>
                <div class="pb-20">
                    <table class="table hover multiple-select-row">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort" width="2%">STT</th>
                                <th>Họ tên bệnh nhân</th>
                                <th>Số điện thoại</th>
                                {{-- <th>Ngày sinh</th> --}}
                                <th>Địa chỉ</th>
                                {{-- <th>Giới tính</th> --}}
                                {{-- <th>Cân nặng</th> --}}
                                <th>mã đơn thuốc</th>
                                <th>hình thức điều trị</th>
                                <th>Ngày giờ kê đơn</th>
                                <th class="datatable-nosort">Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($medicines))
                            @foreach ($medicines as $key => $item)
                            <tr>
                                <td class="table-plus">{{$key +1}}</td>
                                <td>{{$item->ho_ten_benh_nhan ?? ''}}</td>
                                <td>{{$item->so_dien_thoai_nguoi_kham_benh ?? ''}}</td>
                                {{-- <td>{{$item->ngay_sinh_benh_nhan ?? ''}}</td> --}}
                                <td>{{$item->dia_chi ?? ''}}</td>
                                {{-- <td>{{$item->gioi_tinh ?? ''}}</td> --}}
                                {{-- <td>{{$item->can_nang ?? ''}}</td> --}}
                                <td>{{$item->ma_don_thuoc ?? ''}}</td>
                                <td>{{$item->hinh_thuc_dieu_tri ?? ''}}</td>
                                <td>{{$item->ngay_gio_ke_don ?? ''}}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="{{route('table.detail',['id' => $item->id])}}"><i class="dw dw-eye"></i> Chi tiết</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach    
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Simple Datatable End -->
            
            <!-- Export Datatable End -->
        </div>
        @include('layouts.bar.footer')
    </div>
</div>
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
    <script src="{{ asset('src/plugins/datatables/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/vfs_fonts.js') }}"></script>
    <!-- Datatable Setting js -->
    <script src="{{ asset('vendors/scripts/datatable-setting.js') }}"></script>
    <!-- Google Tag Manager (noscript) -->
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