<template>
    <div class="jumbotron" v-if="table">
 <!--       <h2>Add Table</h2>
        <div class="form-group">
            <label for="tableNumber">Table Number</label>
            <input type="text" class="form-control" v-model="table.table_number" name="table_number" id="table_number" placeholder="Table number" value="" />
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveTable()">Save</a>
        </div>
-->
        <form @submit.prevent="submit" class="contact-form">
            <h2>Add Table</h2>

            <div class="form-group" :class="{ 'form-group--error': $v.tableNumber.$error }">
                <input class="form__input form-control" placeholder="Table number" v-model.trim="$v.tableNumber.$model"/>
            </div>

            <button class="btn btn-primary" type="submit" :disabled="submitStatus === 'PENDING'">Add</button>
            <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the fiedl correctly.</p>
            <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
        </form>
    </div>
</template>

<script>
    import { required } from 'vuelidate/lib/validators'
    export default {
        data() {
            return {
                table: {
                    table_number: ""
                },
                tableNumber:"",
                submitStatus:null,
            };
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
                        this.saveTable();
                    }, 500)
                }
            },
            saveTable: function() {
                this.$emit("save-table", this.table);
            }
        },
        validations: {
            tableNumber: {
                required,
            },
        },
    }
</script>

