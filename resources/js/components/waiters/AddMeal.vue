<template>
    <div class="jumbotron">
        <h2>Add Meal</h2>
        <div class="form-group">
            <label for="inputName">Table Number</label>
            <input
                    type="table_number"
                    class="form-control"
                    v-model="meal.table_number"
                    name="table_number"
                    id="table_number"
                    placeholder="Table number"
            >
        </div>

        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="creatMeal()">Create</a>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                meal: {
                    table_number: ""
                }
            };
        },

        methods: {
            creatMeal: function() {
                console.log(this.meal);
                axios
                    .post("api/waiter/" + this.$store.state.user.id + "/meal", this.meal)
                    .then(response => {
                        this.$toasted.success('Meal has been created!', {duration: 3000, position: 'top-center'});
                        console.log(response);
                    })
                    .catch(error => {
                        this.$toasted.error(error.response.data, {duration: 2000, position: 'top-center'});
                        console.log(error.response.data);



                    });
            }
        }
    };
</script>

