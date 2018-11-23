<template>
    <div class="ui stackable grid container">
        <div class="eight wide column">
            <div class="ui segment">
                <h2 class="ui dividing header">Edit Profile</h2>
    
                <form class="ui form">
                    <div class="field">
                        <label>Profile photo</label>
                        <img :src="'storage/profiles/'+user.photo_url" class="rounded">
                        <img-inputer v-model="user.photo_url" theme="light" size="small" />
    
                    </div>
                    <div class="field">
                        <label>Full Name</label>
                        <input type="text" name="name" v-model="user.name">
                    </div>
    
                    <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" v-model="user.username">
                    </div>
    
                    <div class="field">
                        <label>Email</label>
                        <input disabled type="email" name="email" v-model="user.email" placeholder="Email">
                    </div>
    
                    <a class="btn btn-primary" v-on:click.prevent="updateProfile()">Update Profile</a>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      user: auth.user
    };
  },
  methods: {
    updateProfile: function() {
      axios.put("api/employee/" + this.user.id, this.user)
        .then(response => {
          console.log("updated");
        })
        .catch(error => {
          console.log(error.response.data.message);
        });
    }
  }
};
</script>

<style>
#profile {
  margin-top: 300px;
  margin-left: 300px;
}
</style>
