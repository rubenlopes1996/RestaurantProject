<template>
    <b-container>
          <b-row>
            <b-col cols="12">
              <invoice-payment :invoice="currentInvoice" @pay-invoice="payInvoice()" @cancel-edit="cancelEdit()"></invoice-payment>
              <list-invoices :invoices="invoices" @get-invoices="refreshInvoices" :newestTMealId="newestTMealId" :newMeal="newMeal" @edit-invoice="editInvoice"></list-invoices>
            </b-col>
          </b-row>
    </b-container>
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
