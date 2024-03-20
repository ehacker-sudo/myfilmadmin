<div
class="modal fade bs-example-modal-lg" 
id="edit-user" 
tabindex="-1"
role="dialog" 
aria-labelledby="myLargeModalLabel" 
aria-hidden="true"
>
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Sửa tài khoản người dùng
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
        <form id="edit-admin" method="POST" >
            @csrf
            <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" name="new_name" value="{{ old('name') }}"/>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Vai trò (trong nhóm)</label>
                            <select
                                class="custom-select2 form-control"
                                name="new_role"
                                style="width: 100%; height: 38px"
                            >
                                <option selected value="">--Chọn vai trò--</option>
                                <option value="1">Quản trị hệ thống</option>
                                <option value="2">Member</option> 
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Họ và tên</label>
                            <input type="text" class="form-control" name="new_fullname" value="{{ old('new_fullname') }}"/>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Email</label>
                            <input id="new_email" type="email" class="form-control" name="new_email" value="{{ old('email') }}"/>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Mật khẩu</label>
                            <input id="new_password" type="password" class="form-control" name="new_password"/>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="col-form-label">Nhập lại mật khẩu</label>
                            <input id="new-password-confirm" type="password" class="form-control" name="new_confirm_password" value=""/>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <br>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button
                    type="submit"
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
    function take_url_edit_user(user_id) {
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "POST",
            data: {
                "user_id" : user_id
            },
            url: "{{ route('manager.user.id') }}",
            success: function (response) {
                $("form")[1].action = response.url
            }
        }); 
    }
</script>