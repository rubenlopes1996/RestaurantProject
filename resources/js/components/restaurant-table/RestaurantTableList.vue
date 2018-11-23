<template>
   <div>
      <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="notLoaded"></PacmanLoader>
      <v-client-table ref="table" :data="tables" :columns="columns" :options="options" id="buttons" v-else>
         <div slot="actions" slot-scope="tables" align="center">
            <button class="btn btn-sm btn-primary" v-on:click.prevent="editTable(tables.row)">Edit</button>
            <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteTable(tables.row)">Delete</button>
         </div>
      </v-client-table>
   </div>
</template>

<script>
   module.exports = {
      data: function() {
         return {
            activeTable: {},
            tables: this.tables,
            columns: ["table_number", "Actions"],
            options: {},
            notLoaded: false
         };
      },
      created() {
         this.fecthTables();
         
      },
      methods: {
         editUser: function(table) {
            this.activeTable = table;
            this.$emit("edit-table", table);
            this.editingTable = true;
         },
         deleteUser: function(table) {
            this.$emit("delete-table",table);
   
         },
         fecthTables(page_url) {
            let pg = this;
            page_url = page_url || "api/restaurant-tables";
            axios
               .get(page_url)
               .then(response => {
                  notLoaded = false;
                  this.tables = response.data.data;
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
