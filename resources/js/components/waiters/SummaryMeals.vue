<template>
    <div id="conteudo">
   <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="sumary==null"></PacmanLoader>
        <b-row>
            <b-col md="6" class="my-1" v-if="sumary!=null">
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

        <b-table hover :items="sumary" :fields="fields" v-if="sumary!=null" :filter="filter" :per-page="perPage" :current-page="currentPage" :bordered="true">
            <template slot="details" slot-scope="row">
                <b-form-checkbox @click.native.stop @change="row.toggleDetails" v-model="row.detailsShowing">
                    Details
                </b-form-checkbox>
            </template>
            <template slot="row-details" slot-scope="row">
                <b-card>
                    <b-button @click="row.toggleDetails">Hide Details</b-button>
                    <b-row class="lg-10" v-for="(in_I) in row.item.order" :key="in_I.id">
                            <div>
                            <br> Name: {{in_I.item.name}}
                            <br> Price: {{in_I.item.price}} €
                            <br> State: {{in_I.state}} <br> 
                            </div>
                    </b-row>
                </b-card>
            </template>
            <template slot="payment" slot-scope="row">
                <vs-button color="success" type="filled" v-on:click.prevent="editInvoice(row.item)">Payment</vs-button>
            </template>
        </b-table>
        <nav aria-label="Page navigation example" v-if="sumary!=null">
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
                columns: [
                    "id",
                    "state",
                    "table_number",
                    "total_price_preview",
                ],
                options: {},
                sumary:null,
                items: null,
                fields: [
                    {key:'id'},
                    {key:'details'},
                    {key:'state', sortable: true},
                    {key:'table_number', sortable: true},
                    {key:'total_price_preview', sortable: true},
                ],
                filter: null,
                pagination: {},
                currentPage: 1,
                perPage: 10,
                size: 30,
            }
        },
        created() {
            this.fetchData();
        },
        methods :{
            fetchData(page_url){
                let pg = this;
                page_url = page_url || "api/waiter/" + this.$store.state.user.id + "/meals/summary?page=1";
                axios
                    .get(page_url)
                    .then(response => {
                        this.sumary = response.data.data;
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
            }
        }

    }

</script>
