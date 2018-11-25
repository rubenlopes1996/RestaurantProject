<template>
   <div>
      <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="inload"></PacmanLoader>
      <v-client-table :data="tables" :columns="columns" :options="options" id="buttons" v-else >
         <div slot="actions" slot-scope="tables" align="center">
           <button class="btn btn-sm btn-primary" v-on:click.prevent="editTable(tables.row)">Edit</button>
            <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteTable(tables.row)">Delete</button>
         </div>
      </v-client-table>
   </div>
</template>

<script>
module.exports = {
  props: ["tables"],
  data: function() {
    return {
      activeTable: {},
      items: this.tables,
      columns: ["table_number", "actions"],
      options: {},
      inload: false
    };
  },
 /* mounted() {
    this.fecthTables();
  },*/
  created() {
    this.fecthTables();
  },
  methods: {
    editTable: function(table) {
      this.activeTable = table;
      this.$emit("edit-table", table);
      this.editingTable = true;
    },
    deleteTable: function(table) {
      this.$emit("delete-table", table);
    },
    fecthTables(page_url) {
      inload = true;
      let pg = this;
      page_url = page_url || "api/restaurant-tables";
      axios
        .get(page_url)
        .then(response => {
          inload = false;
          this.items = response.data.data;
        })
        .catch(error => {
          inload = false;
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
