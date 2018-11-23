import VueRouter from 'vue-router';

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
        }, {
            path: '/restaurant-tables',
            component: require('./components/restaurant-table/RestaurantTable.vue'),
            meta: {
                middlewareAuth: true
            },
        
        }]},
    {
        path: '/dashboardCook',
        component: require('./components/dashboards/DashboardCooks.vue'),
        meta: {
            middlewareAuth: true
        },
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
            path: '/invoices',
            component: require('./components/cashiers/Invoices.vue'),
            meta: {
                middlewareAuth: true
            },
        }]
    }

];



const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.middlewareAuth)) {
        if (!auth.check()) {
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            });

            return;
        }
    }

    next();
})

export default router;
