<template>
  <div>
    <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="users==null"></PacmanLoader>
    <v-client-table ref="table" :data="users" :columns="columns" :options="options" id="buttons" v-if="users!=null">
  
      <div slot="image" slot-scope="users" align="center">
        <img :src="'storage/profiles/'+users.row.photo_url" alt="" width="50" height="50">
      </div>
      <div slot="blocked" slot-scope="users" align="center">
        <feather-icon v-if="users.row.blocked == 1" type="lock"></feather-icon>
        <feather-icon v-if="users.row.blocked == 0" type="unlock"></feather-icon>
      </div>
      <div slot="actions" slot-scope="users" align="center" v-if="users.row.username != currentUser.username">
        <div v-if=" users.row.deleted_at == null">
          <button class="btn btn-sm btn-primary" v-on:click.prevent="editUser(users.row)">Edit</button>
          <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(users.row)">Delete</button>
          <div v-if="users.row.blocked==1">
            <button class="btn btn-sm btn-primary" v-on:click.prevent="unblockUser(users.row)">Unblock</button>
          </div>
          <div v-if="users.row.blocked==0">
            <button class="btn btn-sm btn-primary" v-on:click.prevent="blockUser(users.row)">Block</button>
          </div>
        </div>
      </div>
    </v-client-table>
  </div>
</template>

<script>
  module.exports = {
    props: ["users"],
    data: function() {
      return {
        activeUser: {},
        items: this.users,
        columns: ["image", "name", "username", "email", "type", "blocked", "actions"],
        options: {},
        size: 100,
        currentUser: this.$store.state.user
      };
    },
    methods: {
      editUser: function(user) {
        this.activeUser = user;
        this.$emit("edit-user", user);
        this.editingUser = true;
      },
      deleteUser: function(user) {
        this.$emit("delete-user", user);
      },
      blockUser: function(user) {
        this.$emit("block", user);
      },
      unblockUser: function(user) {
        this.$emit("unblock", user);
      }
    }
  };
</script>

<style scoped>
  button {
    margin-left: 5px;
    margin-right: 5px;
  }
</style>
