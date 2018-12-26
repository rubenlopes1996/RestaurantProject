<template>
    <div class="container content-admin">
        <div id="list">
            <paid-invoices :newestInvoiceId="newestInvoiceId"></paid-invoices>
        </div>
    </div>
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
