<template>
    <div class="container content-admin">
        <div id="list">
            <div class="alert alert-success" v-if="showSuccess">
                <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false"><span aria-hidden="true">&times;</span></button>
                <strong>{{ successMessage }}</strong>
            </div>
            <item-edit :item="currentItem" @save-item="saveItem()" @cancel-edit="cancelEdit()"></item-edit>
            <item-list :items="items" @edit-item="editItem" @delete-item="deleteItem"></item-list>
        </div>
    </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      editingItem: false,
      showSuccess: false,
      showFailure: false,
      successMessage: "",
      failMessage: "",
      currentItem: null,
      newItem: null,
      items: []
    };
  },
  methods: {
    editItem: function(item) {
      this.currentItem = Object.assign({}, item);
      this.editingItem = true;
      this.showSuccess = false;
    },

    deleteItem: function(item) {
      if (item === this.currentItem) {
        this.currentItem = null;
      }
      axios
        .delete("api/menu/" + item.id)
        .then(response => {
          this.showSuccess = true;
          this.successMessage = "Item Deleted";
          this.getItems();
        })
        .catch(error => {
          console.log(error.response.data.message);
          this.failMessage = error.response.data.message;
        });
    },
    saveItem: function() {
      this.editingItem = false;
      const item = this.currentItem;
      axios
        .put("api/menu/" + this.currentItem.id, this.currentItem)
        .then(response => {
          this.showSuccess = true;
          this.successMessage = "Item Saved";
          // Copies response.data.data properties to this.currentUser
          // without changing this.currentUser reference
          Object.assign(this.currentItem, response.data.data);
          this.items.forEach(u => {
            if (u.id == item.id) {
              u = Object.assign(u, item);
            }
          });
        })
        .catch(error => {
          this.showFailure = true;
          this.showSuccess = false;
          this.failMessage = error.response.data.message;
        });
    },
    cancelEdit: function() {
      this.showSuccess = false;
      this.editingUser = false;
      axios.get("api/menu/" + this.currentItem.id).then(response => {
        // Copies response.data.data properties to this.currentUser
        // without changing this.currentUser reference
        Object.assign(this.currentItem, response.data.data);
        this.currentUser = null;
      });
    },
    getItems: function() {
      axios.get("api/menu").then(response => {
        this.items = response.data.data;
      });
    }
  },

  mounted() {
    this.getItems();
  }
};
</script>
