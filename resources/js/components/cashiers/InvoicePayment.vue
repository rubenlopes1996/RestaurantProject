<template>
    <div class="jumbotron" v-if="invoice">
    <!--    <h2>Invoice Payment</h2>
        <div class="form-group">
            <label for="inputNIF">NIF</label>
            <input type="number" class="form-control" v-model="invoice.nif" name="nif" id="inputNif" :placeholder="invoice.nif" value="" />
        </div>
        <div class="form-group">
            <label for="inputName">Customer Name</label>
            <input type="text" class="form-control" v-model="invoice.name" name="customer" id="inputCustomer" :placeholder="invoice.name" value="" />
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="payInvoice()">Pay</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
        </div>
-->


        <form @submit.prevent="submit" class="contact-form">
            <h4>Contact an Administrator</h4>

            <div class="form-group" :class="{ 'form-group--error': $v.nif.$error }">
                <input class="form__input form-control" placeholder="Nif" v-model.trim="$v.nif.$model"/>
            </div>

            <div class="form-group" :class="{ 'form-group--error': $v.name.$error }">
                <input class="form__input form-control" placeholder="Name" v-model.trim="$v.name.$model"/>
            </div>
            <button class="btn btn-primary" type="submit" :disabled="submitStatus === 'PENDING'">Pay</button>
            <button class="btn btn-light" v-on:click.prevent="cancelEdit()" >Cancel</button>
            <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the field correctly.</p>
            <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
            <div class="error" v-if="!$v.nif.minLength">Nif must have at least {{$v.nif.$params.minLength.min}} letters.</div>

        </form>
    </div>
</template>

<script>
    import { required, minLength } from 'vuelidate/lib/validators'
    export default {
    props: ["invoice"],
  data: function() {
    return {
        submitStatus: null,
        nif:"",
        name:"",
    };
  },
        validations: {
            nif: {
                required,
                minLength: minLength(9)
            },
            name:{
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
                    this.payInvoice();
                }, 500)
            }
        },
    payInvoice: function () {
      this.$emit("pay-invoice");
    },
    cancelEdit: function () {
      this.$emit("cancel-edit");
    }
    }
}
</script>
