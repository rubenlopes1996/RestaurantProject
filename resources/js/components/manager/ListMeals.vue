<template>
    <b-container>
    <b-row style="margin-top:70px">
        <b-container>
            <b-row>
                <b-col cols="4">
                </b-col>
                <b-col cols="4">
                    <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="meals==null"></PacmanLoader>
                </b-col>
                <b-col cols="4">
                </b-col>
            </b-row>
        </b-container>
        <b-col cols="12">
        <div v-if="meals!=null">
        <p>Click here to order by the order you wish</p>
        <b-button v-on:click.prevent="filterData('active')" variant="outline-success">Active</b-button>
        <b-button v-on:click.prevent="filterData('terminated')" variant="outline-danger">Terminated</b-button>
        <b-button v-on:click.prevent="filterData('paid')" variant="outline-primary">Paid</b-button>
        <b-button v-on:click.prevent="filterData('not paid')" variant="outline-warning">Not Paid</b-button>
        <b-button v-on:click.prevent="filterData('start')" variant="outline-secondary">Date</b-button>
        <b-button v-on:click.prevent="filterData('responsible_waiter_id')" variant="outline-secondary">Responsbile Waiter</b-button>
        <br>
        <br>
        <br>
        </div>
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
             <template slot="action" slot-scope="row" v-if="meals[0].state =='terminated'">
                <vs-button color="danger" type="filled" v-on:click.prevent="notPaidMeal(row.item)">Not paid</vs-button>
            </template>
        </b-table>
        <nav aria-label="Page navigation example" v-if="meals!=null">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click.prevent="fetchData(pagination.prev_page_url)">Previous</a>
                </li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click.prevent="fetchData(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>

        </b-col>
    </b-row>
    </b-container>
</template>
<script>


    export default {
        data: function () {
            return {
                options: {},
                meals:null,
                items: null,
                fields: [
                    {key:'id'},
                    {key:'state', sortable: true},
                    {key:'table_number', sortable: true},
                    {key:'responsible_waiter_id', sortable: true},
                    {key:'total_price_preview', sortable: true},
                    {key: 'action'}
                ],
                filter: null,
                pagination: {},
                currentPage: 1,
                perPage: 10,
                size: 30,
                stateMeal: ""
            }
        },
        created() {
            this.fetchData();
        },
        sockets:{
            socketRefreshMeals(){
                this.fetchData();
            }
        },
        methods :{
            fetchData(page_url){
                let pg = this;
                page_url = page_url || "api/list-meals?page=1";
                axios
                    .get(page_url)
                    .then(response => {
                        console.log(response);
                        this.meals = response.data.data;
                        pg.makePagination(response.data.meta, response.data.links);
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            filterData(state){
                console.log(state);
                this.stateMeal = state;
                console.log(this.stateMeal)
                let pg = this;
                axios
                    .get("api/list/meals/"+state+"?page=1")
                    .then(response => {
                        console.log(response);
                        this.meals= response.data.data;
                        pg.makePagination(response.data.meta, response.data.links);
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
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
            notPaidMeal(meal){
                console.log(meal)
                axios.put('api/meal/'+meal.id+'/notPaid').
                then(response=>{
                     this.$toasted.success('Meal has been confirmed has not paid', {duration: 5000, position: 'top-center'});
                     this.filterData('terminated');

                }).catch(error=>{
                    console.log(error);
                })
            }
        }

    }

</script>
