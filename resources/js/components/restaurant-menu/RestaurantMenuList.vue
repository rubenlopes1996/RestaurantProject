<template>
  <div>
    <b-container>
      <b-row>
        <b-col cols="4">
        </b-col>
        <b-col cols="4">
        <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="items==null"></PacmanLoader>
        </b-col>
        <b-col cols="4">
        </b-col>
      </b-row>
    </b-container>
    <v-client-table ref="table" :data="items" :columns="columns" :options="options" id="buttons" v-if="items != null">
      <div slot="actions" slot-scope="items" align="center">
        <button class="btn btn-sm btn-primary" v-on:click.prevent="editItem(items.row)">Edit</button>
        <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteItem(items.row)">Delete</button>
      </div>
      <div slot="image" slot-scope="items" align="center">
        <img :src="'storage/items/'+items.row.photo_url" alt="" width="50" height="50">
      </div>
    </v-client-table>
  </div>
</template>

<script>
  module.exports = {
    props:["items"],
    data: function() {
      return {
        activeItem: {},
        columns: ["image", "name", "type", "description", "price", "actions"],
        options: {},
        size: 30,
      };
    },
    methods: {
      editItem: function(item) {
        this.$emit("edit-item", item);
      },
      deleteItem: function(item) {
        this.$emit("delete-item", item);
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
