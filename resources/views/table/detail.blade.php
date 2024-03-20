@extends('layouts.app')

@section('css')
{{-- <link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css')}}"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css')}}"
		/> --}}
@endsection

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            
            <x-page-header title="Chi Tiết" />

            <div class="pd-20 card-box mb-30">
                <form>
                    <div class="form-group row">
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Họ tên bệnh nhân</label>
                            <input class="form-control" name="phone_number" value="{{ $get_dulieu_db->ho_ten_benh_nhan ?? '' }}" disabled />
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Số điện thoại</label>
                            <input class="form-control" name="phone_number" value="{{ $get_dulieu_db->so_dien_thoai_nguoi_kham_benh }}" disabled />
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Mã đơn thuốc</label>
                            <input class="form-control" name="phone_number" value="{{ $get_dulieu_db->ma_don_thuoc ?? '' }}" disabled />
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Ngày giờ lấy đơn</label>
                            <input class="form-control" name="phone_number" value="{{ $get_dulieu_db->created_at ?? '' }}" disabled />
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <br>
                            {{-- <a href="{{ route('table.data') }}" class="btn btn-primary">Quay lại</button> --}}
                        </div>
                    </div>
                </form>
            </div>
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Cơ sở khám chữa bệnh</h4>
                </div>
                <div class="pb-20">
                    <table class="data-table table hover multiple-select-row nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th>Tên bác sĩ</th>
                                <th>Tên cơ sơ </th>
                                <th>Địa chỉ</th>
                                <th>Mã bảo hiểm</th>
                                <th>Số điện thoại</th>
                                <th>Ngày giờ kê đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ $get_dulieu_db->ten_bac_si ?? ''}}</td>
                                <td>{{ $get_dulieu_db->ten_co_so_kham_chua_benh ?? ''}}</td>
                                <td>{{ $get_dulieu_db->dia_chi_co_so_kham_chua_benh ?? ''}}</td>
                                <td>{{ $get_dulieu_db->ma_bao_hiem_co_so_kham_chua_benh ?? ''}}</td>
                                <td>{{ $get_dulieu_db->so_dien_thoai ?? ''}}</td>
                                <td>{{ $get_dulieu_db->ngay_gio_ke_don ?? ''}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Simple Datatable End -->
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Thông tin thuốc</h4>
                </div>
                <div class="pb-20">
                    <table class="data-table table hover multiple-select-row nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th>Mã thuốc</th>
                                <th>Biệt dược</th>
                                <th>Tên thuốc</th>
                                <th>Đơn vị tính</th>
                                <th>Cách dùng</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($get_dulieu_db->thong_tin_don_thuoc as $key => $item)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{ $item['ma_thuoc'] ?? ''}}</td>
                                <td>{{ $item['biet_duoc'] ?? ''}}</td>
                                <td>{{ $item['ten_thuoc'] ?? ''}}</td>
                                <td>{{ $item['don_vi_tinh'] ?? ''}}</td>
                                <td>{{ $item['cach_dung'] ?? ''}}</td>
                                <td>{{ $item['so_luong'] ?? ''}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Simple Datatable End -->

            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Chẩn đoán</h4>
                </div>
                <div class="pb-20">
                    <table class="data-table table hover multiple-select-row nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th>Mã chẩn đoán</th>
                                <th>Tên chẩn đoán</th>
                                <th>Kết luận</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($get_dulieu_db->chan_doan as $key => $item)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{ $item['ma_chan_doan'] ?? ''}}</td>
                                <td>{{ $item['ten_chan_doan'] ?? ''}}</td>
                                <td>{{ $item['ket_luan'] ?? ''}}</td>
                                <td>@if (is_string($get_dulieu_db->chan_doan[0]) && isset($get_dulieu_db->chan_doan[0]))
                                    {{ $get_dulieu_db->chan_doan[0]  }}
                                @endif</td>
                            </tr>
                            @endforeach
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