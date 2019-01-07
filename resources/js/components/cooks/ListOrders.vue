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
      <b-pagination v-if="orders!=null" :total-rows="orders.length" v-model="currentPage" :per-page="perPage">
      </b-pagination>
    </div>
</template>

<script>
    module.exports = {
        props: {orders: Array, newestOrderId: ''},
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
                

             }
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
