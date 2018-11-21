<template>
    <!--<div class="lg-12 md-6 xs-4">
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
                  </div>-->
    <div>
        <!--<v-client-table ref="table" :data="items" :columns="columns" :options="options" id="buttons">
                <button slot="actions" slot-scope="props" class="btn btn-sm btn-primary" v-on:click.prevent="editUser(props.row)">Edit</button>
                <button slot="actions" slot-scope="props" class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(props.row)">{{props.row}}</button>
        </v-client-table>-->
        <v-client-table ref="table" :data="users" :columns="columns" :options="options" id="buttons">
            <div slot="actions" slot-scope="users" align="center">
                <button class="btn btn-sm btn-primary" v-on:click.prevent="editUser(users.row)">Edit</button>
                <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(users.row)">Delete</button>
            </div>
        </v-client-table>
    </div>
</template>

<script>
//import Vuetable from "vuetable-2";
//import VuetablePagination from "vuetable-2/src/components/VuetablePagination";

module.exports = {
  props: ["users"],
  data: function() {
    return {
      activeUser: {},
      items: this.users,
      columns: ["name", "email", "type", "actions"],
      options: {}
    };
  },
  created() {
    this.fecthEmployees();
  },
  methods: {
    editUser: function(user) {
      this.activeUser = user;
      this.$emit("edit-user", user);
      this.editingUser = false;
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
          this.items = response.data.data;
        })
        .catch(error => {
          console.log(error);
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
