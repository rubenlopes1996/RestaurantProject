<template>
  <div>
    <PacmanLoader class="pacman-loader" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="items == null"></PacmanLoader>
    <b-row>
      <b-col md="6" class="my-1" v-if="items!=null">
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
    <b-table hover :items="items" :fields="fields" v-if="items!=null" :filter="filter" :bordered="true">
      <template slot="id" slot-scope="data">
        <span v-if="data.value===newestInvoiceId || data.value===newInvoice" id="checkNew">
          <b-form-checkbox checked="true" disabled></b-form-checkbox>
        </span>
        <span v-else>
          
        </span>
      </template>
      <template slot="details" slot-scope="row">
      <!-- In some circumstances you may need to use @click.native.stop instead -->
      <!-- As `row.showDetails` is one-way, we call the toggleDetails function on @change -->
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
    <template slot="pdf" slot-scope="row">
      <vs-button @click.prevent="downloadPDF(row.item.id)" color="warning" type="filled">PDF</vs-button>
    </template>
    </b-table>
    <nav aria-label="Page navigation example" v-if="items!=null">
          <ul class="pagination">
              <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                <a class="page-link" href="#" @click.prevent="fecthPaidInvoices(pagination.prev_page_url)">Previous</a>
              </li>
              
              <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

              <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                <a class="page-link" href="#" @click.prevent="fecthPaidInvoices(pagination.next_page_url)">Next</a>
              </li>
          </ul>
      </nav>
  </div>
  
</template>

<script>
  module.exports = {
    props: ["newestInvoiceId"],
    data: function() {
      return {
        items: null,
        fields: [ 
            {key:'id', label: 'New', class: 'text-center'},
            {key:'details'},
            {key:'state', sortable: true},
            {key:'table_number', sortable: true},
            {key:'responsible_waiter', sortable: true},
            {key:'total_price', sortable: true},
            {key:'date', sortable: true},
            {key:'pdf'}
            ],
        pagination: {},
        filter: null,
        size: 30,
        newInvoice: -1,
      };
    },
    created() {
      this.fecthPaidInvoices();
    },
    methods: {
      fecthPaidInvoices(page_url) {
        let pg = this;
        page_url = page_url || "api/invoices/paid?page=1";
        axios
          .get(page_url)
          .then(response => {
            this.items = response.data.data;
            pg.makePagination(response.data.meta, response.data.links);
          })
          .catch(error => {
            console.log(error);
          });
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
      downloadPDF(invoice){
        console.log(invoice)
          axios({url:"api/paidInvoices/download/"+invoice ,method:'GET',responseType:'blob'}).then(response=>{
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'Invoice'+invoice+'.pdf');
            document.body.appendChild(link);
            link.click();
            console.log("success");
            
          }).catch(error=>{
            console.log("error");
          })
      },
    },
    sockets:{
      socketRefresh(dataFromServer){
        //console.log("AQUIII"+dataFromServer);
        this.newInvoice = dataFromServer;
        this.fecthPaidInvoices();
      }
    }
  };
</script>

<style>

</style>
