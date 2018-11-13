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
            path: '/manager',
            component: require('./components/manager/Manager.vue'),
            
            //só pode ser acedido por managers falta midleware            
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
