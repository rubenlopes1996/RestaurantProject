<template>
    <div>
        <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="orders==null"></PacmanLoader>
        <b-row>
          <b-col md="6" class="my-1" v-if="orders!=null">
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
        <b-table hover :items="orders" :fields="fields" v-if="orders!=null" :filter="filter" :per-page="perPage" :current-page="currentPage" :bordered="true">
        <template slot="id" slot-scope="data">
            <span v-if="data.value===newestOrderId" id="checkNew">
              <b-form-checkbox checked="true" disabled></b-form-checkbox>
            </span>
        </template>
        <template slot="actions" slot-scope="row">
                <div v-if="row.item.state == 'confirmed' && row.item.type != 'drink' && row.item.type != 'dessert'">
                    <button class="btn btn-sm btn-success" v-on:click.prevent="inPreparation(row.item)">In preparation</button>
                </div>
                <div v-if="row.item.state == 'in preparation' || row.item.type == 'drink' || row.item.type == 'dessert'">
                    <button class="btn btn-sm btn-primary" v-on:click.prevent="prepared(row.item)">Prepared</button>
                </div>
        </template>
      </b-table>
        <nav aria-label="Page navigation example" v-if="orders!=null">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click.prevent="getOrders(pagination.prev_page_url)">Previous</a>
                </li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click.prevent="getOrders(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    module.exports = {
        props: {orders: Array, newestOrderId: '', pagination: ''},
        data: function() {
            return {
                size: 100,
                fields: [ 
                    {
                        key: 'id',
                        label: 'New'
                    },
                    {key:'state'},
                    {key:'item_id'},
                    {key:'meal_id', sortable: true},
                    {key:'start', sortable: true},
                    {key:'actions', sortable: true}
                ],
                filter: null,
                currentPage: 1,
                perPage: 10,

            };
        },
        methods: {
            inPreparation: function(order) {
                this.$emit("inPreparation", order);

            },
            prepared: function(order) {
                this.$emit("prepared", order);
             },
            getOrders: function(pagination) {
                this.$emit("getOrders", pagination);
            },
        },
    sockets:{
      socketRefreshOrders(){
        this.$emit("get-orders");
        
      }
    }
    };
</script>

<style>
    #table {
        margin-top: 200px;
    }

    .color-success td:nth-child(2) {
        color: darkgreen;
    }
</style>
