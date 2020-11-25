@extends('layouts.main')

@section('content')
<div class="ui center aligned grid">
	<div class="sixteen wide column" style="margin-top: 3%;">
		<h1 class="ui header text centered"><u>{{ $title }}: {{ Auth::user()->username }}</u></h1>
	</div>

	<div class="twelve wide column" style="margin-top: 3%;">
		<div class="ui two statistics">
			<div class="ui huge statistic {{ $regular_color }}">
				<div class="value">
					@{{ regular }}
				</div>

				<div class="label">
					Regular
				</div>
				<br>
				<button class="ui button {{ $regular_color }}" :class="{'loading disabled': isRegularLoading}" @click="nextNumber('Regular')">Next</button>
			</div>

			<div class="ui huge statistic {{ $pod_color  }}">
				<div class="value">
					@{{ pod }}
				</div>

				<div class="label">
					POD
				</div>
				<br>
				<button class="ui button {{ $pod_color  }}" :class="{'loading disabled': isPODLoading}" @click="nextNumber('POD')">Next</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('custom_js')
	<script>
		var regular_number = {!! $current_regular_number == null ? 0 : $current_regular_number !!};
		var pod_number = {!! $current_pod_number == null ? 0 : $current_pod_number !!};
	</script>
	<script src="{{ mix('js/window.js') }}"></script>
@endsection