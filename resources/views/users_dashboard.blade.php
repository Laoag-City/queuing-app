@extends('layouts.main')

@section('content')
<div class="ui center aligned grid">
	<div class="eight wide column" style="margin-top: 20px;">
		<h1 class="ui header text centered">{{ $title }}</h1>

		<table class="ui celled center aligned compact table">
			<thead>
				<tr>
					<th>Queue Type</th>
					<th>Username</th>
					<th>Window</th>
					<th></th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{ $user->queue_type->type }}</td>
						<td>{{ $user->username }}</td>
						<td class="collapsing">{{ $user->window_number }}</td>
						<td class="collapsing">
							<a href="{{ url('users/' . $user->user_id) }}" class="ui tiny yellow button">Edit</a>
						</td>
						<td class="collapsing">
							<a href="#" class="ui tiny red button" @click="showModal({{ $user->user_id }})">Remove</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<br>
		<div class="ui divider"></div>
		<br>
		
		<h3 class="ui top attached header">New User</h3>

		<form class="ui attached segment form {{ $errors->any() ? 'error' : 'success' }}" action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
			@csrf
			@include('layouts.error_success')

			<div class="field">
				<label>Username</label>
				<input type="text" name="username" value="{{ old('username') }}">
			</div>

			<div class="field">
				<label>Password</label>
				<input type="password" name="password">
			</div>

			<div class="field">
				<label>Password Confirmation</label>
				<input type="password" name="password_confirmation">
			</div>

			<div class="field">
				<label>Queue Type</label>
				<select name="queue_type">
					<option value=""></option>
					@foreach($queues as $queue)
						<option value="{{ $queue->queue_type_id }}" {{ old('queue_type') != $queue->queue_type_id ? '' : 'selected' }}>{{ $queue->type }}</option>
					@endforeach
				</select>
			</div>

			<div class="field">
				<label>Window Number</label>
				<input type="number" name="window_number" value="{{ old('window_number') }}" min="1" max="99">
			</div>

			<div class="field">
				<label>Picture (600-4200 x 600-4200, ratio: 1:1)</label>
				<input type="file" name="picture" accept="image/*">
			</div>

			<button type="submit" class="ui fluid blue button">Add User</button>
		</form>
	</div>
</div>

<div class="ui basic modal">
	<div class="ui icon header">
		<i class="archive icon"></i>
		Remove User
	</div>
	
	<div class="content">
		<p>Are you sure to permanently remove the selected user?</p>
	</div>

	<form class="actions" method="POST" :action="'{{ url('users') }}' + '/' + id">
		@csrf
		@method('DELETE')

		<div class="ui red basic cancel inverted button">
			<i class="remove icon"></i>
			No
		</div>
		
		<button type="submit" class="ui green ok inverted button">
			<i class="checkmark icon"></i>
			Yes
		</button>
	</form>
</div>
@endsection

@section('custom_js')
<script>
	var app = new Vue({
		el: '#main_content',

		data: {
			id: null
		},

		methods: {
			showModal: function(id){
				this.id = id;
				$('.ui.basic.modal').modal('show');
			}
		}
	});
</script>
@endsection