<template>
    <div>
        <PacmanLoader class="pacman-loader" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="invoices==null"></PacmanLoader>
        <b-row>
          <b-col md="6" class="my-1" v-if="invoices!=null">
            <b-form-group horizontal label="Filter" class="mb-0">
              <b-input-group>
                <b-form-input v-model="filter" placeholder="Type to Search" />
                <b-input-group-append>
                  <b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>
        </b-row>
        <b-table hover :items="invoices" :fields="fields" v-if="invoices!=null" :filter="filter" :per-page="perPage" :current-page="currentPage" :bordered="true">
          <template slot="meal_id" slot-scope="data">
            <span v-if="data.value===newMeal || data.value===newestTMealId" id="checkNew">
              <b-form-checkbox checked="true" disabled></b-form-checkbox>
            </span>
            <span v-else>
              <p>{{data.value}}</p>
            </span>
          </template>
          <template slot="details" slot-scope="row">
          <b-form-checkbox @click.native.stop @change="row.toggleDetails" v-model="row.detailsShowing">
            Details
          </b-form-checkbox>
        </template>
        <template slot="row-details" slot-scope="row">
          <b-card>
            <b-button @click="row.toggleDetails">Hide Details</b-button>
            <b-row class="lg-10">
              
              <div v-for="(in_I, index) in row.item.invoice_items" :key="in_I.id">
              Quantity:<b> {{in_I.quantity}}</b>
              <br> Unit Price: {{in_I.unit_price}} €<br> Sub Total: <b>{{in_I.sub_total_price}} €</b>
              <br> &nbsp;Name: {{row.item.items_consumed[index].name}}<br> &nbsp;Created: {{row.item.items_consumed[index].created_at}}
              <br> &nbsp;Type: {{row.item.items_consumed[index].type.toUpperCase()}}<br><br>
            </div>
            </b-row>
          </b-card>
        </template>
        <template slot="payment" slot-scope="row">
          <vs-button color="success" type="filled" v-on:click.prevent="editInvoice(row.item)">Payment</vs-button>
        </template>
      </b-table>
      <b-pagination v-if="invoices!=null" :total-rows="invoices.length" v-model="currentPage" :per-page="perPage">
      </b-pagination>
    </div>
</template>

<script>
module.exports = {
  props: {invoices: Array, newestTMealId:'', newMeal: ''},
  data: function() {
    return {
      items: null,
      fields: [ 
            {key:'meal_id', label: 'New', class: 'text-center'},
            {key:'details'},
            {key:'state', sortable: true, variant: 'warning'},
            {key:'table_number', sortable: true},
            {key:'responsible_waiter', sortable: true},
            {key:'total_price', sortable: true},
            {key:'date', sortable: true},
            {key:'payment'}
            ],
      filter: null,
      currentPage: 1,
      perPage: 10,
      size: 30
    };
  },
  methods: {
    editInvoice: function(invoice) {
      this.$emit("edit-invoice", invoice);
    }
  },
  sockets:{
    socketRefreshMeals(dataFromServer){
      //this.getInvoices();
      //this.newMeal = dataFromServer;
      
      this.$emit("get-invoices", dataFromServer);
      console.log("Chegou ao filho", dataFromServer);
      
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
