<template>
    <div>
        <nav role="navigation">
            <ul class="main">
                <li class="users text-center">
                    <div class="container center-block ">
                        <img :src="'storage/profiles/'+user.user.photo_url" class="rounded">
                    </div>
                    <p>Hello, {{user.user.name}}</p>
                </li>
                <li class="users"><router-link class="nav-link" to="/restaurant-tables">Restaurant Tables</router-link></li>
                <li class="users"><a href="#">Restaurant Menu</a></li>
                <li class="users"><router-link class="nav-link" to="/employee">Employees</router-link></li>
                <li class="users"><a href="#">Meals</a></li>
                <li class="users"><a href="#">Invoices</a></li>
                <li class="users"><a href="#">Statistics</a></li>

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
      user: auth
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

.users a:before {
  content: "";
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

nav[role="navigation"] li a:before {
  content: "\f248";
  font-family: FontAwesome;
  padding-right: 0.6em;
}

nav[role="navigation"] .dashboard a:before {
  content: "";
}

nav[role="navigation"] .write a:before {
  content: "";
}

nav[role="navigation"] .edit a:before {
  content: "";
}

nav[role="navigation"] .comments a:before {
  content: "";
}

nav[role="navigation"] .users a:before {
  content: "";
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

main li:before {
  content: "";
  position: absolute;
  width: 0;
  height: 0;
  left: 0;
  top: 0.3em;
  border-left: solid 10px #dde;
  border-top: solid 5px transparent;
  border-bottom: solid 5px transparent;
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
