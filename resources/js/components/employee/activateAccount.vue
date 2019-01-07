<template>
  <div class="jumbotron">
        <h2>Account activation</h2>
        <div class="form-group">
            <label for="inputName">Password</label>
            <input type="password" class="form-control" v-model="user.password" name="password" id="password" placeholder="Password" />
            <label for="inputName">Password confirmation</label>
            <input type="password" class="form-control" v-model="user.passwordConfirmation" name="passwordConfrimation" id="passwordConfrimation" placeholder="passwordConfrimation" />
        </div>
       <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="confirmEmployee()">Save</a>
        </div>
    </div>
</template>
<script>
export default {
    props: ["email"],
    data() {
      return {
        user: {
        email: this.email,
        password: "",
        passwordConfirmation:""
      },

    };
  },
    mounted(){
    if(this.email==null){
				this.$router.push({ path:'/login' });
				return;
			}
   },
   methods:{
     confirmEmployee: function(){
       axios.patch("http://restaurantproject.dad/api/employee/confirm/"+this.user.email,this.user)
       .then(response=>{
				  this.$router.push({ path:'/login' });
       })
      .catch(error => {
        console.log(error.response.data.message);
      });
     }
   }
}
</script>
<style>

</style>

