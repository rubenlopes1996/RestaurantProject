<template>
    <div>
        <div class="jumbotron">
            <div>
                <b-form-group>
                    <p>Select a employee</p>
                    <div class="col-sm-12">
                        <b-form-select v-model="dataUser.user_id" :options="optionItems" size="lg"></b-form-select>
                    </div>
                </b-form-group>
    
                <b-container>
                    <b-row>
                        <b-col>
                            <p>Start Date</p>
                            <date-picker v-model="startDate" :config="options"></date-picker>
                        </b-col>
                        <b-col>
                            <p>End Date</p>
                            <date-picker v-model="endDate" :config="options"></date-picker>
                        </b-col>
                    </b-row>
                </b-container>
                <b-button v-on:click.prevent="statisticsByEmployeeAndDate()" variant="outline-secondary">Filter </b-button>
            </div>
        </div>
         <b-container>
            <b-row>
                <b-col cols="4">
                </b-col>
                <b-col cols="4">
                <PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if=" dataOrder==null || dataMeal==null || dataTimeMeal==null || avgOrder==null"></PacmanLoader>
                </b-col>
                <b-col cols="4">
                </b-col>
            </b-row>
        </b-container>
        <div class="small" v-if="this.dataEmployee != null">
            <line-chart :chart-data="dataEmployee"></line-chart>
        </div>

        <div class="small" v-if="this.dataOrder!= null">
            <line-chart :chart-data="dataOrder"></line-chart>
        </div>

        <div class="small">
            <line-chart :chart-data="dataMeal" v-if="this.dataMeal"></line-chart>
        </div>

        <div class="small">
            <line-chart :chart-data="dataTimeMeal" v-if="this.dataTimeMeal"></line-chart>
        </div>

        <div class="small" v-if="avgOrder != null">
            <b-table hover :items="avgOrder" :fields="fields"  :filter="filter" :per-page="perPage" :current-page="currentPage" :bordered="true">
            </b-table>
            <b-pagination :total-rows="avgOrder.length" v-model="currentPage" :per-page="perPage">
            </b-pagination>
        </div>
    </div>
</template>

<script>
    import LineChart from './statisticsOrders.vue'
    
    export default {
        components: {
            LineChart
        },
        data: function() {
            return {
                fields: [{
                        key: 'name',
                        sortable: true
                    },
                    {
                        key: 'month',
                        sortable: true
                    },
                    {
                        key: 'average',
                        sortable: true
                    }
                ],
                filter: null,
                currentPage: 1,
                perPage: 10,
                dataTimeMeal: null,
                dataOrder: null,
                dataEmployee: null,
                dataMeal: null,
                usersKW: null,
                startDate: null,
                endDate: null,
                avgOrder: null,
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                },
    
                dataUser: {
                    user_id: null,
                },
                optionItems: [
    
                ],
            };
        },
        created() {
            this.getCooksAndWaiters();
            this.statisticsOrder();
            this.statisticsMeal();
            this.statisticsTimeOrder();
            this.statisticsTimeMeal();
        },
        methods: {
            submit() {
    
                this.$v.$touch()
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR'
                } else {
                    // do your submit logic here
                    this.submitStatus = 'PENDING'
                    setTimeout(() => {
                        this.submitStatus = 'OK'
                        this.statisticsByEmployeeAndDate();
                    }, 500)
                }
            },
            getCooksAndWaiters: function() {
                axios
                    .get("api/list/statistics")
                    .then(response => {
                        this.usersKW = response.data.data;
                        this.value = this.usersKW;
    
                        this.usersKW.forEach(element => {
                            this.optionItems.push({
                                text: element.type + ': ' + element.name,
                                value: element.id
                            });
                        });
    
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            statisticsByEmployeeAndDate: function() {
                axios.get("api/statistics/waiter/" + this.dataUser.user_id + "/date", {
                    params: {
                        startDate: this.startDate,
                        endDate: this.endDate
                    }
                }).
                then(response => {
                    this.dataEmployee = {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'Performance of the employee',
                            backgroundColor: '#0040ff',
                            data: response.data.series
                        }]
                    }
                }).catch(error => {
                    console.log(error);
                })
            },
            statisticsOrder() {
                axios.get('api/statistics/orders').
                then(response => {
                    this.dataOrder = {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'Number of orders in the restaurant (months 1-12)',
                            backgroundColor: '#fa8258',
                            data: response.data.series
                        }]
                    }
    
                }).catch(error => {
                    console.log(error);
                })
            },
            statisticsMeal() {
                axios.get('api/statistics/meals').
                then(response => {
                    this.dataMeal = {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'Number of meals in the restaurant (months 1-12)',
                            backgroundColor: '#f87979',
                            data: response.data.series
                        }]
                    }
    
                }).catch(error => {
                    console.log(error);
                })
            },
            statisticsTimeMeal() {
                axios.get('api/statistics/timeMeals').
                then(response => {
                    this.dataTimeMeal = {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'Average time it takes to handle each meal',
                            backgroundColor: '#f87979',
                            data: response.data.series
                        }]
                    }
    
                }).catch(error => {
                    console.log(error);
                })
            },
            statisticsTimeOrder(page_url) {
                axios.get('api/statistics/timeOrders').
                then(response => {
                    console.log(response.data)
                    this.avgOrder = response.data;
                }).catch(error => {
                    console.log(error);
                })
            }
    
        }
    }
</script>

<style>
    
</style>