<template>
    <div>
        <!--<PacmanLoader class="custom-class" color="#50555D" loading="loading" :size="size" sizeUnit="px" v-if="notLoaded"></PacmanLoader>-->
        <v-client-table ref="table" :data="invoices" :columns="columns" :options="options" id="buttons">
            <div slot="actions" slot-scope="invoices" align="center">
                <button class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(invoices.row)">Payment</button>
            </div>
            <div slot="child_row" slot-scope="invoices">
                <div v-for="(in_I, index) in invoices.row.invoice_items" :key="in_I.id">
                    Quantity:<b> {{in_I.quantity}}</b><br>
                     Unit Price: {{in_I.unit_price}} €<br>
                      Sub Total: <b>{{in_I.sub_total_price}} €</b><br>
                      &nbsp;Name: {{invoices.row.items_consumed[index].name}}<br>
                      &nbsp;Created:  {{invoices.row.items_consumed[index].created_at}}<br>
                      &nbsp;Type: {{invoices.row.items_consumed[index].type.toUpperCase()}}<br><br>
                    <!--<div v-for="item in invoices.row.items_consumed" :key="item.id">
                        Name: {{ item.name }} <br>
                         Created: {{ item.created_at }}<br>
                          Type: {{ item.type }}<br><br>
                    </div>-->
                </div>
            </div>
        </v-client-table>
    </div>
</template>

<script>
module.exports = {
  props: ["invoices"],
  data: function() {
    return {
      activeUser: {},
      items: this.invoices,
      columns: [
        "state",
        "table_number",
        "responsible_waiter",
        "total_price",
        "date",
        "actions"
      ],
      options: {},
      size: 10,
      notLoaded: false,
      showItem: 0
    };
  },
  created() {
    this.fecthEmployees();
  },
  methods: {
    itemDetails: function(items) {
      this.$emit("items-detail", items);
    },
    editUser: function(user) {
      this.activeUser = user;
      this.$emit("edit-user", user);
      this.editingUser = true;
    },
    deleteUser: function(user) {
      this.$emit("delete-user", user);
      //Vue.set(this.$emit, "delete-user", user);
    },
    fecthEmployees(page_url) {
      let pg = this;
      page_url = page_url || "api/invoices";
      axios
        .get(page_url)
        .then(response => {
          notLoaded = false;
          this.items = response.data.data;
        })
        .catch(error => {
          console.log(error);
          notLoaded = false;
        });
    }
  }
};
</script>

<style>
.VueTables__child-row-toggler {
  width: 16px;
  height: 16px;
  line-height: 16px;
  display: block;
  margin: auto;
  text-align: center;
}

.VueTables__child-row-toggler--closed::before {
  content: "\f06e";
  font-family: FontAwesome;
}

.VueTables__child-row-toggler--open::before {
  content: "\f070";
  font-family: FontAwesome;
}
</style>
