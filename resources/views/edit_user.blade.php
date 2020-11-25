@extends('layouts.main')

@section('content')
<div class="ui center aligned grid">
	<div class="six wide column" style="margin-top: 3%;">
		<h3 class="ui top attached header">Edit User</h3>

		<form class="ui attached segment form {{ $errors->any() ? 'error' : 'success' }}" action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			@include('layouts.error_success')

			<div class="field">
				<label>Username</label>
				<input type="text" name="username" value="{{ old('username') == null ? $user->username : old('username') }}">
			</div>

			<div class="field">
				<label>Password</label>
				<input type="password" name="password">
			</div>

			<div class="field">
				<label>Password Confirmation</label>
				<input type="password" name="password_confirmation">
			</div>

			@php
				$queue_type_to_use = old('queue_type') == null ? $user->queue_type->queue_type_id : old('queue_type');
			@endphp

			<div class="field">
				<label>Queue Type</label>
				<select name="queue_type">
					<option value=""></option>
					@foreach($queues as $queue)
						<option value="{{ $queue->queue_type_id }}" {{ $queue_type_to_use != $queue->queue_type_id ?: 'selected' }}>{{ $queue->type }}</option>
					@endforeach
				</select>
			</div>

			<div class="field">
				<label>Window Number</label>
				<input type="number" name="window_number" value="{{ old('window_number') == null ? $user->window_number : old('window_number') }}" min="1" max="99">
			</div>

			<div class="field">
				<label>New Picture (600-4200 x 600-4200, ratio: 1:1)</label>
				<input type="file" name="picture" accept="image/*">
			</div>

			<button type="submit" class="ui fluid blue button">Add User</button>
		</form>
	</div>
</div>
@endsection