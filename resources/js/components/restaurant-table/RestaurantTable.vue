<template>
  <div class="container content-admin">
    <!--<add-employee ></add-employee>-->
    <div id="list">
      <div class="alert alert-success" v-if="showSuccess">
        <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false"><span aria-hidden="true">&times;</span></button>
        <strong>{{ successMessage }}</strong>
      </div>
      <!--<user-edit :user="currentUser" @save-user="saveUser()" @cancel-edit="cancelEdit()"></user-edit>-->
      <table-list :tables="tables" @edit-table="editTable" @delete-table="deleteTable"></table-list>
    </div>
  </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      editingTable: false,
      showSuccess: false,
      showFailure: false,
      successMessage: "",
      failMessage: "",
      currentTable: null,
      newTable: null,
      tables: []
    };
  },
  methods: {
    editTable: function() {},
    deleteTable: function() {}
  }
};
</script>
