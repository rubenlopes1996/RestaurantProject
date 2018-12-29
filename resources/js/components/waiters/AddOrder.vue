<template>
    <div>
        <div class="jumbotron">
            <h2>Add Order</h2>
            <div class="form-group">
                <label for="inputName"></label>
                <b-form-group>
                    <div class="col-sm-4">
                        <b-form-checkbox-group id="checkboxes1" name="flavour1" v-model="data.items" :options="optionItems"></b-form-checkbox-group>
                    </div>
                </b-form-group>
            </div>
    
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="createOrder()">Create</a>
                <a class="btn btn-light" v-on:click.prevent="cancel()">Cancel</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["meal", "menuItem"],
        data: function() {
            return {
                data: {
                    meal_id: "",
                    items: []
                },
                optionItems: [],
                size: 30
            };
        },
    
        methods: {
            createOrder: function() {
                this.data.meal_id = this.meal;
                
                axios
                    .post("api/addorders", this.data)
                    .then(response => {
                        this.$toasted.success("Orders has been created!", {
                            duration: 3000,
                            position: "top-center"
                        });
                        this.cancel();
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            cancel() {
                this.$emit("hideAddOrder");
            }
        },
        created() {

            this.menuItem.forEach(element => {
                this.optionItems.push({
                    text: element.name,
                    value: element.id
                });
            });
        }
    };
</script>

