<template>
	<div id="login">
		<div class="login-box-body">
			<form>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" name="username" placeholder="Username" class="form-control" autofocus="true" required="true" v-model="username">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" name="password" placeholder="password" class="form-control" required="true" v-model="password">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<a class="btn btn-primary" v-on:click.prevent="login()">Login</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		methods: {
			login() {
				let data = {
					username: this.username,
					password: this.password
				};
	
				axios.post('/api/login', data).then(({data}) => {
						auth.login(data.token, data.user);
	
						this.$router.push('/dashboard');
					})
					.catch(({response}) => {
						alert(response.data.message);
					});
			}
		},
		data() {
			return {
				username: "",
				password: ""
			}
		}
	}
</script>
<style>
#login{
	margin-top: 200px;
}
</style>
