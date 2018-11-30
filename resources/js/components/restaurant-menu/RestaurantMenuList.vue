<template>
    <div>
        <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="notLoaded"></PacmanLoader>
        <v-client-table ref="table" :data="items" :columns="columns" :options="options" id="buttons" v-else>
            <div slot="actions" slot-scope="items" align="center">
                <button class="btn btn-sm btn-primary" v-on:click.prevent="editItem(items.row)">Edit</button>
                <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteItem(items.row)">Delete</button>
            </div>
        </v-client-table>
    </div>
</template>
<script>
module.exports = {
  props: ["items"],
  data: function() {
    return {
      activeItem: {},
      itemsMenu: this.items,
      columns: ["photo_url","name","type","description","price","actions"],
      options: {},
      size: 10,
      notLoaded: false
    };
  },
  created() {
    this.fecthItems();
  },
  methods: {
    editItem: function(item) {
      this.activeItem = item;
      this.$emit("edit-item", item);
      this.editItem = true;
    },
    deleteItem: function(item) {
      this.$emit("delete-item", item);
      //Vue.set(this.$emit, "delete-user", user);
    },
    fecthItems(page_url) {
      let pg = this;
      page_url = page_url || "api/menu";
      axios
        .get(page_url)
        .then(response => {
          notLoaded = false;
          this.itemsMenu = response.data.data;
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
