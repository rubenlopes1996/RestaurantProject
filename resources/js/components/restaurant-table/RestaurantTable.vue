<template>
  <div class="container content-admin">
    <table-add @save-table="saveTable"></table-add>
    <div id="list">
      <div class="alert alert-success" v-if="showSuccess">
        <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false"><span aria-hidden="true">&times;</span></button>
        <strong>{{ successMessage }}</strong>
      </div>
      <table-edit :tables="currentTable" @save-table="saveTable()" @cancel-edit="cancelEdit()"></table-edit>
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
        tables: null,
      };
    },
    methods: {
      saveTable: function(table) {
        console.log(table)
        axios.post("api/restaurant-tables", table)
          .then(response => {
            this.successMessage = "Table Created";
            this.$toasted.success('Table created with success!', {duration: 5000, position: 'top-center'});
            
            this.getTables();
          })
          .catch(error => {
            this.$toasted.error('Something went wrong creating the table!', {duration: 5000, position: 'bottom-center'});
            console.log(error);
            console.log(error.response.data.message);
          });
      },
      editTable: function() {},
      deleteTable: function(table) {
        if (table === this.currentTable) {
          this.currentTable = null;
        }
        axios
          .delete("api/restaurant-tables/" + table.table_number)
          .then(response => {
            this.showSuccess = true;
            this.successMessage = "Table Deleted";
            this.getTables();
          })
          .catch(error => {
            console.log(error.response.data.message);
            this.failMessage = error.response.data.message;
          });
      },
      getTables: function() {
        axios.get("api/restaurant-tables").then(response => {
          this.tables = response.data.data;
        });
        
      }
    },
    mounted() {
      this.getTables();
    },
  }
</script>

