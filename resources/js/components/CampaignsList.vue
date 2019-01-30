<template>
    <list-widget v-if="campaigns" :elements="campaigns"></list-widget>
</template>

<script>
    import ListWidget from './ListWidget';
    
    export default {
        props: ['accountId'],
        data() {
            return {
                campaigns: false,
            }
        },
        components: {
            ListWidget,
        },
        mounted() {
            this.reloadCampaigns();
        },
        methods: {
            reloadCampaigns() {
                let app = this;
                app.campaigns = false;
                if (parseInt(app.accountId) <= 0) return;
                
                this.$http.get(`campaigns/${app.accountId}`).then(function (resp) {
                    let campaigns = Object.values(resp.data.campaigns);
                    campaigns.forEach(function (campaign) {
                        campaign.Actions = [{
                            class: 'btn btn-info fa fa-search',
                            to: {name: 'campaign', params: {accountId: app.accountId, campaignId: campaign.id}},
                        }];
                    });
                    app.campaigns = campaigns;
                }, function () {
                    window.alertify.error('Ошибка при получении списка кампаний')
                });
            }
        },
        watch: {
            accountId: function (val, oldVal) {
                if (val === oldVal) return;
                this.reloadCampaigns();
            },
        }
    }
</script>
