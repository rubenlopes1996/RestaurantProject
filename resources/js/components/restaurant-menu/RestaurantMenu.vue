<template>
  <div class="container content-admin">
    <item-add @create-item="createItem"></item-add>

      <item-edit :items="currentItem" @save-item="saveItem()" @cancel-edit="cancelEdit()"></item-edit>
      <item-list :items="items" @edit-item="editItem" @delete-item="deleteItem"></item-list>

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
        items: null,
      };
    },
    methods: {
      editItem: function(item) {

        this.currentItem = Object.assign({}, item);
        this.editingItem = true;
        this.showSuccess = false;
      },
  
      deleteItem: function(item) {
        axios
          .delete("api/menu/" + item.id)
          .then(response => {
            this.$toasted.success('Item has been deleted!', {duration: 3000, position: 'top-center',theme:'bubble'});
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
            this.$toasted.success('Item has been edited!', {duration: 3000, position: 'top-center',theme:'bubble'});
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
      createItem: function(items,files) {
        const formData = new FormData();
        formData.append("photo", files[0]);
        formData.append("name", items.name);
        formData.append("description", items.description);
        formData.append("type", items.type);
        formData.append("price", items.price);
  
        axios
          .post("api/menu", formData)
          .then(response => {
            this.$toasted.success('Item has been created!', {duration: 3000, position: 'top-center',theme:'bubble'});
            this.getItems();
          })
          .catch(error => {
            console.log(error);
            console.log(error.response.data.message);
            this.$toasted.error('Something is wrong with your item, please try again!', {duration: 3000, position: 'bottom-center',theme:'bubble'});
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


