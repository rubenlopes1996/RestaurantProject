<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id" :class="{active: activetUser === user}">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.type }}</td>
                <td>
                    <a class="btn btn-sm btn-primary" v-on:click.prevent="editUser(user)">Edit</a>
                    <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(user)">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    module.exports = {
        props: ['users'],
        data: function() {
            return {
                activetUser: {}
            };
        },
        methods: {
            editUser: function(user) {
                this.activetUser = user;
                this.$emit('edit-user', user);
            },
    
            deleteUser: function(user) {
                this.$emit('delete-user', user);
            }
        }
    };
</script>