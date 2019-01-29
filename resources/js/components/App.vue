<template>
    <div id="app">
        <div v-if="!$auth.ready()" class="d-flex justify-content-center h-100" style="min-height: 100vh">
            <div class="spinner-border align-self-center" role="status">
                <span class="sr-only">Загрузка...</span>
            </div>
        </div>
        <guest-app v-if="$auth.ready() && !$auth.check()"></guest-app>
        <auth-app v-if="$auth.ready() && $auth.check()"></auth-app>
    </div>
</template>

<script>
    import AuthApp from './AuthApp.vue';
    import GuestApp from './GuestApp.vue';
    
    export default {
        components: {AuthApp, GuestApp}
    }
</script>
