<template>
    <div class="container">
        <h1>Menu Restaurant</h1>
        <div class="card-group">
            <div v-for="item in items" v-bind:key="item.id">
                <div class="card" style="width: 18rem; margin:10px">
                    <img class="card-img-top" :src="'storage/items/'+item.photo_url" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{item.name}}</h5>
                        <p class="card-text">{{item.price}} €</p>
                        <p class="card-text">{{item.description}}</p>
                        <!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fecthMenu(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fecthMenu(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
  data() {
    return {
      items: [],
      pagination: {}
    };
  },
  created() {
    this.fecthMenu();
  },
  methods: {
    fecthMenu(page_url) {
      let pg = this;
      page_url = page_url || "api/menu";
      axios
        .get(page_url)
        .then(response => {
          this.items = response.data.data;
          pg.makePagination(response.data.meta, response.data.links);
        })
        .catch(error => {
          console.log(error);
        });
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    }
  }
};
</script>

<style scoped>
.container {
  margin-top: 56px;
}
</style>
