<template>
  <div class="container">
    <div v-for="item in items" v-bind:key="item.id">
  
      <b-card >
        <b-card-body>
          <b-card-img :src="'storage/items/'+item.photo_url"
                    alt="Image"
                    bottom></b-card-img>
          <p class="card-text">
            {{item.description}}
          </p>
        </b-card-body>
        <b-list-group flush>
          <b-list-group-item>{{item.price}}</b-list-group-item>
          <b-list-group-item>{{item.type}}</b-list-group-item>
        </b-list-group>
      </b-card>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        items: []
      };
    },
    created() {
      this.fecthMenu();
    },
    methods: {
      fecthMenu(page_url) {
        axios.get("api/menu").then(response => {
          this.items = response.data.data;
        });
      }
    }
  };
</script>
