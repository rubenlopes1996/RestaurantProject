<template>
    <div>
        <nav role="navigation">
            <ul class="main">
                <li class="users text-center">
                    <div class="container center-block ">
                        <img :src="'storage/profiles/'+user.photo_url" class="rounded">
                    </div>
                    <p>Hello, {{user.name}}</p>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/dashboardWaiter/meal/add">
                        <feather-icon type="plus-circle"></feather-icon> Add Meal
                    </router-link>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/dashboardWaiter/my/meals/addorder">
                        <feather-icon type="plus"></feather-icon> Add Order
                    </router-link>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/dashboardWaiter/orders/pending&confirmed">
                        <feather-icon type="list"></feather-icon> Pending&Confirmed Orders
                    </router-link>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/dashboardWaiter/my/orders/confirmed&prepared">
                        <feather-icon type="alert-circle"></feather-icon> Prepared Orders
                    </router-link>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/dashboardWaiter/my/meals/summary">
                        <feather-icon type="monitor"></feather-icon> Summary of Meals
                    </router-link>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/dashboardWaiter/my/meals/terminated">
                        <feather-icon type="delete"></feather-icon> Terminate Meals
                    </router-link>
                </li>
                <li class="users">
                    <router-link class="nav-link" to="/dashboardWaiter/contactAdmin">
                        <feather-icon type="help-circle"></feather-icon> Contact an Admin
                    </router-link>
                </li>

            </ul>
        </nav>
        <b-container>
            <b-row align-v="center" style="min-height: 900px">
                <b-col style="margin-left: 200px">
                <router-view></router-view>
                </b-col>
            </b-row>
        </b-container>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: this.$store.state.user
            };
        },
        created() {},
        methods: {}
    };

</script>

<style scoped>
    @charset "UTF-8";
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,
    400,
    700,
    400,
    italic);
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

    li p {
        padding: 15px;
        margin: 0;
    }

    img {
        margin: 15px;
    }

</style>
