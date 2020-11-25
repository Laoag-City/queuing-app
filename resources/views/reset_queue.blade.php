@extends('layouts.main')

@section('content')
<div class="ui center aligned grid">
	<div class="sixteen wide column" style="margin-top: 3%;">
		<h1 class="ui header text centered">{{ $title }}</h1>
	</div>

	<div class="five wide column">
		<form class="ui form {{ $errors->any() ? 'error' : 'success' }}" method="POST" action="{{ url()->current() }}">
			@csrf
			@method('PUT')
			@include('layouts.error_success')

			<div class="field">
				<label>Queue Type</label>
				<div class="ui selection dropdown">
					<input type="hidden" name="queue_type">
					<i class="dropdown icon"></i>
					<div class="default text">Queue Type</div>
					<div class="menu">
						@foreach($queues as $queue)
						<div class="item" data-value="{{ $queue->queue_type_id }}">{{ $queue->type }}</div>
						@endforeach
					</div>
				</div>
			</div>

			<button type="submit" class="ui fluid red button">Reset Queue</button>
		</form>
	</div>
</div>
@endsection

@section('custom_js')
	<script>
		$('.ui.dropdown').dropdown();
	</script>
@endsection