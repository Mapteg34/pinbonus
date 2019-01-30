<template>
    <div v-if="account">
        <view-widget :element="account"></view-widget>
        <h2>Список кампаний кабинета</h2>
        <campaigns-list :accountId="account.account_id"></campaigns-list>
    </div>
</template>

<script>
    import ViewWidget from './ViewWidget';
    import CampaignsList from './CampaignsList';
    
    export default {
        data() {
            return {
                account: false,
            }
        },
        components: {
            ViewWidget,
            CampaignsList,
        },
        mounted() {
            let app = this;
            this.$http.get('accounts/' + app.$route.params.accountId).then(function (resp) {
                app.account = resp.data.account;
            }, function (resp) {
                window.alertify.error('Ошибка при получении кабинета')
            });
        },
    }
</script>
