<template>
    <div>
        <b-container>
            <b-row>
                <b-col cols="4">
                </b-col>
                <b-col cols="4">
                <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="orders==null"></PacmanLoader>
                </b-col>
                <b-col cols="4">
                </b-col>
            </b-row>
        </b-container>
        <b-row>
            <b-col md="6" class="my-1" v-if="orders!=null">
                <b-form-group horizontal label="Filter" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Search" />
                        <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>
        <b-table hover :items="orders" :fields="fields" v-if="orders!=null" :filter="filter" :per-page="perPage" :current-page="currentPage" :bordered="true">
    
        </b-table>
        <b-pagination v-if="orders!=null" :total-rows="orders.length" v-model="currentPage" :per-page="perPage">
        </b-pagination>
    </div>
</template>

<script>
    export default {
    
        data() {
            return {
                makePag: [],
                orders: null,
                fields: [
                    {
                        key: 'id',
                        label: 'New'
                    },
                    {
                        key: 'state',
                        sortable: true
                    },
                    {
                        key: 'item_id',
                        sortable: true
                    },
                    {
                        key: 'meal_id',
                        sortable: true
                    },
                    {
                        key: 'responsible_cook_id',
                        sortable: true
                    },
                    {
                        key: 'start',
                        sortable: true
                    },
    
                ],
                filter: null,
                currentPage: 1,
                perPage: 10,
                size: 30,
            };
        },
        methods:{
            fetchPendingAndConfirmedOrders(){
                axios
                .get("api/waiter/list-orders/pending/confirmed")
                .then(response => {
                    this.orders = response.data.data;
                    console.log(this.orders);
                })
                .catch(error => {
                    console.log(error);
                });
            }
        },
        sockets:{
            socketRefreshPCOrders(){
                //this.$toasted.success('Order Prepared', {duration: 2000, position: 'top-right'});
                this.fetchPendingAndConfirmedOrders();
            }
        },
        created() {
            this.fetchPendingAndConfirmedOrders();
        },
    
    };
</script>
