var vue = new Vue({
	el: '#main_content',

	data: {
		regular: regular_number,
		pod: pod_number,
		isRegularLoading: false,
		isPODLoading: false
	},

	methods: {
		nextNumber: function nextNumber(type) {
			var _this = this;

			this.isRegularLoading = true;
			this.isPODLoading = true;

			axios.post('increment', {
				client_type: type
			}).then(function (response) {
				if (type == 'Regular') _this.regular = response.data;else _this.pod = response.data;
			}).catch(function (error) {
				console.log(error.response.data);
			}).then(function () {
				var self = _this;
				setTimeout(function () {
					self.isRegularLoading = false;
					self.isPODLoading = false;
				}, 1000);
			});
		}
	}
});
