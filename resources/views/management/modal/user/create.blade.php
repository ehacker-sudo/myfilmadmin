                        <div
                            class="modal fade bs-example-modal-lg" 
                            id="add-user" 
                            tabindex="-1"
                            role="dialog" 
                            aria-labelledby="myLargeModalLabel" 
                            aria-hidden="true"
                        >
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">
                                            Thêm tài khoản người dùng
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
                                    <form id="create_user" method="POST" action="{{ route('manager.create.user') }}">
                                        @csrf
                                        <div class="modal-body">
                                                <div class="form-group row">
                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label">Tên đăng nhập</label>
                                                        <input id="name" type="text" class="form-control" name="name" value=""/>
                                                        <div class="form-control-feedback validate_name"></div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label">Vai trò (trong nhóm)</label>
                                                        <select
                                                            class="custom-select2 form-control"
                                                            name="role"
                                                            style="width: 100%; height: 38px"
                                                        >
                                                            <option selected value="">--Chọn vai trò--</option>
                                                            <option value="1">Quản trị hệ thống</option>
                                                            <option value="2">Member</option> 
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label">Họ và tên</label>
                                                        <input type="text" class="form-control" name="fullname"/>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label">Email</label>
                                                        <input id="email" type="email" class="form-control" name="email"/>
                                                        <div class="form-control-feedback validate_email"></div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label">Mật khẩu</label>
                                                        <input id="password" type="password" class="form-control" name="password"/>
                                                        <div class="form-control-feedback validate_password"></div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label">Nhập lại mật khẩu</label>
                                                        <input id="password-confirm" type="password" class="form-control" name="confirm_password"/>
                                                        <div class="form-control-feedback validate_confirm_password"></div>
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
                                            <a 
                                                href="#" 
                                                onclick="create_user()" 
                                                class="btn btn-primary"
                                            >
                                                Thêm
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>
                            function create_user() { 
                                $.ajax({
                                    headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                    type: "POST",
                                    data:{
                                        'name': $('input[name=name]')[0].value,
                                        'email': $('input[name=email]')[0].value,
                                        'password': $('input[name=password]')[0].value,
                                        'confirm_password': $('input[name=confirm_password]')[0].value
                                    },
                                    url: "{{ route('manager.create.user.request') }}",
                                    success: function (response) {
                                        if (response.status === "error") {
                                            for (const key in response.message) {
                                                if (key !== 'confirm_password') {
                                                    validate_(key, response.message[key])
                                                }
                                                else{
                                                    if (response.message.password === '') {
                                                        validate_(key, response.message[key])
                                                    }
                                                    else{
                                                        $(`input[name=${key}]`).removeClass("form-control-danger")
                                                        $(`.validate_${key}`).removeClass("has-danger")    
                                                        $(`input[name=${key}]`).removeClass("form-control-success")
                                                        $(`.validate_${key}`).removeClass("has-success") 
                                                    }
                                                }
                                            }
                                        }
                                        else if (response.status === "success") {
                                            $('form[id=create_user]')[0].submit();   
                                        }
                                        
                                    }
                                })
                            }

                            function validate_(key ,value) {
                                if (value === '') {
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
                                $(`.validate_${key}`).html(value) 
                            }
                        </script>