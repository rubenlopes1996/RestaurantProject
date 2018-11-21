<template>
    <div class="lg-12 md-6 xs-4">
        <table id = "table" class="table table-striped">
            <thead>
                <tr>
                    <th>State</th>
                    <th>Item id</th>
                    <th>Meal id</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in orders" :key="order.id">
                    <td>{{ order.state }}</td>
                    <td>{{ order.item_id }}</td>
                    <td>{{ order.meal_id }}</td>
                    <td>{{ order.start }}</td>
                    <td>{{ order.end }}</td>
    
                    <td>
                        <!--<a class="btn btn-sm btn-primary" v-on:click.prevent="editUser(user)">Edit</a>
                                        <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(user)">Delete</a>-->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      orders: []
    };
  },
  created() {
    this.fecthMenu();
  },
  methods: {
    fecthMenu(page_url) {
      let pg = this;
      page_url = page_url || "api/orders";
      axios
        .get(page_url)
        .then(response => {
          this.orders = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>

<style>
    #table{
        margin-top: 200px;
    }
</style>
