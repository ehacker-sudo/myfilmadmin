<div
    class="modal fade bs-example-modal-lg"
    id="add-comment"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Thêm bình luận
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
            <form id="create_comment" method="POST" action="{{ route('manager.comment.store') }}">
                @csrf
                <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-6">
                                <label class="col-form-label">Mã film</label>
                                <input id="film_id" type="number" class="form-control" name="film_id" value=""/>
                                <div class="form-control-feedback validate_film_id"></div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="col-form-label">Mã mùa</label>
                                <input id="season_id" type="number" class="form-control" name="season_id" value=""/>
                                <div class="form-control-feedback validate_season_id"></div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="col-form-label">Mã tập</label>
                                <input id="episode_id" type="number" class="form-control" name="episode_id" value=""/>
                                <div class="form-control-feedback validate_episode_id"></div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="col-form-label">Kiểu phim</label>
                                <select
                                    class="custom-select2 form-control"
                                    name="media_type"
                                    style="width: 100%; height: 38px"
                                >
                                    <option value="">-- Chọn kiểu phim --</option>
                                    <option value="movie">movie</option>
                                    <option value="tv">tv</option>
                                    <option value="episode">episode</option>
                                </select>
                                <div class="form-control-feedback validate_media_type"></div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="col-form-label">Nội dung</label>
                                <textarea name="content" class="form-control"></textarea>
                                <div class="form-control-feedback validate_content"></div>
                            </div> 
                            <div class="col-sm-6 col-md-6">
                                <label class="col-form-label">Người dùng</label>
                                <select
                                    class="custom-select2 form-control"
                                    name="user_id"
                                    style="width: 100%; height: 38px"
                                >
                                    <option value="">-- Chọn người dùng --</option>
                                    @foreach (App\Models\User::all() as $item)
                                    <option value="{{ $item->_id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-feedback validate_user_id"></div>
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
                        onclick="createRate()" 
                        class="btn btn-primary">
                        Thêm
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function createRate() { 
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "POST",
            data:{
                'film_id': $('input[name=film_id]')[0].value,
                'season_id': $('input[name=season_id]')[0].value,
                'episode_id': $('input[name=episode_id]')[0].value,
                'media_type': $('select[name=media_type]')[0].value,
                'content': $('textarea[name=content]')[0].value,
                'user_id': $('select[name=user_id]')[0].value,
            },
            url: "{{ route('manager.create.comment.request') }}",
            success: function (response) {
                if (response.status === "error") {
                    for (const key in response.message) {
                        if (response.message[key] === '') {
                            $(`input[name=${key}]`).removeClass("form-control-danger")
                            $(`select[name=${key}]`).removeClass("form-control-danger")
                            $(`textarea[name=${key}]`).removeClass("form-control-danger")
                            $(`.validate_${key}`).removeClass("has-danger") 
                            $(`input[name=${key}]`).addClass("form-control-success")
                            $(`select[name=${key}]`).addClass("form-control-success")
                            $(`textarea[name=${key}]`).addClass("form-control-success")
                            $(`.validate_${key}`).addClass("has-success")         
                        }
                        else{
                            $(`input[name=${key}]`).addClass("form-control-danger")
                            $(`select[name=${key}]`).addClass("form-control-danger")
                            $(`textarea[name=${key}]`).addClass("form-control-danger")
                            $(`.validate_${key}`).addClass("has-danger")    
                            $(`input[name=${key}]`).removeClass("form-control-success")
                            $(`select[name=${key}]`).removeClass("form-control-success")
                            $(`textarea[name=${key}]`).removeClass("form-control-success")
                            $(`.validate_${key}`).removeClass("has-success") 
                        }
                        $(`.validate_${key}`).html(response.message[key]) 
                    }
                }
                else if (response.status === "success") {
                    $('form[id=create_comment]')[0].submit();   
                }
                
            }
        })
    }
</script>
