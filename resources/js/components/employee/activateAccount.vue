<template>
        <b-container>
            <b-row>
                <b-col cols="12">
                <h2>Account activation</h2>
                <div class="form-group">
                    <label for="inputName">Password</label>
                    <input type="password" class="form-control" v-model="user.password" name="password" id="password" placeholder="Password" :required="true"/>
                    <label for="inputName">Password confirmation</label>
                    <input type="password" class="form-control" v-model="user.passwordConfirmation" name="passwordConfirmation" id="passwordConfrimation" placeholder="Password Confirmation" />
                </div>
                  <div class="form-group">
                    <a class="btn btn-primary" v-on:click.prevent="confirmEmployee()">Save</a>
                </div>
              </b-col>
                      
            </b-row>
        </b-container>
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
          this.$router.push('login');
            this.$toasted.success('User actived with success!', {duration: 5000, position: 'top-center'});

       })
      .catch(error => {
        console.log(error.response.data.message);
          this.$toasted.error('Error activating user!', {duration: 5000, position: 'top-center'});

      });
     }
   }
}
</script>
<style>

</style>

