<template>
    <div id="list">
        <button id="button" class="btn btn-sm btn-primary" v-on:click.prevent="createEmployee()">Create employee</button>
        <manager-list id="listmanager" :users="users" @edit-user="editUser" @delete-user="deleteUser"></manager-list>
        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>@{{ successMessage }}</strong>
        </div>
        <user-edit :user="currentUser" @save-user="saveUser()" @cancel-edit="cancelEdit()"></user-edit>
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
                users: [],
            };
        },
        methods: {
            editUser: function(user) {
                this.currentUser = user;
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
                axios.put("api/users/" + this.currentUser.id, this.currentUser)
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = "User Saved";
                        // Copies response.data.data properties to this.currentUser
                        // without changing this.currentUser reference
                        Object.assign(this.currentUser, response.data.data);
                        this.currentUser = null;
                        this.editingUser = false;
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

<style>
    #list {
        margin-left: 200px;
        margin-top: 56 px;
    }
    
    #listmanager {
        margin-top: 100px;
    }


</style>
