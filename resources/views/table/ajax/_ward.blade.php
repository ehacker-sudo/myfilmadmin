<select
class="custom-select2 form-control"
name="ward"
style="width: 100%; height: 38px"
>

<option selected value="">Chọn phường/xã...</option>
@foreach ($phuongxa as $item)
<option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
@endforeach

<select>
<script src="{{ asset('vendors/scripts/script.min.js') }}"></script>