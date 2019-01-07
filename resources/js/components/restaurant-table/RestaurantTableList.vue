<template>
  <div>
    <b-container>
      <b-row>
        <b-col cols="4">
        </b-col>
        <b-col cols="4">
        <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="tables==null"></PacmanLoader>
        </b-col>
        <b-col cols="4">
        </b-col>
      </b-row>
    </b-container>
    <v-client-table :data="tables" :columns="columns" id="buttons" v-if="tables!=null">
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
        columns: ["table_number", "actions"],
        size: 30
      };
    },
    methods: {
      editTable: function(table) {
        this.activeTable = table;
        this.$emit("edit-table", table);
        this.editingTable = true;
      },
      deleteTable: function(table) {
        this.$emit("delete-table", table);
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
