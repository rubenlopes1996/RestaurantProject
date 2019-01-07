<template>
    <div id="conteudo">
        <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="meals==null"></PacmanLoader>
        <!--<div class="container" v-if="meals!=null">
            <div>
                <div class="col-md-3">
                    <p>Click here to order by the invoice you wish</p>

                    <b-button v-on:click.prevent="filterData(pagination.prev_page_url,'paid')" variant="outline-success">Paid</b-button>
                    <b-button v-on:click.prevent="filterData(pagination.prev_page_url,'not paid')" variant="outline-danger">Not Paid</b-button>

                </div>
                <b-form-group>
                    <p>Select user</p>
                    <div class="col-sm-12">
                        <b-form-select v-model="WaiterSelect.user_id" :options="optionItems" size="lg" ></b-form-select>
                        <br>
                        <b-button v-on:click.prevent="filterByWaiter()" variant="outline-info">Search </b-button>
                    </div>
                </b-form-group>

                <div class="col-md-3">
                    <p>Start Date</p>
                    <date-picker   v-model="date" :config="options"></date-picker>
                </div>


                <div class="col-md-3">
                    <p>End  Date</p>
                    <date-picker  v-model="endDate" :config="options"></date-picker>
                </div>

                <b-button class="col-md-3" v-on:click.prevent="filterBYDate(pagination.prev_page_url)" variant="outline-info">Filter by Date</b-button>

            </div>
        </div>-->

        <b-container>
            <b-row>
                <b-col>
                    <p>Click here to order by the invoice you wish</p>

                    <b-button v-on:click.prevent="filterData(pagination.prev_page_url,'paid')" variant="outline-success">Paid</b-button>
                    <b-button v-on:click.prevent="filterData(pagination.prev_page_url,'not paid')" variant="outline-danger">Not Paid</b-button>
                    <b-button v-on:click.prevent="filterData(pagination.prev_page_url,'not paid')" variant="outline-info">Responsible Waiter</b-button>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <p>Start Date</p>
                    <date-picker   v-model="date" :config="options"></date-picker>
                </b-col>
                <b-col>
                    <p>End  Date</p>
                    <date-picker  v-model="endDate" :config="options"></date-picker>
                </b-col>
                
            </b-row>
            <b-row>
                <b-col>
                    <br>
                    <b-button v-on:click.prevent="filterBYDate(pagination.prev_page_url)" variant="outline-info">Filter by Date</b-button>
                </b-col>
                </b-row>
        </b-container>

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

    </div>
</template>
<script>

    export default {
        data: function () {
            return {
                date: null,
                endDate: null,
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                },
                meals:null,
                items: null,
                state: 'pending',
                fields: [
                    {key:'id'},
                    {key:'state', sortable: true},
                    {key:'meal_id', sortable: true},
                    {key:'nif', sortable: true},
                    {key:'name', sortable: true},
                    {key:'date', sortable: true},
                    {key:'total_price', sortable: true},
                    {key:'responsible_waiter', sortable: true},
                ],
                filter: null,
                pagination: {},
                currentPage: 1,
                perPage: 10,
                size: 30,
                optionItems: [
                    { value: null, text: 'Please select some item',disabled: true  },
                ],
                WaiterSelect: {
                    user_id: null,
                },
                waiter:null,
            }
        },
        created() {
            this.fetchData();
            this.getWaiterforSelect();
        },

        methods :{
            filterBYDate(page_url){


                let pg = this;
                page_url = page_url || "api/list/invoices/date/"+this.date+"/"+this.endDate+"?page=1";
                axios
                    .get(page_url)
                    .then(response => {


                        this.meals= response.data.data;
                        pg.makePagination(response.data.meta, response.data.links);
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            fetchData(page_url){

                let pg = this;
                page_url = page_url || "api/list/invoices/"+this.state+"?page=1";
                axios
                    .get(page_url)
                    .then(response => {

                        this.meals = response.data.data;
                        console.log(this.meals);
                        pg.makePagination(response.data.meta, response.data.links);
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            filterData(page_url,state){


                let pg = this;
                page_url = page_url || "api/list/invoices/"+state+"?page=1";
                axios
                    .get(page_url)
                    .then(response => {


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
            getWaiterforSelect: function () {
                axios
                    .get("api/list/statistics/waiter")
                    .then(response => {
                        this.waiter = response.data.data;
                        this.value=this.waiter;

                        this.waiter.forEach(element => {
                            this.optionItems.push({
                                text: element.name,
                                value: element.id
                            });
                        });

                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            filterByWaiter(page_url){
                console.log(this.WaiterSelect.user_id);
                let pg = this;
                page_url = page_url || "api/list/statistics/waiter/"+this.WaiterSelect.user_id+"?page=1";
                axios
                    .get(page_url)
                    .then(response => {
                        console.log(response.data.data.length);
                        this.meals = response.data.data;
                        if(response.data.data.length==0){
                            this.$toasted.error('Please select a waiter!', {duration: 2000, position: 'top-center'});
                        }
                        pg.makePagination(response.data.meta, response.data.links);
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
        }

    }

</script>
