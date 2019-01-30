<template>
    <div v-if="campaign" class="campaign-component">
        <view-widget :element="campaign"></view-widget>
        <h2>Список объявлений кампании</h2>
        <ads-list :accountId="$route.params.accountId" :campaignId="campaign.id" :notDeleted="true"></ads-list>
    </div>
</template>

<script>
    import ViewWidget from './ViewWidget';
    import AdsList from './AdsList';
    
    export default {
        data() {
            return {
                campaign: false,
            }
        },
        components: {
            ViewWidget,
            AdsList,
        },
        mounted() {
            let app = this;
            this.$http.get(
                `campaigns/${app.$route.params.accountId}/${app.$route.params.campaignId}`
            ).then(function (resp) {
                app.campaign = resp.data.campaign;
            }, function () {
                window.alertify.error('Ошибка при получении кампании');
            });
        },
    }
</script>
