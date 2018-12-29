import VueRouter from 'vue-router';
import store from './vuex.js';

let routes = [{
        path: '/login',
        component: require('./components/Login.vue')
    },
    {
        path: '/menu',
        component: require('./components/MenuItems.vue')
    },
    {
        path: '/',
        component: require('./components/Home.vue')
    },
    {
        path: '/dashboard',
        component: require('./components/dashboards/DashboardManager.vue'),
        meta: {
            middlewareAuth: true
        },
        children: [{
                path: '/employee',
                component: require('./components/employee/Employee.vue'),
                meta: {
                    middlewareAuth: true
                },
            },
            {
                path: '/restaurant-tables',
                component: require('./components/restaurant-table/RestaurantTable.vue'),
                meta: {
                    middlewareAuth: true
                }
            },
            {
                path: '/paidinvoices/:newestInvoiceId',
                name: 'paidinvoices',
                component: require('./components/cashiers/PaidInvoices.vue'),
                meta: {
                    middlewareAuth: true
                },
            },
            {
                path: '/restaurant-menu',
                component: require('./components/restaurant-menu/RestaurantMenu.vue'),
                meta: {
                    middlewareAuth: true
                },
            },
            {
                path: 'contactAdmin',
                component: require('./components/ContactAdmin.vue'),
                meta: {
                    middlewareAuth: true
                }
            }

        ]
    },
    {
        path: '/myProfile',
        component: require('./components/Profile.vue'),
        meta: {
            middlewareAuth: true
        }
    },
    {
        path: '/dashboardCashier',
        component: require('./components/dashboards/DashboardCashier.vue'),
        meta: {
            middlewareAuth: true
        },
        children: [{
                path: 'invoices',
                component: require('./components/cashiers/Invoices.vue'),
                meta: {
                    middlewareAuth: true
                }
            },
            {
                path: 'paidinvoices',
                component: require('./components/cashiers/PaidInvoices.vue'),
                meta: {
                    middlewareAuth: true
                }
            },
            {
                path: 'allinvoices',
                component: require('./components/cashiers/AllInvoices.vue'),
                meta: {
                    middlewareAuth: true
                }
            }
        ]
    },
    {
        path: '/dashboardWaiter',
        component: require('./components/dashboards/DashboardWaiter.vue'),
        meta: {
            middlewareAuth: true
        },
        children: [{
            path: 'meal/add',
            component: require('./components/waiters/AddMeal.vue'),
            meta: {
                middlewareAuth: true
            }
        },
            {
                path: 'my/meals/addorder',
                component: require('./components/waiters/MealsList.vue'),
                meta: {
                    middlewareAuth: true
                }
            },
            {
                path: 'orders/pending&confirmed',
                component: require('./components/waiters/Orders.vue'),
                meta: {
                    middlewareAuth: true
                }
            },
            {
                path: 'my/orders/confirmed&prepared',
                component: require('./components/waiters/PreparedOrders.vue'),
                meta: {
                    middlewareAuth: true
                }
            },
            {
                path: 'my/meals/summary',
                component: require('./components/waiters/SummaryMeals.vue'),
                meta: {
                    middlewareAuth: true
                }
            },
            {
                path: 'my/meals/terminated',
                component: require('./components/waiters/TerminatedMeals.vue'),
                meta: {
                    middlewareAuth: true
                }
            },
            {
                path: 'contactAdmin',
                component: require('./components/ContactAdmin.vue'),
                meta: {
                    middlewareAuth: true
                }
            }
        ]
    },
    {
        path: '/dashboardCook',
        component: require('./components/dashboards/DashboardCooks.vue'),
        meta: {
            middlewareAuth: true
        },
        children: [{
                path: 'orders',
                component: require('./components/cooks/Orders.vue'),
                meta: {
                    middlewareAuth: true
                },
            },
            {
                path: 'contactAdmin',
                component: require('./components/ContactAdmin.vue'),
                meta: {
                    middlewareAuth: true
                }
            }
        ]
    }
];

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.middlewareAuth && (store.state.user == null)) {
        next('/login');
        return;
    }
    next();
});

export default router;
