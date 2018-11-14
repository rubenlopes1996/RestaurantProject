<template>
    <div class="jumbotron" v-if="user">
        <h2>Add employee</h2>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" class="form-control" v-model="user.email" name="email" id="inputEmail" placeholder="Email address" value="" />
        </div>
        <div class="form-group">
            <label for="type_id">Type:</label>
            <select class="form-control" id="type_id" name="type_id" v-model="user.type">
                        <option v-for="user in users" v-bind:value="user.id" :key="user.id"> {{ user.type }} </option>
                    </select>
        </div>

        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveEmployee()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancel()">Cancel</a>
        </div>

    </div>
</template>

<script>
module.exports = {
  props: ["user"],

  data: function() {
    return {};
  },
  methods: {
    saveEmployee: function() {
      this.$emit("save-employee");
    },
    cancel: function() {
      this.$emit("cancel");
    }
  }
};
</script>

