<template>
    <div class="container content-admin">
        <div id="list">
            <paid-invoices :paidinvoices="paidinvoices"></paid-invoices>
        </div>
    </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      paidinvoices: []
    };
  },
  methods: {
    getPaidInvoices: function() {
      axios.get("api/invoices?paid").then(response => {
        this.paidinvoices = response.data.data;
      });
    }
  },

  mounted() {
    this.getPaidInvoices();
  }
};
</script>
