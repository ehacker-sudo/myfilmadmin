@extends('errors.layouts.app')

@section('content')
<div
class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20"
>
	<div class="pd-10">
		<div class="error-page-wrap text-center">
			<h1>404</h1>
			<h3>Không tìm thấy trang!</h3>
			<p>
				Trang bạn đang tìm vẫn chưa được tìm thấy trên máy chủ của chúng tôi.<br />
				Kiểm tra lại đường dẫn
			</p>
			<div class="pt-20 mx-auto max-width-200">
				<a href="{{ route('login') }}" class="btn btn-primary btn-block btn-lg"
					>Trở lại</a
				>
			</div>
		</div>
	</div>
</div>
@endsection