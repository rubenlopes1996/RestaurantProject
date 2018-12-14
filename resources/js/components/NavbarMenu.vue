<template>
    <nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <router-link class="navbar-brand" to="/">Restaurant DAD</router-link>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <router-link class="nav-link" to="/menu">Menu</router-link>
                </li>
                <div class="dashboards" v-if="user!= null">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/myProfile">My profile</router-link>
                    </li>
                    <li class="nav-item">
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
                            <router-link class="nav-link" to="/dashboardCashier/invoices">Dashboard</router-link>
                        </div>
                    </li>
                    <li class="nav-item" v-if=" user.shift_active ==1">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" v-on:click.prevent="stopShift()">End shift</button>
                        <a>You are working since {{user.last_shift_start}}, and you worked already {{Math.floor(this.$moment.duration(this.$moment(new Date()).diff(user.last_shift_end)).asHours()) }} hours</a>
                    </li>
                    <li class="nav-item" v-else>
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" v-on:click.prevent="startShift()">Start shift</button>
                        <a>Your shift has ended at {{user.last_shift_end}}, and it's been {{ Math.floor(this.$moment.duration(this.$moment(new Date()).diff(user.last_shift_start)).asHours())}} hours since your shift ended</a>
                    </li>
                </div>
                <div>
                    <feather-icon type="bell"></feather-icon>
                </div>
            </ul>
    
            <form class="form-inline my-2 my-lg-0 nav-item">
                <div v-if="user == null">
                    <router-link class="btn btn-outline-success my-2 my-sm-0" to="/login">Login</router-link>
                </div>
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" v-on:click.prevent="logout()" v-else>Logout</button>
            </form>
        </div>
    </nav>
</template>

<script>
    export default {
        computed: {
            user: function() {
                return this.$store.state.user;
            }
        },
        created() {
            this.$store.commit("loadTokenAndUserFromSession");
        },
        methods: {
            logout() {
                this.showMessage = false;
                axios
                    .post("api/logout")
                    .then(response => {
                        this.$store.commit("clearUserAndToken");
                        this.typeofmsg = "alert-success";
                        this.message = "User has logged out correctly";
                        this.showMessage = true;
                        this.$router.push("/");
                    })
                    .catch(error => {
                        this.$store.commit("clearUserAndToken");
                        this.typeofmsg = "alert-danger";
                        this.message =
                            "Logout incorrect. But local credentials were discarded";
                        this.showMessage = true;
                        console.log(error);
                    });
            },
            startShift() {
                axios
                    .put("api/startShift/" + this.user.id, this.user)
                    .then(response => {
                        Object.assign(this.user, response.data.data);
                        this.$store.commit("setUser", this.user);
                        console.log("start");
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            stopShift() {
                axios
                    .put("api/endShift/" + this.user.id, this.user)
                    .then(response => {
                        Object.assign(this.user, response.data.data);
                        this.$store.commit("setUser", this.user);
                        console.log("stop");
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            }
        }
    };
</script>

<style>
    .dashboards {
        display: inherit;
    }
    
    @media screen and ( max-width: 991px) {
        .dashboards {
            display: inline-block;
        }
    }
</style>
