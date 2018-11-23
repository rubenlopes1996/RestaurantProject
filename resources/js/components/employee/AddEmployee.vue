<template>
    <div class="jumbotron">
        <h2>Add employee</h2>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input type="name" class="form-control" v-model="name" name="name" id="name" placeholder="Name" />
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" class="form-control" v-model="email" name="email" id="email" placeholder="Email address" />
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <select class="form-control" v-model="type" id="type" name="type">
                    <option> manager </option>
                    <option> cashier </option>
                    <option> waiter </option>
                    <option> cooker </option>
                </select>
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveEmployee()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancel()">Cancel</a>
        </div>
    </div>
</template>

<script>
export default {
  data: function() {
    return {
      name: "",
      email: "",
      type: ""
    };
  },

  methods: {
    saveEmployee: function() {
      let user = {
        name: this.name,
        email: this.email,
        type: this.type
      };
      axios
        .post("api/register", user)
        .then(response => {
          this.successMessage = "Employee Created";
          console.log(response);
        })
        .catch(error => {
          console.log(error);
          console.log(error.response.data.message);
        });
    }
  }
};
</script>

