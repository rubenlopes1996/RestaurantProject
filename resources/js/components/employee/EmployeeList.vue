<template>
    <div>
        <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="notLoaded"></PacmanLoader>
        <v-client-table ref="table" :data="users" :columns="columns" :options="options" id="buttons" v-else>
            <div slot="actions" slot-scope="users" align="center">
                <button class="btn btn-sm btn-primary" v-on:click.prevent="editUser(users.row)">Edit</button>
                <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(users.row)">Delete</button>
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
      columns: ["name", "email", "type", "actions"],
      options: {},
      size: 10,
      notLoaded: false
    };
  },
  created() {
    this.fecthEmployees();
  },
  methods: {
    editUser: function(user) {
      this.activeUser = user;
      this.$emit("edit-user", user);
      this.editingUser = true;
    },
    deleteUser: function(user) {
      this.$emit("delete-user", user);
      //Vue.set(this.$emit, "delete-user", user);
    },
    fecthEmployees(page_url) {
      let pg = this;
      page_url = page_url || "api/employees";
      axios
        .get(page_url)
        .then(response => {
          notLoaded = false;
          this.items = response.data.data;
        })
        .catch(error => {
          console.log(error);
          notLoaded = false;
        });
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
