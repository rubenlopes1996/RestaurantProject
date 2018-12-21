<template>
  <div class="container content-admin">
    <add-employee></add-employee>
    <div id="list">
      <div class="alert alert-success" v-if="showSuccess">
        <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false"><span aria-hidden="true">&times;</span></button>
        <strong>{{ successMessage }}</strong>
      </div>
      <user-edit :user="currentUser" @save-user="saveUser()" @cancel-edit="cancelEdit()"></user-edit>
      <manager-list :users="users" @edit-user="editUser" @delete-user="deleteUser" @unblock="unblock" @block="block"></manager-list>
    </div>
  </div>
</template>

<script>
  module.exports = {
    data: function() {
      return {
        editingUser: false,
        showSuccess: false,
        showFailure: false,
        successMessage: "",
        failMessage: "",
        currentUser: null,
        newUser: null,
        users: null
      };
    },
    methods: {
      editUser: function(user) {
        this.currentUser = Object.assign({}, user);
        this.editingUser = true;
        this.showSuccess = false;
        
      },
  
      deleteUser: function(user) {
        if (user === this.currentUser) {
          this.currentUser = null;
        }
        axios
          .delete("api/employee/" + user.id)
          .then(response => {
            this.showSuccess = true;
            this.successMessage = "User Deleted";
            this.getUsers();
          })
          .catch(error => {
            console.log(error.response.data.message);
            this.failMessage = error.response.data.message;
          });
      },
      saveUser: function() {
        this.editingUser = false;
        const user = this.currentUser;
        axios.put("api/employee/" + this.currentUser.id, this.currentUser)
          .then(response => {
            this.showSuccess = true;
            this.successMessage = "User Saved";
            this.$toasted.success('User edited with success!', {duration: 5000, position: 'top-center'});
            // Copies response.data.data properties to this.currentUser
            // without changing this.currentUser reference
            console.log(response.data.data);
            Object.assign(this.currentUser, response.data.data);
            this.users.forEach(u => {
              if (u.id == user.id) {
                u = Object.assign(u, user);
              }
            });
          })
          .catch(error => {
            this.showFailure = true;
            this.showSuccess = false;
            this.failMessage = error.response.data.message;
            console.log(error.response.data.message);
          });
      },
      cancelEdit: function() {
        this.showSuccess = false;
        this.editingUser = false;
        axios.get("api/employee/" + this.currentUser.id).then(response => {
          // Copies response.data.data properties to this.currentUser
          // without changing this.currentUser reference
          Object.assign(this.currentUser, response.data.data);
          this.currentUser = null;
        });
      },
      getUsers: function() {
        axios.get("api/employees").then(response => {
          this.users = response.data.data;
        });
      },
      block: function(user) {
        axios.patch("api/employee/block/" + user.id, user)
          .then(response => {
            this.showSuccess = true;
            this.successMessage = "User Blocked";
            this.$toasted.success('User blocked with success!', {duration: 5000, position: 'top-center'});
            this.getUsers();
          })
          .catch(error => {
            this.showFailure = true;
            this.showSuccess = false;
            this.failMessage = error.response.data.message;
            console.log(error.response.data.message);
          });
      },
      unblock: function(user) {
        axios.patch("api/employee/unblock/" + user.id, user)
          .then(response => {
            this.showSuccess = true;
            this.successMessage = "User Unblocked";
            this.$toasted.success('User unblocked with success!', {duration: 5000, position: 'top-center'});
            this.getUsers();
          })
          .catch(error => {
            this.showFailure = true;
            this.showSuccess = false;
            this.failMessage = error.response.data.message;
            console.log(error.response.data.message);
          });
      }
    },
    mounted() {
      this.getUsers();
    }
  };
</script>
