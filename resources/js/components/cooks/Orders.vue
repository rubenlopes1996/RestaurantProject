<template>
  <div class="container content-admin">
    <div id="list">
      <div class="alert alert-success" v-if="showSuccess">
        <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false">
                <span aria-hidden="true">&times;</span>
              </button>
        <strong>{{ successMessage }}</strong>
      </div>
      <order-list :orders="orders" :pagination="pagination" @inPreparation="inPreparation" @prepared="prepared" @getOrders="getOrders"></order-list>
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
        user: this.$store.state.user,
        pagination: {},
        currentPage: 1,
      };
    },
    methods: {
      getOrders: function(page_url) {
        let pg = this;
        page_url = page_url || "api/orders/" + this.user.id +"?page=1";

        axios.get(page_url).then(response => {
          this.orders = response.data.data;
          console.log(response.data.data);
          pg.makePagination(response.data.meta, response.data.links);
        });
      },
         refreshOrders: function(){
        this.getOrders();
      },
      makePagination(meta, links) {
        let pagination = {
          current_page: meta.current_page,
          last_page: meta.last_page,
          next_page_url: links.next,
          prev_page_url: links.prev
        };
        this.pagination = pagination;
      },
      inPreparation: function(order) {
        axios.patch('/api/orders/inPreparation/'+order.id).then(response => {
            this.getOrders();
            //sockets
            this.$socket.emit('orderChangedState');
          })
          .catch(error => {
            console.log(error.response.data.message);
            this.failMessage = error.response.data.message;
          });
      },
      prepared: function(order) {
         axios.patch('/api/orders/prepared/'+order.id).then(response => {
            this.getOrders();
            //sockets
            this.$socket.emit('orderChangedState');
            this.$socket.emit('orderPrepared_to_waiter', order.responsible_waiter_id);
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
