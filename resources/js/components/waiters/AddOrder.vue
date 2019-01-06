<template>
    <div>
        <div class="jumbotron">
            <h2>Add Order</h2>
            <div class="form-group">
                <label for="inputName"></label>
                <b-form-group>
                    <div class="col-sm-12">

                        <b-form-select v-model="data.items" :options="optionItems" size="lg" ></b-form-select>

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
                    items: null
                },
                optionItems: [
                    { value: null, text: 'Please select some item',disabled: true  },
                ],
                size: 30,
                orderID:null,
                action : [{
                    text : 'Cancel this order!',

                    onClick : (e,toastObject) => {
                        this.deleteOrder(this.orderID);
                        toastObject.goAway(0);
                    },

                }],

            };
        },

        methods: {
            confirmedOrder:function(){
                console.log('estou aqui',this.orderID);
                axios
                    .patch("api/waiter/order/"+this.orderID+"/confirmed")
                    .then(response => {
                            console.log("Order changed to confirmed");
                            //SOCKET
                            this.$socket.emit('orderAdded_to_cooks');
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            deleteOrder:function(id) {
                axios
                    .delete("api/waiter/"+id+"/delete/order")
                    .then(response => {

                        this.$toasted.info('Order has been deleted.',{duration: 3000, position: 'top-center', theme:'bubble'});
                        this.cancel();
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                    });
            },
            createOrder: function() {
                this.data.meal_id = this.meal;
                console.log(this.data);
                axios
                    .post("api/addorders", this.data)
                    .then(response => {

                        this.orderID=response.data.id;
                        this.$toasted.success('Orders has been created!',
                            {duration: 5000, position: 'bottom-center',theme:'bubble', action: this.action, onComplete:this.confirmedOrder});

                        this.cancel();
                    })
                    .catch(error => {
                        console.log(error);
                        console.log(error.response.data.message);
                        this.$toasted.error('Error creating order', {duration: 3000, position: 'top-center',theme:'bubble'});
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

