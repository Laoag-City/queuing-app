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

		alterColor: {
			//type: String
		}
	},

	template: '\n\t\t\t<div class="four wide column no_border outer_column">\n\t\t\t\t<div class="ui two column no_border grid queue_info">\n\t\t\t\t\t<div class="column">\n\t\t\t\t\t\t<div class="ui one column grid">\n\t\t\t\t\t\t\t<div class="column no_top_bottom_padding">\n\t\t\t\t\t\t\t\t<h1 class="ui header window_number" :class="{not_visible: window == 0}">{{ window }}</h1>\n\t\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t\t<div class="column no_top_bottom_padding">\n\t\t\t\t\t\t\t\t<img class="ui centered image" :src="user_number ? \'/pictures/\' + user_number : \'\'">\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\n\t\t\t\t\t<div class="column top_padded" :class="currentQueue[1]">\n\t\t\t\t\t\t<h1 class="ui header now_serving_number">{{ currentQueue[0] }}</h1>\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t',

	computed: {
		currentQueue: function currentQueue() {
			if (this.servingRegular == 1) {
				if (this.alterColor == 1) {
					var color = 'blue';
				} else if (this.alterColor == 2) {
					var color = 'red';
				} else if (this.alterColor == 3) {
					var color = 'green';
				}

				return [this.currentRegular, color];
			} else if (this.servingRegular == 0) {
				if (this.alterColor == 1) {
					var color = 'orange';
				} else if (this.alterColor == 2) {
					var color = 'green';
				} else if (this.alterColor == 3) {
					var color = 'red';
				}

				return [this.currentPod, color];
			} else return [null, ''];
		}
	},

	updated: function updated() {
		$('#window-' + this.$vnode.key).transition({
			animation: 'flash',
			duration: 1200
		});
	}
});

var vue = new Vue({
	el: '#main_content',

	data: {
		windows: null
	},

	methods: {
		updateQueue: function updateQueue() {
			var _this = this;

			axios.get(window.location.href).then(function (response) {
				if (_this.windows != null) {
					var queue_audio = new Audio('/audio/queue_audio.mp3');

					for (var i = 0; i < _this.windows.length; i++) {
						if (_this.windows[i] != null) {
							if (response.data[i].serving_regular == 1 && _this.windows[i].current_regular != response.data[i].current_regular) {
								queue_audio.play();
								_this.windows[i].serving_regular = 1;
								_this.windows[i].current_regular = response.data[i].current_regular;
							} else if (response.data[i].serving_regular == 0 && _this.windows[i].current_pod != response.data[i].current_pod) {
								queue_audio.play();
								_this.windows[i].serving_regular = 0;
								_this.windows[i].current_pod = response.data[i].current_pod;
							}
						}
					}
				} else _this.windows = response.data;
			}).catch(function (error) {
				console.log(error);
			}).then(function () {
				var self = _this;
				setTimeout(function () {
					self.updateQueue();
				}, 1200);
			});
		}
	},

	mounted: function mounted() {
		this.updateQueue();
	}
});
