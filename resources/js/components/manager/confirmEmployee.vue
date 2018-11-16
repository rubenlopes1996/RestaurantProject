<template>
    <div class="jumbotron">
    <h2>Confirm registration</h2>
    <div class="form-group">
      <label for="inputName">Name</label>
      <label {{user.name}} />
    </div>
    <div class="form-group">
      <label for="inputEmail">Email</label>
      <label  {{user.email}}/>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" v-model="password" name="password" id="password" placeholder="Password"  />
    </div>
     <div class="form-group">
      <label for="passwordConfirmation">Password confirmation</label>
      <input type="passwordConfirmation" class="form-control" v-model="passwordConfirmation" name="passwordConfirmation" id="passwordConfirmation" placeholder="Password confirmation"   />
    </div>

    <div class="form-group">
      <a class="btn btn-primary" v-on:click.prevent="saveEmployee()">Save</a>
      <a class="btn btn-light" v-on:click.prevent="cancel()">Cancel</a>
    </div>
  </div>
</template>

<script>
export default {
        props: ["user"],
    data: function() {
      return {
        password :"",
        passwordConfirmation:"",
        blocked: 0
      };
    },
    methods: {
      saveEmployee: function() {
        let user = {
          password : this.password,
          blocked: this.blocked
        };  
          .put("api/users/" + this.user.id, this.user)
          .then(response => {
            this.successMessage = "Registration completed";
            console.log(response);
          }).catch(error => {
            /*this.showFailure = true;
            this.showSuccess = false;
            this.failMessage = error.response.data.message;*/
            console.log(error);
            console.log(error.response.data.message);
          });
      }
  
    }
  };  
}
</script>
<style>

</style>
