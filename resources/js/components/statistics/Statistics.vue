<template>
    <div class="jumbotron">
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
</template>

<script>
    module.exports = {
    
        data: function() {
            return {
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
            }
    
    
        }
    }
</script>

<style>
    
</style>