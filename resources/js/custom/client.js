Vue.component('window-info', {
	props: {
		window: {
			default: 0
		},

		currentRegular: {
			default: 0
		},

		currentPod: {
			default: 0
		},

		user_number: {
			//required: true
		},

		servingRegular: {
			default: null
		},

		colors: {
			type: Object
		}
	},

	template: `
			<div class="four wide column no_border outer_column">
				<div class="ui two column no_border grid queue_info">
					<div class="column">
						<div class="ui one column grid">
							<div class="column no_top_bottom_padding">
								<h1 class="ui header window_number" :class="{not_visible: window == 0}">{{ window }}</h1>
							</div>

							<div class="column no_top_bottom_padding">
								<img class="ui centered image" :src="user_number ? '/pictures/' + user_number : ''">
							</div>
						</div>
					</div>

					<div class="column top_padded" :class="currentQueue[1]">
						<h1 class="ui header now_serving_number">{{ currentQueue[0] }}</h1>
					</div>
				</div>
			</div>
			`,

	computed: {
		currentQueue(){
			if(this.servingRegular == 1)
				return [this.currentRegular, this.colors.regular];
			else if(this.servingRegular == 0)
				return [this.currentPod, this.colors.pod];
			else
				return [null, ''];
		}
	},

	updated() {
		$('#window-' + this.$vnode.key).transition({
			animation : 'flash',
			duration : 1200
		});
	}
});

var vue = new Vue({
	el: '#main_content',

	data: {
		windows: null
	},

	methods: {
		updateQueue(){
			axios.get(window.location.href)
				.then((response) => {
					if(this.windows != null)
					{
						let queue_audio = new Audio('/audio/queue_audio.mp3');

						for(let i = 0; i < this.windows.length; i++)
						{
							if(this.windows[i] != null)
							{
								if(response.data[i].serving_regular == 1 && (this.windows[i].current_regular != response.data[i].current_regular))
								{
									queue_audio.play();
									this.windows[i].serving_regular = 1;
									this.windows[i].current_regular = response.data[i].current_regular;
								}

								else if(response.data[i].serving_regular == 0 && (this.windows[i].current_pod != response.data[i].current_pod))
								{
									queue_audio.play();
									this.windows[i].serving_regular = 0;
									this.windows[i].current_pod = response.data[i].current_pod;
								}
							}
						}
					}

					else
						this.windows = response.data;
				})
				.catch(function (error) {
					console.log(error);
  				})
  				.then(() => {
  					var self = this;
  					setTimeout(function(){
  						self.updateQueue();
  					}, 1200);
  				});
		}
	},

	mounted(){
		this.updateQueue();
	}
});