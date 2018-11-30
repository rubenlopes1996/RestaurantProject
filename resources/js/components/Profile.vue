<template>
  <div class="ui stackable grid container">
    <div class="eight wide column">
      <div class="ui segment">
        <h2 class="ui dividing header">Edit Profile</h2>

        <form class="ui form">
          <div class="field">
            <label>Profile photo</label>
            <img :src="'storage/profiles/'+user.photo_url" class="profile-pic-edit rounded-circle">
            <input type="file" id="files" ref="files" v-on:change="handleFiles()">
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
      user: this.$store.state.user,
      files: []
    };
  },
  methods: {
    handleFiles() {
      let uploadedFiles = this.$refs.files.files;
      for (var i = 0; i < uploadedFiles.length; i++) {
        this.files.push(uploadedFiles[i]);
      }
      this.upload();
    },
    upload() {
      for (let i = 0; i < this.files.length; i++) {
        if (this.files[i].id) {
          continue;
        }
        let formData = new FormData();
        formData.append("file", this.files[i]);

        axios
          .post("api/employee-photo/" + this.user.id, formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(response => {
            console.log(response.data);
            this.user.photo_url = response.data.photo;
            updateProfile();
          })
          .catch(error => {
            console.log(error.response.data.message);
          });
      }
    },
    updateProfile: function() {
      axios
        .put("api/employee-profile/" + this.user.id, this.user)
        .then(response => {
          console.log(this.user);
          console.log(response.data.data);
          Object.assign(this.user, response.data.data);
          console.log("updated");
          this.files = [];
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
