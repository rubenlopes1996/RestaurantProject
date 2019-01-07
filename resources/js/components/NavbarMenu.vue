<template>
<div>
    <div id="parentx" v-if="user != null">
        <vs-sidebar position-right parent="body" default-index="1" color="primary" class="sidebarx" spacer v-model="active">
            <div class="header-sidebar" slot="header">
                <vs-avatar size="70px" :src="'storage/profiles/'+user.photo_url" />
                <h4>
                    {{user.name}}
                </h4>
            </div>
            <vs-divider>Notifications</vs-divider>
            <div class="container text-center">
                <vs-collapse accordion v-if="arrayNames!=null && arrayMsgs != null">
                    <vs-collapse-item v-for="(name, index) in arrayNames" :key="name + index">
                        <div slot="header">
                            {{name}}
                        </div>
                        <h6>{{arrayDesc[index]}}</h6>
                        <p>{{arrayMsgs[index]}}</p>
                        <vs-button color="danger" type="filled" v-on:click.prevent="removeMsg(index)">Dismiss</vs-button>
                    </vs-collapse-item>
                </vs-collapse>
                <vs-collapse accordion v-if="notificationsInvoicesTableNumber!=null && notificationsInvoicesName != null">
                    <vs-collapse-item v-for="(name, index) in notificationsInvoicesName" :key="name + index">
                        <div slot="header">
                            {{name}}
                        </div>
                        <p>Invoice for table {{notificationsInvoicesTableNumber[index]}} has been paid</p>
                        <router-link :to="{name: 'paidinvoices', params: {newestInvoiceId: notificationsInvoicesId[index] }}" ><vs-button color="success" type="filled">Details</vs-button></router-link>
                        <vs-button color="danger" type="filled" v-on:click.prevent="removeInvoiceInfo(index)">Dismiss</vs-button>
                    </vs-collapse-item>
                </vs-collapse>
                <vs-collapse accordion v-if="notificationsTMealTableNumber!=null && notificationsTMealName != null">
                    <vs-collapse-item v-for="(name, index) in notificationsTMealName" :key="name + index">
                        <div slot="header">
                            {{name}}
                        </div>
                        <p>Meal for table {{notificationsTMealTableNumber[index]}} has been terminated</p>
                        <router-link :to="{name: 'invoices', params: {newestMealId: notificationsTMealId[index] }}" ><vs-button color="success" type="filled">Details</vs-button></router-link>
                        <vs-button color="danger" type="filled" v-on:click.prevent="removeTMealInfo(index)">Dismiss</vs-button>
                    </vs-collapse-item>
                </vs-collapse>
                <vs-collapse accordion v-if="notificationsOrders!=null">
                    <vs-collapse-item v-for="(order, index) in notificationsOrders" :key="order + index">
                        <div slot="header">
                            {{order}}
                        </div>
                        <router-link to="/dashboardCook/orders" ><vs-button color="success" type="filled">Orders</vs-button></router-link>
                        <vs-button color="danger" type="filled" v-on:click.prevent="removeOrderInfo(index)">Dismiss</vs-button>
                    </vs-collapse-item>
                </vs-collapse>
            </div>
        </vs-sidebar>
    </div>
    <nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light fixed-top"><button class="navbar-toggler" type="button"
            data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
            aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
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
                            <router-link class="nav-link" :to="{name: 'invoices', params: {newestMealId: -1 }}">Dashboard</router-link>
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
            </ul>
    
            <form class="form-inline my-2 my-lg-0 nav-item">
                <div v-if="user == null">
                    <router-link class="btn btn-outline-success my-2 my-sm-0" to="/login">Login</router-link>
                </div>
                <div v-else>
                    <vs-button v-on:click.prevent="active=!active" color="primary" type="border" class="my-2 my-sm-0">
                        <feather-icon type="bell"></feather-icon><span class="badge badge-light">{{unreadNotif}}</span>
                    </vs-button>
                    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" v-on:click.prevent="logout()">Logout</button>
                </div>
            </form>
        </div>
    </nav>
    
</div>
</template>
<script>
import 'material-icons/iconfont/material-icons.css';
    export default {
        computed: {
            user: function() {
                return this.$store.state.user;
                
            }
        },
        data: () => ({
                active: false,
                msgGlobalTextArea:"",
                msg: "",
                userName: "",

                //arrays para receber e ver mensagens de users
                arrayNames: [],
                arrayDesc: [],
                arrayMsgs: [],
                // -----

                //arrays para receber e ver notificacoes de invoices
                notificationsInvoicesTableNumber: [],
                notificationsInvoicesName: [],
                notificationsInvoicesId: [],
                //------

                //notifications para receber e ver notificaoes de terminated meals
                notificationsTMealTableNumber: [],
                notificationsTMealName: [],
                notificationsTMealId: [],
                //-------

                //notifications para receber e ver notificacoes de Orders
                notificationsOrders: [],
                //-------


                unreadNotif: 0

        }),
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
            },
                removeMsg: function(index){
                    this.arrayNames.splice(index, 1);
                    this.arrayDesc.splice(index, 1);
                    this.arrayMsgs.splice(index, 1);

                    this.unreadNotif -= 1;
                },
                removeInvoiceInfo: function(index){
                    this.notificationsInvoicesName.splice(index, 1);
                    this.notificationsInvoicesId.splice(index, 1);
                    this.notificationsInvoicesTableNumber.splice(index, 1);
                    
                    this.unreadNotif -= 1;
                },
                removeTMealInfo: function(index){
                    this.notificationsTMealName.splice(index, 1);
                    this.notificationsTMealId.splice(index, 1);
                    this.notificationsTMealTableNumber.splice(index, 1);
                    
                    this.unreadNotif -= 1;
                },
                removeOrderInfo: function(index){
                    this.notificationsOrders.splice(index, 1);

                    this.unreadNotif -= 1;
                },
                resetNotif(){
                    this.unreadNotif = 0;
                },
                logout() {
                    this.showMessage = false;

                    axios.post('api/logout').then(response => {
                            this.$store.commit('clearUserAndToken');
                            this.typeofmsg = "alert-success";
                            this.message = "User has logged out correctly";
                            this.showMessage = true;
                            this.$router.push('/');
                        }

                    ).catch(error => {
                            this.$store.commit('clearUserAndToken');
                            this.typeofmsg = "alert-danger";
                            this.message = "Logout incorrect. But local credentials were discarded";
                            this.showMessage = true;
                            console.log(error);
                        }

                    )
                }
        },
        
        sockets:{
            connect(){
                console.log('socket connected (socket ID = '+this.$socket.id+')');
                if(this.$store.state.user){
                    this.$socket.emit('user_enter',this.$store.state.user);
                }
            },
            privateMessage(dataFromServer){
                this.$toasted.success('New message', {duration: 2000, position: 'top-right'});
                this.unreadNotif+=1;
                
                this.arrayNames.unshift(dataFromServer[0]);
                this.arrayDesc.unshift(dataFromServer[1]);
                this.arrayMsgs.unshift(dataFromServer[2]);
            },
            freshPaidInvoices(dataFromServer){
                //console.log("OIII"+dataFromServer);
                this.$toasted.success('Invoice paid', {duration: 2000, position: 'top-right'});
                this.unreadNotif+=1;

                this.notificationsInvoicesName.unshift(dataFromServer[0]);
                this.notificationsInvoicesTableNumber.unshift(dataFromServer[1]);
                this.notificationsInvoicesId.unshift(dataFromServer[2]);
                
            },
            freshTerminatedMeals(dataFromServer){
                console.log("OIII"+dataFromServer);
                this.$toasted.success('Meal Terminated', {duration: 2000, position: 'top-right'});
                this.unreadNotif+=1;

                this.notificationsTMealName.unshift(dataFromServer[0]);
                this.notificationsTMealTableNumber.unshift(dataFromServer[1]);
                this.notificationsTMealId.unshift(dataFromServer[2]);
                
            },
            freshOrder(){
                this.$toasted.success('New Order', {duration: 2000, position: 'top-right'});
                this.unreadNotif+=1;

                this.notificationsOrders.unshift("New order to prepare");
            }

            /*,
            msg_from_server(dataFromServer){
                this.$toasted.show('Msg chegou do server '+dataFromServer);
                this.msgGlobalTextArea = dataFromServer + '\n' + this.msgGlobalTextArea;
                

            }*/

        }
}
</script>

<style>
    /*.sidebarx .vs-sidebar--background{
        margin-top: 6px;
    }*/
    .vs-sidebar{
        max-width: 350px;
    }
    .header-sidebar{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 100%;
    }
    h4{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }
	
	.footer-sidebar{
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }
    .dashboards {
        display: inherit;
    }
    
    @media screen and ( max-width: 991px) {
        .dashboards {
            display: inline-block;
        }
    }

</style>
