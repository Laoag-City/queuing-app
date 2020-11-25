@extends('layouts.main')

@section('custom_css')
	<style>
		.queue_info>.column{
			/*border: 1px solid #e0e0e0;*/
			margin-bottom: 10px;
			border: .5px solid #c4c4c4;
		}

		.queue_info>div:first-child{
			background-color: #eaeaea;
		}

		.no_border{
			border: 0;
		}

		h1{
			letter-spacing: 2px;
		}

		img{
			width: 124px;
		}

		.window_number{
			font-size: 70pt !important;
		}

		.outer_column{
			margin-left: 4.166666666666667%;
			margin-right: 4.166666666666667%;
		}

		.not_visible{
			visibility: hidden;
		}

		.now_serving_number{
			font-size: 78pt !important;
		}

		.top_padded{
			padding-top: 55px !important;
		}

		.no_top_bottom_padding{
			padding-top: 0px !important;
			padding-bottom: 0px !important;
		}

		footer{
			display: block;
			width: 100%;
			position: fixed;
			left: 0;
			bottom: 0;
			text-align: center;
		}
	</style>
@endsection

@section('content')
<h1 class="ui header center aligned" style="margin-top: 5px; margin-bottom: 0;">
	<img src="/img/seal.png" style="width: 65px; height: auto;">
	<u>>> {{ $window_type }} <<</u>
</h1>

<div class="ui grid" style="text-align: center">
	<div class="four wide column no_border outer_column">
		<div class="ui two column no_border grid">
			<div class="column">
				<h1 class="ui header"><u>Window</u></h1>
			</div>

			<div class="column">
				<h1 class="ui header"><u>Now Serving</u></h1>
			</div>
		</div>
	</div>

	<div class="four wide column no_border outer_column">
		<div class="ui two column no_border grid">
			<div class="column">
				<h1 class="ui header"><u>Window</u></h1>
			</div>

			<div class="column">
				<h1 class="ui header"><u>Now Serving</u></h1>
			</div>
		</div>
	</div>

	<div class="four wide column no_border outer_column">
		<div class="ui two column no_border grid">
			<div class="column">
				<h1 class="ui header"><u>Window</u></h1>
			</div>

			<div class="column">
				<h1 class="ui header"><u>Now Serving</u></h1>
			</div>
		</div>
	</div>

	<window-info
		v-for="(window, index) in windows"
		v-if="window != null"
		:window="window.window"
		:current-regular="window.current_regular"
		:current-pod="window.current_pod"
		:serving-regular="window.serving_regular"
		:user_number="window.user_id"
		:colors="{regular: '{{ $regular_color }}', pod: '{{ $pod_color }}' }"
		:key="index + 1"
		:id="'window-' + (index + 1)">
	</window-info>

	<window-info
		v-else>
	</window-info>
</div>

<h1 class="ui center aligned header {{ $queue_id == 1 ? 'orange' : 'red'  }}" style="margin-bottom: 0;">
	{{ title_case($pod_color) }} Card for PWD / Senior Citizen
</h1>
<h1 class="ui center aligned header {{ $queue_id == 1 ? 'blue' : 'green' }}" style="margin-top: 0;">
	{{ title_case($regular_color) }} Card for Regular Clients
</h1>
@endsection

@section('custom_js')
	<script src="{{ mix('js/client.js') }}"></script>
@endsection