<template>
        <b-container style="margin-top:70px">
            <b-row>
                <b-col cols="4">
                </b-col>
                <b-col cols="4">
                <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="preparedItems==null"></PacmanLoader>
                </b-col>
                <b-col cols="4">
                </b-col>
            </b-row>
        
        <b-row>
            <b-col md="6" class="my-1" v-if="preparedItems!=null">
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

        <b-row >
            <b-table hover :items="preparedItems" :fields="fields" v-if="preparedItems!=null" :filter="filter" :per-page="perPage" :current-page="currentPage" :bordered="true">
                <template slot="actions" slot-scope="row">

                    <b-button v-on:click.prevent="deliveredOrder(row.item.id)">Delivered this Order</b-button>

                </template>
            </b-table>
            <b-pagination v-if="preparedItems!=null" :total-rows="preparedItems.length" v-model="currentPage" :per-page="perPage">
            </b-pagination>
        </b-row>
    </b-container>
</template>
<script>
    export default {
        data: function () {
            return {
                preparedItems:null,

                items: [],
                fields: [
                    {key:'id'},
                    {key:'state', sortable: true,},
                    {key:'item_id', sortable: true},
                    {key:'meal_id', sortable: true},
                    {key:'responsible_cook_id', sortable: true},
                    {key:'actions', sortable: true},
                ],
                filter: null,
                currentPage: 1,
                perPage: 10,
                size: 30,



            }
        },
        methods: {
            deliveredOrder(id) {
                console.log(id);

                axios
                    .patch("api/waiter/order/"+id+"/delivered")
                    .then(response => {
                        this.$toasted.success('Order has been delivered!', {duration: 2000, position: 'top-center'});
                        this.fetchOrdersPrepared();

                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            fetchOrdersPrepared: function () {
                axios
                    .get("api/waiter/" + this.$store.state.user.id + "/orders/prepared")
                    .then(response => {
                        this.preparedItems = response.data;



                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            }
        },
        mounted() {
           this.fetchOrdersPrepared();
        },
    }

</script>
