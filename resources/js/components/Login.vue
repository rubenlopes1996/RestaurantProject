<template>
	<div id="login" class="container col-lg-4">
		<div class="login-box-body">
			<h3 class="text-center">Sign in</h3>
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
						<input type="password" name="password" placeholder="Password" class="form-control" required="true" v-model="password">
					</div>
				</div>
				<div class="col-xs-12">
					<button class="btn btn-outline-primary" v-on:click.prevent="login()">Login</button>
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

      axios
        .post("/api/login", data)
        .then(({ data }) => {
          auth.login(data.token, data.user);
          switch (data.user.type) {
            case "manager":
              this.$router.push("/dashboard");
              break;

            case "cook":
              this.$router.push("/dashboardCook");
              break;

            case "waiter":
              this.$router.push("/dashboardWaiter");
              break;

            case "cashier":
              this.$router.push("/dashboardCashier");
              break;
          }
        })
        .catch(({ response }) => {
          alert(response.data.message);
        });
    }
  },
  data() {
    return {
      username: "",
      password: ""
    };
  }
};
</script>

<style>
#login {
  margin-top: 200px;
}

#login h3 {
  padding: 20px;
}
</style>
