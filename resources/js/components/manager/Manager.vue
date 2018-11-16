<template>
  <div class="container content-admin">
    <add-employee ></add-employee>
    <!-- <button id="button" class="btn btn-sm btn-primary my-2" v-on:click.prevent="createEmployee()">Create employee</button>-->
    <div id="list">
      <div class="alert alert-success" v-if="showSuccess">
        <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false"><span aria-hidden="true">&times;</span></button>
        <strong>{{ successMessage }}</strong>
      </div>
      <user-edit :user="currentUser" @save-user="saveUser()" @cancel-edit="cancelEdit()"></user-edit>
      <manager-list :users="users" @edit-user="editUser" @delete-user="deleteUser"></manager-list>
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
        users: []
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
        axios.delete("api/users/" + user.id).then(response => {
          this.showSuccess = true;
          this.successMessage = "User Deleted";
          this.getUsers();
        });
      },
      saveUser: function() {
        this.editingUser = false;
        const user = this.currentUser;
        axios
          .put("api/users/" + this.currentUser.id, this.currentUser)
          .then(response => {
            this.showSuccess = true;
            this.successMessage = "User Saved";
            // Copies response.data.data properties to this.currentUser
            // without changing this.currentUser reference
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
          });
      },
      cancelEdit: function() {
        this.showSuccess = false;
        this.editingUser = false;
        axios.get("api/users/" + this.currentUser.id).then(response => {
          // Copies response.data.data properties to this.currentUser
          // without changing this.currentUser reference
          Object.assign(this.currentUser, response.data.data);
          this.currentUser = null;
        });
      },
      getUsers: function() {
        axios.get("api/users").then(response => {
          this.users = response.data.data;
        });
      }
    },
  
    mounted() {
      this.getUsers();
    }
  };
</script>
