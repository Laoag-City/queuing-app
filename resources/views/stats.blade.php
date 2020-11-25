@extends('layouts.main')

@section('content')
<div class="ui center aligned grid">
	<div class="ten wide column">
		<br>
		<h2 class="ui header text centered">{{ $title }}</h2>

		<form class="ui form" method="GET" action="{{ url()->current() }}">
			<div class="three fields">
				<div class="field">
					<div class="field">
						<label>Queue Type</label>
						<select name="queue" required="required">
							<option></option>
							@foreach($queues as $queue)
								<option value="{{ $queue['queue_type_id'] }}">{{ $queue['type'] }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="field">
					<div class="field">
						<label>Year</label>
						<input type="number" value="2018" min="2018" name="year" required="required">
					</div>
				</div>

				<div class="field">
					@if(request('queue') == null || request('year') == null)
						<button type="submit" class="ui fluid green button" style="margin-top: 23px;">View Stats</button>
					@else
						<div class="two buttons" style="margin-top: 23px;">
							<button type="submit" class="ui green button">View Stats</button>
							<a href="{{ url()->current() }}" class="ui yellow button">Refresh View</a>
						</div>
					@endif
				</div>
			</div>
		</form>

		<div class="ui divider"></div>

		<table class="ui sortable celled table">
			<thead>
				<tr class="center aligned">
					<th>Month</th>
					<th>Day</th>
					<th>Total Regular</th>
					<th>Total POD</th>
				</tr>
			</thead>

			@php
				$total_regular = 0;
				$total_pod = 0;
			@endphp

			<tbody>
				@foreach($stats as $stat)
					<tr class="center aligned">
						<td title="{{ $stat['month_name'] }}">{{ $stat['month'] }}</td>
						<td>{{ $stat['date'] }}</td>
						<td>{{ $stat['total_regular'] }}</td>
						<td>{{ $stat['total_pod'] }}</td>
					</tr>

					@php
						$total_regular += $stat['total_regular'];
						$total_pod += $stat['total_pod'];
					@endphp
				@endforeach
			</tbody>

			<tfoot>
				<tr class="center aligned">
					<th colspan="2">Sub-total</th>
					<th><b>{{ $total_regular }}</b></th>
					<th><b>{{ $total_pod }}</b></th>
				</tr>

				<tr class="center aligned">
					<th colspan="2">Grand total</th>
					<th colspan="2"><b>{{ $total_regular + $total_pod }}</b></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection

@section('custom_js')
<script src="{{ mix('/js/tablesort.js') }}"></script>
<script>
	$(document).ready(function(){
		$('table').tablesort();
	});
</script>
@endsection