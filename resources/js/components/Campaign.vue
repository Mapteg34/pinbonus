<template>
    <div>
        <h1>Кампания</h1>
        <vk-auth>
            <p v-for="(val,key) in campaign">
                <span class="text-info">{{ key }}</span>: {{ val }}
            </p>
        </vk-auth>
    </div>
</template>

<script>
    import VkAuth from './VkAuth';
    
    export default {
        data() {
            return {
                campaign: false,
            }
        },
        components: {
            VkAuth,
        },
        mounted() {
            let app = this;
            this.$http.get(
                `cabinets/${app.$route.params.cabinetId}/${app.$route.params.id}`
            ).then(function (resp) {
                app.campaign = resp.data.campaign;
            }, function (resp) {
                alert('Ошибка при получении кампании')
            });
        },
    }
</script>
