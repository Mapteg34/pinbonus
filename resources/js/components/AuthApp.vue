<template>
    <div class="auth-app mw-100 overflow-hidden d-flex">
        <sidebar active></sidebar>
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Sidebar from './Sidebar.vue';
    
    export default {
        data() {
            return {
                sideBarActive: true,
            }
        },
        components: {Sidebar}
    }
</script>

<style lang="scss">
    .auth-app {
        .content {
            transition:all 0.5s;
            padding:20px;
            width:100%;
            min-height: 100vh;
            height:100vh;
            flex-shrink: 1;
            flex-grow: 1;
            overflow: hidden;
        }
    }
</style>
