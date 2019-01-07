<template>
    <div>
        <div class="jumbotron">

        <form @submit.prevent="submit" class="contact-form">
            <h2>Add Order</h2>
            <p>Please select a order</p>
            <div class="form-group" :class="{ 'form-group--error': $v.orderSelect.$error }">
                <b-form-select  v-model="data.items" :options="optionItems" size="lg" :required="true" v-model.trim="$v.orderSelect.$model"></b-form-select>
            </div>
            <button class="btn btn-primary" type="submit" :disabled="submitStatus === 'PENDING'">Create</button>
            <button class="btn btn-secundary" v-on:click.prevent="cancel()">Cancel</button>
            <p class="typo__p" v-if="submitStatus === 'ERROR'">Please select a order first.</p>
            <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>

        </form>
        </div>
    </div>
</template>

<script>
    import { required } from 'vuelidate/lib/validators'
    export default {
        props: ["meal", "menuItem"],
        data: function() {
            return {
                submitStatus:null,
                orderSelect:"",
                data: {
                    meal_id: "",
                    items: null
                },
                optionItems: [

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
        validations: {
            orderSelect: {
                required
            }
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
                        this.createOrder();
                    }, 500)
                }
            },
            confirmedOrder:function(){

                axios
                    .patch("api/waiter/order/"+this.orderID+"/confirmed")
                    .then(response => {
                            console.log("Order changed to confirmed");
                            //SOCKET
                            this.$socket.emit('orderAdded_to_cooks', this.orderID);
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
                this.data.items= this.orderSelect;
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

