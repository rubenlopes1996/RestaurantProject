<template>
    <div class="jumbotron">
        <!--  <h2>Add Meal</h2>
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
        -->


        <form @submit.prevent="submit" class="contact-form">
            <h2>Add Meal</h2>
            <div class="form-group" :class="{ 'form-group--error': $v.tableNumber.$error }">
                <input class="form__input form-control" placeholder="Table Number" required="true" v-model.trim="$v.tableNumber.$model"/>
            </div>
            <button class="btn btn-primary" type="submit" :disabled="submitStatus === 'PENDING'">Create</button>
            <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the field correctly.</p>
            <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>

        </form>



    </div>
</template>

<script>
    import { required } from 'vuelidate/lib/validators'
    export default {
        data: function() {
            return {
                meal: {
                    table_number: ""
                },
                submitStatus: null,
                tableNumber:"",
            };
        },
        validations: {
            tableNumber: {
                required
            }


        },

        methods: {
            submit() {
                console.log('submit!')
                this.$v.$touch()
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR'
                } else {
                    // do your submit logic here
                    this.submitStatus = 'PENDING'
                    setTimeout(() => {
                        this.submitStatus = 'OK'
                        this.creatMeal();
                    }, 500)
                }
            },
            creatMeal: function() {

               this.meal.table_number=this.tableNumber;
                axios
                    .post("api/waiter/" + this.$store.state.user.id + "/meal", this.meal)
                    .then(response => {
                        this.$toasted.success('Meal has been created!', {duration: 3000, position: 'top-center',theme:'bubble'});
                        console.log(response);
                    })
                    .catch(error => {
                        this.$toasted.error(error.response.data, {duration: 2000, position: 'top-center',theme:'bubble'});
                        console.log(error.response.data);



                    });
            }
        }
    };
</script>

