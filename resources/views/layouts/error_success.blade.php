@if($errors->any())
	<div class="ui error message">
		<div class="header">
			Something went wrong...
		</div>

		<ul class="list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@elseif(session('success') != NULL)
	<div class="ui success message">
		<div class="header">
			{!! session('success')['header'] !!}
		</div>
		<p>{!! isset(session('success')['message']) ? session('success')['message'] : '' !!}</p>
	</div>
@endif