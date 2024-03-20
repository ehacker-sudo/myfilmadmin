<div
    class="modal fade bs-example-modal-lg"
    id="add-key-api"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Thêm tài khoản API
                </h4>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-hidden="true"
                >
                    ×
                </button>
            </div>
            <form id="create_key_api_token" method="POST" action="{{ route('manager.create.token') }}">
                @csrf
                <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-5 col-md-5">
                                <label class="col-form-label">Tên đơn vị</label>
                                <input id="unit_name" type="text" class="form-control" name="unit_name" value=""/>
                                <div class="form-control-feedback validate_unit_name"></div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="col-form-label">Trạng thái</label>
                                <select
                                    class="custom-select2 form-control"
                                    name="state"
                                    style="width: 100%; height: 38px"
                                >
                                    <option value="">--Chọn trạng thái--</option>
                                    <option selected value="1">Kích hoat</option>
                                    <option value="2">Hủy kích hoat</option>
                                </select>
                            </div>                     
                            <div class="col-sm-12 col-md-12">
                                <label>IPs</label>
                                <select
                                    class="custom-select2 form-control"
                                    multiple="multiple"
                                    style="width: 100%"
                                    name="ips"
                                >
                                    <option value="AK">IPs 1</option>
                                    <option value="HI">IPs 2</option>
                                </select>
                            </div>
                            <div class="col-sm-10 col-md-10" style="padding-right: 0%">
                                <label class="col-form-label">Mã truy cập</label>
                                <input type="text" class="form-control" name="api_token" value="" style="padding-right: 0%;border-end-end-radius: 0;border-top-right-radius: 0"/>
                            </div>
                            <div class="col-sm-2 col-md-2" style="vertical-align: -96px;padding-left: 0%" >
                                <a onclick="createToken()" class="btn btn-primary" style="margin-top: 38px;color:white;border-start-start-radius: 0;border-end-start-radius: 0;">
                                    Tạo mã
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="col-form-label">Api name</label>
                                <input type="text" class="form-control" name="api_name" value="" style="width: 100%"/>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="col-form-label">Token</label>
                                <input type="text" class="form-control" name="apitoken" value="" style="width: 100%"/>
                            </div>
                            <div class="col-12">
                                <div class="form-control-feedback validate_api_token"></div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Quay lại
                    </button>
                    <a 
                        href="#" 
                        onclick="createApiTokenAccount()" 
                        class="btn btn-primary">
                        Thêm
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function createToken() {
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "POST",
            url: "{{ route('manager.create.access.token') }}",
            success: function (response) {
                $("input[name=api_token]").val(response.token);
                $('input[name=api_token]').removeClass("form-control-danger")
                $('.validate_api_token').removeClass("has-danger") 
                $('input[name=api_token]').addClass("form-control-success")
                $('.validate_api_token').addClass("has-success")
                $(`.validate_api_token`).html('') 
            }
        });  
    }

    function createApiTokenAccount() { 
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "POST",
            data:{
                'unit_name': $('input[name=unit_name]')[0].value,
                'api_token': $('input[name=api_token]')[0].value,
            },
            url: "{{ route('manager.create.token.request') }}",
            success: function (response) {
                if (response.status === "error") {
                    for (const key in response.message) {
                        if (response.message[key] === '') {
                            $(`input[name=${key}]`).removeClass("form-control-danger")
                            $(`.validate_${key}`).removeClass("has-danger") 
                            $(`input[name=${key}]`).addClass("form-control-success")
                            $(`.validate_${key}`).addClass("has-success")         
                        }
                        else{
                            $(`input[name=${key}]`).addClass("form-control-danger")
                            $(`.validate_${key}`).addClass("has-danger")    
                            $(`input[name=${key}]`).removeClass("form-control-success")
                            $(`.validate_${key}`).removeClass("has-success") 
                        }
                        $(`.validate_${key}`).html(response.message[key]) 
                    }
                }
                else if (response.status === "success") {
                    $('form[id=create_key_api_token]')[0].submit();   
                }
                
            }
        })
    }
</script>
