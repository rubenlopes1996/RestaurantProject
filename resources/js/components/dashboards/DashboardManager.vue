<template>
    <div>
        <nav role="navigation">
            <ul class="main">
                <li class="users text-center">
                    <div class="container center-block ">
                        <img :src="'storage/profiles/'+user.photo_url" class="rounded profile-pic">
                    </div>
                    <p>Hello, {{user.name}}</p>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/restaurant-tables"><feather-icon type="layers"></feather-icon> Restaurant Tables</router-link>
                </li>
                <li class="users">
                  <router-link class="nav-link" to="/restaurant-menu"><feather-icon type="clipboard"></feather-icon> Restaurant Menu</router-link>
                  </li>
                <li class="users">
                    <router-link class="nav-link" to="/employee">
                        <feather-icon type="users" stroke="fcolor"></feather-icon> Employees
                    </router-link>
                </li>
                <li class="users"><a href="#"><feather-icon type="droplet"></feather-icon> Drinks & Meals</a></li>
                <li class="users">
                    <router-link class="nav-link" to="/paidinvoices"><feather-icon type="box"></feather-icon> All Invoices</router-link>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/dashboard/contactAdmin">
                        <feather-icon type="help-circle"></feather-icon> Contact an Admin
                    </router-link>
                </li>
                <li class="users"><a href="#"><feather-icon type="activity"></feather-icon> Statistics</a></li>

            </ul>
        </nav>
        <div class="container d-flex justify-content-center">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      user: this.$store.state.user,
      fcolor: "#fff"
    };
  },
  created() {},
  methods: {}
};
</script>

<style scoped>
@charset "UTF-8";
@import url(
  https://fonts.googleapis.com/css?family=Open+Sans:300,
  400,
  700,
  400,
  italic
);
@import url(https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css);
body {
  background: #f1f2f7;
  font-family: "Open Sans", arial, sans-serif;
  color: darkslategray;
}

nav[role="navigation"] {
  background: #2a3542;
  color: #ddd;
}

nav[role="navigation"] li {
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

nav[role="navigation"] li a {
  color: #ddd;
  text-decoration: none;
  display: block;
  padding: 0.7em;
}

nav[role="navigation"] li a:hover {
  background-color: rgba(255, 255, 255, 0.05);
}

/* lists */

ul,
li {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

main li {
  position: relative;
  padding-left: 1.2em;
  margin: 0.5em 0;
}

@media screen and (min-width: 600px) {
  html,
  body {
    height: 100%;
  }
  nav[role="navigation"] {
    position: fixed;
    width: 200px;
    top: 56px;
    bottom: 0px;
  }
}

img {
  margin: 15px;
}
</style>
