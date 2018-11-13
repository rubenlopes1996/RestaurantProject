<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                authenticated: auth.check(),
                user: auth
            };
        }
    };
</script>