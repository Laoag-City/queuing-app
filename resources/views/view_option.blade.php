@extends('layouts.main')

@section('content')
<div class="ui center aligned grid">
	<div class="sixteen wide column" style="margin-top: 3%;">
		<h1 class="ui header text centered">Pick View Type</h1>
	</div>

	@if(!is_array($queue))
		<div class="six wide column">
			<a href="{{ url('window') }}" class="ui fluid huge button">Window View</a>
		</div>

		<div class="six wide column">
			<a href="{{ url('client/' . $queue) }}" class="ui fluid huge button">Client View</a>
		</div>

	@else
		<div class="six wide column">
			<button class="ui fluid huge icon dropdown button" style="text-align: center;">
				Client Views
				<i class="dropdown icon"></i>

				<div class="menu">
					@foreach($queue as $q)
						<a href="{{ url('client/' . $q['queue_type_id']) }}" class="item">{{ $q['type'] }}</a>
					@endforeach
				</div>
			</button>
		</div>
	@endif
</div>
@endsection

@section('custom_js')
	<script>
		$('.ui.dropdown').dropdown();
	</script>
@endsection