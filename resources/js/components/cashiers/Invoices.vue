<template>
    <div class="container content-admin">
        <!--<add-employee></add-employee>-->
        <div id="list">
            <!--<div class="alert alert-success" v-if="showSuccess">
                    <button type="button" class="close" aria-label="Close" v-on:click="showSuccess=false"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ successMessage }}</strong>
                </div>-->
            <!--<user-edit :user="currentUser" @save-user="saveUser()" @cancel-edit="cancelEdit()"></user-edit>-->
            <list-invoices :invoices="invoices"></list-invoices>
            <!--<list-invoices  @edit-user="editUser" @delete-user="deleteUser"></list-invoices>-->
        </div>
    </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      invoices: []
    };
  },
  methods: {
    getInvoices: function() {
      axios.get("api/invoices?unpaid").then(response => {
        this.invoices = response.data.data;
      });
    }
  },
  mounted() {
    this.getInvoices();
  }
};
</script>
