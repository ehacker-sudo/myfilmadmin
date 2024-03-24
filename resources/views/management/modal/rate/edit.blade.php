<div
class="modal fade bs-example-modal-lg"
id="edit-rate"
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
                    <div class="col-sm-6 col-md-6">
                        <label class="col-form-label">Số điểm</label>
                        <input id="rate" type="number" class="form-control" name="rate" value=""/>
                        <div class="form-control-feedback validate_rate"></div>
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
                <button type="submit" class="btn btn-primary">
                    Sửa
                </button>
            </div>
        </form>
    </div>
</div>
</div>


<script>
    function take_url_edit_rate(rate_id) {
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "POST",
            data:{
                'rate_id': rate_id
            },
            url: "{{ route('manager.rate.id') }}",
            success: function (response) {
                $('form')[1].action = response.url;
            }
        });  
    }
</script>