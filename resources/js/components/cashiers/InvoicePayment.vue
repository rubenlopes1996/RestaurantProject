<template>
    <div class="jumbotron" v-if="invoice">
        <h2>Invoice Payment</h2>
        <div class="form-group">
            <label for="inputNIF">NIF</label>
            <input type="number" class="form-control" v-model="invoice.nif" name="nif" id="inputNif" :placeholder="invoice.nif" value="" />
        </div>
        <div class="form-group">
            <label for="inputName">Customer Name</label>
            <input type="text" class="form-control" v-model="invoice.name" name="customer" id="inputCustomer" :placeholder="invoice.name" value="" />
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="payInvoice()">Pay</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
        </div>

    </div>
</template>

<script>
module.exports =  {
    props: ["invoice"],
  data: function() {
    return {};
  },
    methods: {
    payInvoice: function () {
      this.$emit("pay-invoice");
    },
    cancelEdit: function () {
      this.$emit("cancel-edit");
    }
    }
}
</script>
