<select
class="custom-select2 form-control"
name="district"
style="width: 100%; height: 38px"
onchange="SelectWard(this);"
>
    <option selected value="">Chọn quận...</option>
    @foreach ($quan as $item)
    <option value="{{ $item["id"] }}">{{ $item["name"] }}</option>
    @endforeach
</select>
<script>
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

<script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
