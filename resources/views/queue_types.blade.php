@extends('layouts.main')

@section('content')

<div class="ui center aligned grid">
	<div class="fourteen wide column" style="margin-top: 20px;">
		<h1 class="ui header text centered">{{ $title }}</h1>

		<div class="ui divider"></div>

		@if(session('success') != NULL)
			<div class="ui success message">
				<div class="header">
					{!! session('success')['header'] !!}
				</div>
				<p>{!! isset(session('success')['message']) ? session('success')['message'] : '' !!}</p>
			</div>
		@endif
		<br>

		@foreach($queues as $queue)
			@php
				$type = $queue->type;
				$loop_number = $loop->iteration;
			@endphp

			<form id="form_{{ $loop_number }}" class="ui attached segment form {{ $errors->$type->any() ? 'error' : 'success' }}" action="{{ url("queue_types/{$queue->queue_type_id}") }}" method="POST">
				@csrf
				@method('PUT')
				<input type="hidden" name="form_number" value="{{ $loop_number }}">

				<h3 class="ui header">{{ "{$loop_number}. $type" }}</h3>

				@if($errors->$type->any())
					<div class="ui error message">
						<div class="header">
							Something went wrong...
						</div>

						<ul class="list">
							@foreach($errors->$type->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<div class="fields">
					<div class="six wide field">
						<label>Queue Type</label>
						<input type="text" name="type[{{ $loop_number }}]" value="{{ old("type.{$loop_number}") != null ? old("type.{$loop_number}") : $queue->type }}">
					</div>

					<div class="three wide field">
						<label>Regular Color</label>
						<select name="regular_color[{{ $loop_number }}]">
							<option value=""></option>

							@php
								if(old("regular_color.{$loop_number}") == null)
									$regular_color_to_use = $queue->color_regular;
								else
									$regular_color_to_use = old("regular_color.{$loop_number}");
							@endphp

							@foreach($colors as $color)
								<option value="{{ $color }}" {{ $regular_color_to_use != $color ? '' : 'selected' }}>{{ $color }}</option>
							@endforeach
						</select>
					</div>

					<div class="three wide field">
						<label>POD/Senior Color</label>
						<select name="pod_senior_color[{{ $loop_number }}]">
							<option value=""></option>

							@php
								if(old("pod_senior_color.{$loop_number}") == null)
									$pod_senior_color_to_use = $queue->color_pod;
								else
									$pod_senior_color_to_use = old("pod_senior_color.{$loop_number}");
							@endphp

							@foreach($colors as $color)
								<option value="{{ $color }}" {{ $pod_senior_color_to_use != $color ? '' : 'selected' }}>{{ $color }}</option>
							@endforeach
						</select>
					</div>

					<div class="two wide field">
						<label>Regular Queue Limit</label>
						<input type="text" name="regular_queue_limit[{{ $loop_number }}]" value="{{ old("regular_queue_limit.{$loop_number}") != null ? old("regular_queue_limit.{$loop_number}") : $queue->queue_limit_regular }}">
					</div>

					<div class="two wide field">
						<label>POD/Senior Queue Limit</label>
						<input type="text" name="pod_senior_queue_limit[{{ $loop_number }}]" value="{{ old("pod_senior_queue_limit.{$loop_number}") != null ? old("pod_senior_queue_limit.{$loop_number}") : $queue->queue_limit_pod }}">
					</div>
				</div>

				<button type="submit" form="form_{{ $loop_number }}" class="ui fluid yellow inverted button">Edit {{ $type }}</button>
			</form>

			<div class="ui divider"></div>
		@endforeach
	</div>
</div>

@endsection