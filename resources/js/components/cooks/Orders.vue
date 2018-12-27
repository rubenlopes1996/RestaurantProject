<template>
  <div class="container content-admin">
    <div id="list">
      <div class="alert alert-success" v-if="showSuccess">
        <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false">
                <span aria-hidden="true">&times;</span>
              </button>
        <strong>{{ successMessage }}</strong>
      </div>
      <order-list :orders="orders" @inPreparation="inPreparation" @prepared="prepared"></order-list>
    </div>
  </div>
</template>

<script>
  export default {
    data: function() {
      return {
        orders: null,
        successMessage: "",
        showSuccess: false,
        user: this.$store.state.user
      };
    },
    methods: {
      getOrders: function() {
        axios.get("api/orders/" + this.user.id).then(response => {
          this.orders = response.data.data;
          console.log(response.data.data);
        });
      },
      inPreparation: function(order) {
        axios.patch('/api/orders/inPreparation/'+order.id).then(response => {
            this.getOrders();
          })
          .catch(error => {
            console.log(error.response.data.message);
            this.failMessage = error.response.data.message;
          });
      },
      prepared: function(order) {
         axios.patch('/api/orders/prepared/'+order.id).then(response => {
            this.getOrders();
          })
          .catch(error => {
            console.log(error.response.data.message);
            this.failMessage = error.response.data.message;
          });
      }
    },
    mounted() {
      this.getOrders();
    }
  };
</script>
