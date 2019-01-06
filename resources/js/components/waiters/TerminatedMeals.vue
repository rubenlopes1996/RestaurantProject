<template>
    <div>
        <b-modal v-model="modalShow" @ok="handleOk()">
            Are you sure you want to terminated this meal ?
        </b-modal>
            <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="meals==null"></PacmanLoader>
            <b-row>
                <b-col md="6" class="my-1" v-if="meals!=null">
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
            <b-table hover :items="meals" :fields="fields" v-if="meals!=null" :filter="filter" :per-page="perPage" :current-page="currentPage" :bordered="true">

                    <template slot="actions" slot-scope="row">
                        <div>
                            <b-button @click="()=> {modalShow = !modalShow; itemIdTerminatedMeal=row.item.id, terminatedMeal_tableNumber=row.item.table_number}"  >
                                Terminate
                            </b-button>


                        </div>
                    </template>

            </b-table>
            <b-pagination v-if="meals!=null" :total-rows="meals.length" v-model="currentPage" :per-page="perPage">
            </b-pagination>
        </div>

</template>

<script>


    export default {

        data() {
            return {
                menuItem : null,
                makePag: [],
                setVisible: false,
                itemIdTerminatedMeal: null,
                item:[],
                meals: null,
                items: null,
                fields: [
                    {key:'id'},
                    {key:'state', sortable: true},
                    {key:'table_number', sortable: true},
                    {key:'total_price_preview', sortable: true},
                    {key:'actions', sortable: true},
                ],
                filter: null,
                currentPage: 1,
                perPage: 10,
                size: 30,
                modalShow: false,
                terminatedMeal_tableNumber: null
            };
        },
        methods:{
            handleOk (){
               this.terminar(this.itemIdTerminatedMeal);
               //SOCKET HERE
               console.log(this.terminatedMeal_tableNumber);
               
            },

            terminar(meal_id){
                console.log(meal_id);
                axios
                    .patch("api/waiter/"+meal_id+"/meals/terminated")
                    .then(response => {
                        this.$toasted.success('Meal has been terminated!', {duration: 3000, position: 'top-center'});
                        this.criarInvoices_Item__Invoice(meal_id);
                        this.mostrarList();
                        this.$socket.emit('terminatedMeal_to_cashiers', this.$store.state.user, this.terminatedMeal_tableNumber, this.itemIdTerminatedMeal);
                        this.itemIdTerminatedMeal = null;
                        
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    })
            },
            esconder(){
                this.setVisible=false
            },
            criarInvoices_Item__Invoice(id){
                axios
                    .put("api/waiter/"+id+"/meal/terminated/invoices")
                    .then(response => {
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data);
                    })
            },
            mostrarList(){
                axios
                    .get("api/meals/"+ this.$store.state.user.id)
                    .then(response => {
                        this.meals = response.data.data;

                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    })
            }
        },
        watch: {

        },
        created() {
           this.mostrarList();
        },
        mounted(){

        }
    };
</script>