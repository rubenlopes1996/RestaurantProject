<template>
    <div class="lg-12 md-6 xs-4">
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
                <tr v-for="user in users" :key="user.id" :class="{active: activeUser === user}">
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
    </div>
</template>

<script>
module.exports = {
  props: ["users"],
  data: function() {
    return {
      activeUser: {}
    };
  },
  methods: {
    editUser: function(user) {
      this.activeUser = user;
      this.$emit("edit-user", user);
    },

    deleteUser: function(user) {
      this.$emit("delete-user", user);
    }
  }
};
</script>
