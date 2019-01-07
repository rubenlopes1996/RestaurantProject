<template>
    <div>
        <add_order :meal="item" :menuItem="menuItem" v-if="setVisible" @hideAddOrder="esconder"></add_order>
        <div v-else>
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
    
                        <b-button v-on:click.prevent="mostrar(row.item.id)">Add Order</b-button>
                </template>
            </b-table>
            <b-pagination v-if="meals!=null" :total-rows="meals.length" v-model="currentPage" :per-page="perPage">
            </b-pagination>
        </div>
    </div>
</template>

<script>
    export default {
    
        data() {
            return {
                menuItem: null,
                makePag: [],
                setVisible: false,
                item: [],
                meals: null,
                items: null,
                fields: [{
                        key: 'id'
                    },
                    {
                        key: 'state',
                        sortable: true
                    },
                    {
                        key: 'table_number',
                        sortable: true
                    },
                    {
                        key: 'total_price_preview',
                        sortable: true
                    },
                    {
                        key: 'actions',
                        sortable: true
                    },
                ],
                filter: null,
                currentPage: 1,
                perPage: 10,
                size: 30,


            };
        },
        methods: {
            mostrar(item) {
                this.setVisible = true
                this.item= item;
            },
            esconder() {
                this.setVisible = false
            },
        },
        watch: {
    
        },
        created() {
            axios
                .get("api/meals/" + this.$store.state.user.id)
                .then(response => {
                    this.meals = response.data.data;

    
                })
                .catch(error => {
                    console.log(error);
                    console.log(error.response.data.message);
                }),
                axios
                .get("api/menu")
                .then(response => {
                    this.menuItem = response.data.data;
    
                })
                .catch(error => {
                    console.log(error);
                    console.log(error.response.data.message);
                });
        }
    };
</script>