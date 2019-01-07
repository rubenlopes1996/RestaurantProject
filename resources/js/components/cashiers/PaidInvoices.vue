<template>
    <b-container>
      <b-row style="margin-top:70px">
          <b-col cols="12">
              <paid-invoices :newestInvoiceId="newestInvoiceId"></paid-invoices>
          </b-col>
      </b-row>
    </b-container>
</template>

<script>
module.exports = {
  data: function() {
    return {
      newestInvoiceId: this.$route.params.newestInvoiceId
    };
  }
}
</script>
