<template>
    <a class="btn btn-success" v-bind:href="authHref">Войти через вк</a>
</template>

<script>
    export default {
        data() {
            return {
                authHref: 'https://oauth.vk.com/authorize?' + $.param({
                    client_id: $('meta[name=vk_app_id]').attr('content'),
                    display: 'popup',
                    scope: 'offline,ads',
                    response_type: 'code',
                    v: '5.92',
                    redirect_uri: $('meta[name=app-url]').attr('content') + '/#/login',
                }),
            };
        },
        mounted() {
            let $codeMeta = $('meta[name=vk_code]');
            if ($codeMeta.length > 0) {
                this.$auth.login({
                    params: {
                        code: $codeMeta.attr('content'),
                    },
                    success: function () {
                        window.alertify.error('Добро пожаловать');
                        // TODO: remove redirect, add vue-router soft-redirect
                        window.location.href = '/#accounts';
                    },
                    error: function () {
                        window.alertify.error('Не удалось войти в систему')
                    },
                    rememberMe: true,
                    redirect: '/',
                    fetchUser: true,
                });
            }
        },
    }
</script>
