<template>
    <div>
        <!--<PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="notLoaded"></PacmanLoader>-->
        <v-client-table ref="table" :data="items" :columns="columns" :options="options" id="buttons">
            <div slot="actions" slot-scope="items" align="center">
                <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(items.row)">to PDF</button>
            </div>
            <div slot="child_row" slot-scope="items">
                <div v-for="(in_I, index) in items.row.invoice_items" :key="in_I.id">
                    Quantity:<b> {{in_I.quantity}}</b>
                    <br> Unit Price: {{in_I.unit_price}} €<br> Sub Total: <b>{{in_I.sub_total_price}} €</b>
                    <br> &nbsp;Name: {{items.row.items_consumed[index].name}}<br>
                     &nbsp;Created: {{items.row.items_consumed[index].created_at}}<br> &nbsp;Type: {{items.row.items_consumed[index].type.toUpperCase()}}<br><br>
                </div>
            </div>

        </v-client-table>
    </div>
</template>

<script>
module.exports = {
  props: ["paidinvoices"],
  data: function() {
    return {
      items: this.paidinvoices,
      columns: [
        "state",
        "table_number",
        "responsible_waiter",
        "total_price",
        "date",
        "actions"
      ],
      options: {
        dateColumns: ["date"],
        dateFormat: "YYYY-MM-DD",
        datepickerOptions: {
          showDropdowns: true,
          autoUpdateInput: true
        }
      },
      size: 10,
      notLoaded: false
    };
  },
  created() {
    this.fecthPaidInvoices();
  },
  methods: {
    fecthPaidInvoices(page_url) {
      let pg = this;
      page_url = page_url || "api/invoices?paid";
      axios
        .get(page_url)
        .then(response => {
          notLoaded = false;
          this.items = response.data.data;
        })
        .catch(error => {
          console.log(error);
          notLoaded = false;
        });
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
