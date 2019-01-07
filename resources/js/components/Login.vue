<template>
  <div id="login" class="container col-lg-4">
      <!--   <div class="login-box-body">
          <h3 class="text-center">Sign in</h3>
         <form>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input
                  type="text"
                  name="email"
                  placeholder="Email or Username"
                  class="form-control"
                  autofocus="true"
                  required="true"
                  v-model="user.email"
                >
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input
                  type="password"
                  name="password"
                  placeholder="Password"
                  class="form-control"
                  required="true"
                  v-model="user.password"
                >
              </div>
            </div>
            <div class="col-xs-12">
              <button class="btn btn-outline-primary" v-on:click.prevent="login()">Login</button>
            </div>
          </form> -->


      <form @submit.prevent="submit" class="contact-form">
        <h3 class="text-center">Sign in</h3>

        <div class="form-group" :class="{ 'form-group--error': $v.userEmail.$error }">
          <input type="text" name="email" placeholder="Email or Username" class="form-control" autofocus="true" required="true" v-model.trim="$v.userEmail.$model">
        </div>

        <div class="form-group" :class="{ 'form-group--error': $v.pass.$error }">
            <input type="password" name="password" placeholder="Password" class="form-control" required="true" v-model.trim="$v.pass.$model">
        </div>
        <button class="btn main-btn" type="submit" :disabled="submitStatus === 'PENDING'">Login</button>

        <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the field correctly.</p>
        <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>



      </form>
      <input type="password" name="password" placeholder="Password" class="form-control" required="true" v-model="user.password"



    </div>

</template>

<script>
    import { required } from 'vuelidate/lib/validators'
export default {
  data() {
    return {
      user: {
        email: "",
        password: ""
      },
        submitStatus: null,
        userEmail:"",
        pass:"",
    };
  },
    validations: {
        userEmail: {
            required
        },
        pass:{
            required
        }
    },
  methods: {
    login() {
        this.user.email=this.userEmail;
        this.user.password=this.pass;
        console.log(this.user);
      this.showMessage = false;
      axios
        .post("api/login", this.user)
        .then(response => {
          this.$store.commit("setToken", response.data.access_token);
          return axios.get("api/get-user");
        })
        .then(response => {
          this.$store.commit("setUser", response.data.data);
          this.typeofmsg = "alert-success";
          this.message = "User authenticated correctly";
          this.showMessage = true;
          this.$socket.emit('user_enter', response.data.data);
         switch (response.data.data.type) {
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
        .catch(error => {
          this.$store.commit("clearUserAndToken");
          this.typeofmsg = "alert-danger";
          this.message = "Invalid credentials";
          this.showMessage = true;
          console.log(error);
          this.$toasted.error('Wrong username or password, please try again', {duration: 3000, position: 'top-center',theme:'bubble'});
        });
    },
      submit() {
          console.log('submit!')
          this.$v.$touch()
          if (this.$v.$invalid) {
              this.submitStatus = 'ERROR'
          } else {
              // do your submit logic here
              this.submitStatus = 'PENDING'
              setTimeout(() => {
                  this.submitStatus = 'OK'
                  this.login();
              }, 500)
          }
      },
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
