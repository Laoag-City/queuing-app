@extends('layouts.main')

@section('content')
<div class="ui center aligned grid">
	<div class="five wide column" style="margin-top: 12%;">
		<h3 class="ui top attached header text centered">
			Queuing Application - Log In
		</h3>

		<form class="ui large form attached segment center aligned {{ $errors->any() ? 'error' : 'success' }}" method="POST" action="{{ url()->current() }}">
			@include('layouts.error_success')
			@csrf

			<div class="field">
				<input type="text" name="username" value="{{ old('username') }}" placeholder="Username">
			</div>

			<div class="field">
				<input type="password" name="password" placeholder="Password">
			</div>

			<button type="submit" class="fluid ui button">Log In</button>
		</form>
	</div>
</div>
@endsection