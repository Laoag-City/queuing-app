var vue = new Vue({
	el: '#main_content',

	data: {
		regular: regular_number,
		pod: pod_number,
		isRegularLoading: false,
		isPODLoading: false
	},

	methods: {
		nextNumber(type){
				this.isRegularLoading = true;
				this.isPODLoading = true;

			axios.post('increment', {
				client_type: type
			})
			.then((response) => {
				if(type == 'Regular')
					this.regular = response.data;

				else
					this.pod = response.data;
			})
			.catch(function(error){
				console.log(error.response.data);
			})
			.then(() => {
				var self = this;
				setTimeout(function(){
						self.isRegularLoading = false;
						self.isPODLoading = false;
				}, 1000);
			});
		}
	}
});