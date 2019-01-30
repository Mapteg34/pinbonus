<template>
    <div>
        <select v-model="account">
            <option value="0">Выберите кабинет</option>
            <option v-for="account in accounts" :value="account.account_id">{{ account.account_name }}</option>
        </select>
        <campaigns-list v-if="account" :accountId="account"></campaigns-list>
    </div>
</template>

<script>
    import CampaignsList from './CampaignsList';
    
    export default {
        data() {
            return {
                accounts: false,
                account: this.$route.params.accountId ? this.$route.params.accountId : 0,
            }
        },
        components: {
            CampaignsList,
        },
        mounted() {
            let app = this;
            this.$http.get('accounts').then(function (resp) {
                app.accounts = resp.data.accounts;
            }, function () {
                window.alertify.error('Ошибка при получении кабинетов')
            });
        },
    }
</script>
