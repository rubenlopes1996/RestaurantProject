<template>
    <nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <router-link class="navbar-brand" to="/">Restaurant DAD</router-link>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <div v-if="authenticated === true && user != null">
                    <li class="nav-item active">
                        <div v-if="user.type == 'manager'">
                            <router-link class="nav-link" to="/dashboard">Dashboard</router-link>
                        </div>
                        <div v-else-if="user.type == 'cook'">
                            <router-link class="nav-link" to="/dashboardCook">Dashboard</router-link>
                        </div>
                        <div v-else-if="user.type == 'waiter'">
                            <router-link class="nav-link" to="/dashboardWaiter">Dashboard</router-link>
                        </div>
                        <div v-else-if="user.type == 'cashier'">
                            <router-link class="nav-link" to="/dashboardCashier">Dashboard</router-link>
                        </div>
                    </li>
                </div>
                <li class="nav-item active">
                    <router-link class="nav-link" to="/menu">Menu</router-link>
                </li>
    
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <div v-if="authenticated === false && user.user == null">
                    <router-link class="btn btn-outline-success my-2 my-sm-0" to="/login">Login</router-link>
                </div>
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" v-on:click.prevent="logout()" v-else>Logout</button>
            </form>
        </div>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                authenticated: auth.check(),
                user: auth
            };
        },
        methods: {
            logout() {
                this.authenticated = false;
                this.user.user = null;
                this.user.token = null;
    
    
                axios.post('/api/logout').then(({
                    data
                }) => {
                    this.$router.push('/');
                }).catch((response) => {
                    console.log("erro");
                    alert(response.data.message);
                });
    
            }
        },
        mounted() {
            Event.$on("userLoggedIn", () => {
                this.authenticated = true;
                this.user = auth.user;
            });
        }
    };
</script>

<style>
    
</style>
