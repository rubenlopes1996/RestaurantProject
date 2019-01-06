<template>
    <div class="container content-admin">
        <!--<add-employee></add-employee>-->
        <div id="list">
            <!--<div class="alert alert-success" v-if="showSuccess">
                    <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ successMessage }}</strong>
                </div>-->
            <!--<user-edit :user="currentUser" @save-user="saveUser()" @cancel-edit="cancelEdit()"></user-edit>-->
            <invoice-payment :invoice="currentInvoice" @pay-invoice="payInvoice()" @cancel-edit="cancelEdit()"></invoice-payment>
            <list-invoices :invoices="invoices" @get-invoices="refreshInvoices" :newestTMealId="newestTMealId" :newMeal="newMeal" @edit-invoice="editInvoice"></list-invoices>
            <!--<list-invoices  @edit-user="editUser" @delete-user="deleteUser"></list-invoices>-->
        </div>
    </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      invoices: null,
      currentInvoice: null,
      action : [{
        text : 'X',
        onClick : (e, toastObject) => {
            toastObject.goAway(0);
        },
        user: this.$store.state.user
      }],
      newestTMealId: this.$route.params.newestMealId,
      newMeal: ''
    };
  },
  methods: {
    refreshInvoices: function(mealId){
      this.invoices = null;
      console.log("Chegou ao pai para pedir invoices, -->", mealId);
      this.getInvoices();
      this.newMeal=mealId;
    },
    editInvoice: function(invoice) {
      this.currentInvoice = Object.assign({}, invoice);
    },
    getInvoices: function() {

      axios.get("api/invoices?pending").then(response => {
        //this.invoices = response.data.data;
        this.invoices = response.data.data;
        console.log(this.invoices);
      });
    },
    payInvoice: function(){
      const invoice = this.currentInvoice;
      axios.put("api/invoices/" + this.currentInvoice.id, this.currentInvoice)
        .then(response => {
          this.$socket.emit('paidInvoice_to_admins', this.$store.state.user, this.currentInvoice.table_number, this.currentInvoice.id);
          this.currentInvoice = null;
          this.$toasted.success('Payment concluded with success!', {duration: 5000, position: 'bottom-center', action: this.action});
          this.getInvoices();
        })
        .catch(error => {
          this.$toasted.error('Something went wrong with the payment!', {duration: 5000, position: 'bottom-center', action: this.action});
          this.failMessage = error.response.data.message;
          console.log(error.response.data.message);
        });
    },
    
    cancelEdit: function() {
      //É necessario ??
      axios.get("api/invoices?pending" + this.currentInvoice.id).then(response => {
        // Copies response.data.data properties to this.currentInvoice
        // without changing this.currentInvoice reference
        
        Object.assign(this.currentInvoice, response.data.data);
        this.currentInvoice = null;
      });
    }
  },
  mounted() {
    this.getInvoices();
  }
};

</script>
