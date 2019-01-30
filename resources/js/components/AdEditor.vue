<template>
    <form class="editor" @submit.prevent="submit" autocomplete="off" method="post">
        <p class="alert alert-danger" v-if="errors">
            Ошибка при сохранении описания. Исправьте и повторите попытку.
        </p>
        <div class="form-group">
            <label for="desc">Описание</label>
            <textarea id="desc" class="form-control" v-model="adDesc" required></textarea>
            <invalid-feedback :errors="errors.adDesc"></invalid-feedback>
        </div>
        <div class="text-center">
            <input type="submit" class="btn btn-success" value="Сохранить">
        </div>
    </form>
</template>

<script>
    import InvalidFeedback from './InvalidFeedback.vue';
    
    export default {
        props: [
            'desc',
            'accountId',
            'campaignId',
            'adId',
        ],
        data() {
            return {
                errors: false,
                adDesc: this.desc,
            }
        },
        components: {
            InvalidFeedback,
        },
        methods: {
            submit() {
                let app = this;
                app.errors = false;
                app.$http.patch(`ads/${app.accountId}/${app.campaignId}/${app.adId}`, {
                    desc: app.adDesc,
                }).then(function (resp) {
                    app.$emit('updated', resp.data.ad);
                }, function (resp) {
                    app.errors = resp.response.data.errors;
                });
            },
        },
        watch: {
            desc: function (val) {
                this.adDesc = val;
            },
        },
    }
</script>
