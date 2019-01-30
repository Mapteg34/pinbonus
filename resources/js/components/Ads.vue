<template>
    <div>
        <select v-model="accountId">
            <option value="0">Выберите кабинет</option>
            <option v-for="account in accounts" :value="account.account_id">{{ account.account_name }}</option>
        </select>
        <select v-if="accountId" v-model="campaignId">
            <option value="0">Выберите кампанию</option>
            <option v-for="campaign in campaigns" :value="campaign.id">{{ campaign.name }}</option>
        </select>
        <ads-list v-if="accountId && campaignId" :accountId="accountId" :campaignId="campaignId"></ads-list>
    </div>
</template>

<script>
    import AdsList from './AdsList';
    
    export default {
        data() {
            return {
                accounts: false,
                campaigns: false,
                accountId: this.$route.params.accountId ? this.$route.params.accountId : 0,
                campaignId: this.$route.params.campaignId ? this.$route.params.campaignId : 0,
            }
        },
        components: {
            AdsList,
        },
        methods: {
            loadAccounts: function () {
                let app = this;
                
                this.$http.get('accounts').then(function (resp) {
                    app.accounts = resp.data.accounts;
                }, function () {
                    window.alertify.error('Ошибка при получении кабинетов')
                });
            },
            loadCampaigns: function () {
                let app = this;
                
                if (parseInt(app.accountId) <= 0) return;
                
                this.$http.get(`campaigns/${app.accountId}`).then(function (resp) {
                    app.campaigns = resp.data.campaigns;
                    if (parseInt(app.campaignId) > 0 && !app.campaigns.hasOwnProperty(app.campaignId)) {
                        app.campaignId = 0;
                    }
                }, function () {
                    window.alertify.error('Ошибка при получении кампаний')
                });
            },
        },
        mounted() {
            this.loadAccounts();
        },
        watch: {
            accountId: function (val, oldVal) {
                if (val === oldVal) return;
                this.loadCampaigns();
            },
        }
    }
</script>
