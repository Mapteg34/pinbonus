<template>
    <div>
        <a class="btn btn-success" v-bind:href="authHref" v-if="!$auth.user().vk_token">Получить token</a>
        <slot v-if="$auth.user().vk_token"></slot>
    </div>
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
                    redirect_uri: $('meta[name=app-url]').attr('content') + '/vkToken',
                }),
            };
        },
        mounted() {
            let app = this;
            let $codeMeta = $('meta[name=vk_code]');
            if ($codeMeta.length > 0) {
                this.$http.post('token', {
                    code: $codeMeta.attr('content'),
                }).then(function (resp) {
                    app.$auth.user(resp.data.user);
                    // TODO: remove redirect, add vue-router soft-redirect
                    window.location.href='/#cabinets';
                }, function (resp) {
                    alert('Ошибка при обновлении токена')
                });
            }
        },
    }
</script>
