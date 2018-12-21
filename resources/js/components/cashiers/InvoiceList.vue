<template>
    <div>
        <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="invoices==null"></PacmanLoader>
        <v-client-table ref="table" :data="invoices" :columns="columns" :options="options" id="buttons" v-if="invoices!=null">
            <div slot="actions" slot-scope="invoices" align="center">
                <button class="btn btn-sm btn-danger" v-on:click.prevent="editInvoice(invoices.row)">Payment</button>
            </div>
            <div slot="child_row" slot-scope="invoices">
                <div v-for="(in_I, index) in invoices.row.invoice_items" :key="in_I.id">
                    Quantity:<b> {{in_I.quantity}}</b>
                    <br> Unit Price: {{in_I.unit_price}} €<br> Sub Total: <b>{{in_I.sub_total_price}} €</b>
                    <br> &nbsp;Name: {{invoices.row.items_consumed[index].name}}<br> &nbsp;Created: {{invoices.row.items_consumed[index].created_at}}<br> &nbsp;Type: {{invoices.row.items_consumed[index].type.toUpperCase()}}<br><br>
                </div>
            </div>
        </v-client-table>
    </div>
</template>

<script>
module.exports = {
  props: ["invoices"],
  data: function() {
    return {
      columns: [
        "state",
        "table_number",
        "responsible_waiter",
        "total_price",
        "date",
        "actions"
      ],
      options: {
        highlightMatches: "pending"
      },
      size: 10,
    };
  },
  methods: {
    editInvoice: function(invoice) {
      this.$emit("edit-invoice", invoice);
    }
  }
};
</script>

<style>
.VueTables__child-row-toggler {
  width: 16px;
  height: 16px;
  line-height: 16px;
  display: block;
  margin: auto;
  text-align: center;
}

.VueTables__child-row-toggler--closed::before {
  content: "\f06e";
  font-family: FontAwesome;
}

.VueTables__child-row-toggler--open::before {
  content: "\f070";
  font-family: FontAwesome;
}
</style>
