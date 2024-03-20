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
            
            <x-page-header title="Danh sách đơn thuốc" />

            <div class="pd-20 card-box mb-30">
                <form action="{{ route('table.search')}}">  
                    <div class="form-group row">
                        <div class="col-sm-4 col-md-4">
                            <label class="col-sm-12 col-md-12 col-form-label">Thành phố</label>
                            <div class="col-sm-12 col-md-10">
                                <select
                                class="custom-select2 form-control"
                                name="province"
                                style="width: 100%; height: 38px"
                                onchange="SelectDistrict(this);"
                                >
                                    <option value="">Chọn thành phố...</option>
                                    @foreach ($provinces as $item)
                                        @if ($thanhpho == $item->name)
                                            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <label class="col-sm-12 col-md-10 col-form-label">Quận</label>
                            <div class="col-sm-12 col-md-10 district">
                                <select
                                class="custom-select2 form-control"
                                name="district"
                                style="width: 100%; height: 38px"
                                onchange="SelectWard(this);"
                                {{ $disable_district }}
                                >
                                    <option value="">Chọn quận...</option>
                                    @if (isset($thanhpho))
                                        @if (isset($list_quan))
                                            @foreach ($list_quan as $item)
                                                @if ($item['name'] == $quan)
                                                <option value="{{ $item["id"] }}" selected>{{ $item["name"] }}</option>
                                                @else
                                                <option value="{{ $item["id"] }}">{{ $item["name"] }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <label class="col-sm-12 col-md-10 col-form-label">Phường/Xã</label>
                            <div class="col-sm-12 col-md-10 ward">
                                <select
                                class="custom-select2 form-control"
                                name="ward"
                                style="width: 100%; height: 38px"
                                {{ $disable_ward }}
                                >
                                    <option value="">Chọn phường/xã...</option>
                                    @if (isset($quan))
                                        @if (isset($list_phuongxa))
                                            @foreach ($list_phuongxa as $item)
                                                @if ($item['name'] == $phuongxa)
                                                <option value="{{ $item['id'] }}" selected>{{ $item['name'] }}</option>
                                                @else
                                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="col-sm-12 col-md-10" >
                                <br>
                                <button type="submit" class="btn btn-primary">TÌm kiếm</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4" style="color: #333">Thông tin đơn thuốc khám bệnh</h4>
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
                            @if (isset($get_dulieu_db))
                            @foreach ($get_dulieu_db as $key => $item)
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
    <script>
        function SelectDistrict(el){
            var type = $(el).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{ route('table.render.district') }}",
                type : 'POST',
                data : {
                    'type' : type
                },
                success : function(res) {
                    $('.district').html(res.html);
                    $('.ward').html(res.html2);
                }
            })
        }   
        function SelectWard(el){
            var type = $(el).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{ route('table.render.ward') }}",
                type : 'POST',
                data : {
                    'type' : type
                },
                success : function(res) {
                    $('.ward').html(res.html);
                }
            })
        }   
    </script>
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
    <!-- Google Tag Manager (noscript) -->
    <script src="{{ asset('vendors/scripts/datatable-setting.js') }}"></script>
    <noscript
        ><iframe
            src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS"
            height="0"
            width="0"
            style="display: none; visibility: hidden"
        ></iframe
    ></noscript>
    <!-- End Google Tag Manager (noscript) --
@endsection