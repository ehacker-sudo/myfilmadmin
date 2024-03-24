<div
class="modal fade bs-example-modal-lg"
id="edit-key-api"
tabindex="-1"
role="dialog"
aria-labelledby="myLargeModalLabel"
aria-hidden="true"
>
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Sửa tài khoản API
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
        <form method="POST">
            @csrf
            <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-5 col-md-5">
                            <label class="col-form-label">Tên đơn vị</label>
                            <input id="unit_new_name" type="text" class="form-control" name="unit_new_name" value=""/>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Trạng thái</label>
                            <select
                                class="custom-select2 form-control"
                                name="new_state"
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
                            <input type="text" class="form-control" name="new_api_token" value="" style="padding-right: 0%;border-end-end-radius: 0;border-top-right-radius: 0"/>
                        </div>
                        <div class="col-sm-2 col-md-2" style="vertical-align: -96px;padding-left: 0%" >
                            <a onclick="createOtherToken()" class="btn btn-primary" style="margin-top: 38px;color:white;border-start-start-radius: 0;border-end-start-radius: 0;">
                                Tạo mã
                            </a>
                        </div>
                        <div class="col-sm-12 col-md-12">
                                <label class="col-form-label">Api name</label>
                                <input id="api_new_name" type="text" class="form-control" name="api_new_name" value="" style="width: 100%"/>
                        </div>
                        <div class="col-sm-12 col-md-12">
                                <label class="col-form-label">Token</label>
                                <input id="apinew_token" type="text" class="form-control" name="apinew_token" value="" style="width: 100%"/>
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
                <button type="submit" class="btn btn-primary">
                    Sửa
                </button>
            </div>
        </form>
    </div>
</div>
</div>


<script>
    function take_url_edit_key(key_id) {
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "POST",
            data:{
                'key_id': key_id
            },
            url: "{{ route('manager.key.api.id') }}",
            success: function (response) {
                $('form')[1].action = response.url;
                $("input[name=unit_new_name]").val(response.unit_name);
                $("input[name=api_new_name]").val(response.api_name);
                $("input[name=apinew_token]").val(response.api_token);
            }
        });  
    }

    function createOtherToken() {
        
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "POST",
            url: "{{ route('manager.create.access.token') }}",
            success: function (response) {
                $("input[name=new_api_token]").val(response.token);
            }
        });  
    }
</script>