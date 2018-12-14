<template>
  <div class="container">
    <h1>Edit Profile</h1>
  	<hr>
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img :src="'storage/profiles/'+user.photo_url" class="avatar img-circle" alt="avatar">
          <h6>Upload a different photo...</h6>
          <input type="file" class="form-control-file" id="files" ref="files" v-on:change="handleFiles()">
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          This is an <strong>.alert</strong>. Use this to show important messages to the user.
        </div>
        <h3>Personal info</h3>
        
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-lg-3 control-label">Full name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" v-model="user.name">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Username:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" v-model="user.username">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" v-model="user.email" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-8">
              <input class="form-control" type="password" v-model="user.password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Confirm password:</label>
            <div class="col-md-8">
              <input class="form-control" type="password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="button" class="btn btn-primary" value="Save Changes" v-on:click.prevent="updateProfile()">
              <span></span>
              <input type="reset" class="btn btn-default" value="Clear fields">
            </div>
          </div>
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
      files: [],
      editingPassword: false
    };
  },
  methods: {
    handleFiles() {
      let uploadedFiles = this.$refs.files.files;
      for (var i = 0; i < uploadedFiles.length; i++) {
        this.files.push(uploadedFiles[i]);
      }
      this.$store.commit("setUser", this.user);
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
            //this.user.photo_url = response.data.photo;
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
          Object.assign(this.user, response.data.data);
          this.$store.commit("setUser", this.user);
          this.files = [];
        })
        .catch(error => {
          console.log(error.response.data.message);
        });
    }
  }
};
</script>

<style scoped>
input#files{
  margin-top: 10px;
    margin-bottom: 10px;
}
img{
  max-width: 128px;
}
#profile {
  margin-top: 300px;
  margin-left: 300px;
}
#editProfile {
  margin-top: 200px;
}
</style>
