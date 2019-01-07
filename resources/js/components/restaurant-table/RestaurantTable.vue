<template>
  <b-container>
    <b-row style="margin-top:70px">
        <b-col cols="12">
          <table-add @save-table="saveTable"></table-add>
          <div id="list">
            <div class="alert alert-success" v-if="showSuccess">
              <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false"><span aria-hidden="true">&times;</span></button>
              <strong>{{ successMessage }}</strong>
            </div>
            <table-edit :tables="currentTable" @save-table="saveTable()" @save-edited="saveEditedTable" @cancel-edit="cancelEdit"></table-edit>
            <table-list :tables="tables" @edit-table="editTable"  @delete-table="deleteTable"></table-list>
          </div>
        </b-col>
    </b-row>
  </b-container>
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
        table : null
      };
    },
    methods: {
      saveEditedTable: function () {
        this.editingTable= false;
        console.log(this.currentTable);
        axios.put("api/restaurant-table/" + this.table.table_number, this.currentTable)
          .then(response => {
            this.showSuccess = true;
            this.$toasted.success('Restaurant table edited with success!', {duration: 5000, position: 'top-center'});
            Object.assign(this.currentTable, response.data);
            this.getTables();

          })
          .catch(error => {
            this.showFailure = true;
            this.showSuccess = false;
            this.failMessage = error.response.data.message;
            console.log(error.response.data.message);
          });
    },
      cancelEdit : function () {
        console.log("culpa do afonso!!")
        this.showSuccess = false;
        this.editingTable = false;
        this.currentTable = null;
      },
      saveTable: function(table) {
        this.editingTable = false;
        console.log(table);
        axios.post("api/restaurant-tables", table)
          .then(response => {
            this.successMessage = "Table Created";
            this.$toasted.success('Table created with success!', {duration: 3000, position: 'top-center',theme:'bubble'});
            
            this.getTables();
          })
          .catch(error => {
            this.$toasted.error('Something went wrong creating the table!', {duration: 3000, position: 'bottom-center',theme:'bubble'});
            console.log(error);
            console.log(error.response.data.message);
          });
      },
      editTable: function(table) {
        this.table = table;
        this.currentTable = Object.assign({}, table);
        this.editingTable = true;
        this.showSuccess = false;
      },
      deleteTable: function(table) {
        if (table === this.currentTable) {
          this.currentTable = null;
        }
        axios
          .delete("api/restaurant-tables/" + table.table_number)
          .then(response => {
            this.$toasted.success('Table has been deleted!', {duration: 3000, position: 'top-center',theme:'bubble'});
            this.getTables();
          })
          .catch(error => {
            console.log(error.response.data.message,'dsadjoisao');
            this.$toasted.error('You can\'t delete this table!', {duration: 3000, position: 'bottom-center',theme:'bubble'});
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

