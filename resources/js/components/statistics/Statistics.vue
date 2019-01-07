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
        <div class="small">
            <line-chart :chart-data="datacollection"></line-chart>
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
                datacollection: null,
                usersKW: null,
                startDate: null,
                endDate: null,
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                },
    
                dataUser: {
                    user_id: null,
                },
                optionItems: [{
                    value: null,
                    text: 'Please select a employee',
                    disabled: true
                }, ],
            };
        },
        created() {
            this.getCooksAndWaiters();
            this.statisticsOrder();
        },
        methods: {
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
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                })
            },
            statisticsOrder() {
                axios.get('api/statistics/orders').
                then(response => {
                    console.log(response.data);
                    this.datacollection = {
                        datasets: [{
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [response.data.label]
                        }, {
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [response.data.series]
                        }]
                    }
                }).catch(error => {
                    console.log(error);
                })
    
    
            }
    
    
        }
    }
</script>

<style>
    
</style>