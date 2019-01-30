<template>
    <list-widget v-if="accounts" :elements="accounts"></list-widget>
</template>

<script>
    import ListWidget from './ListWidget';
    
    export default {
        data() {
            return {
                accounts: [],
            }
        },
        components: {
            ListWidget,
        },
        mounted() {
            let app = this;
            
            this.$http.get('accounts').then(function (resp) {
                let accounts = Object.values(resp.data.accounts);
                accounts.forEach(function (account) {
                    account.Actions = [{
                        class: 'btn btn-info fa fa-search',
                        to: {name: 'account', params: {accountId: account.account_id}},
                    }];
                });
                app.accounts = accounts;
            }, function () {
                window.alertify.error('Ошибка при получении списка кабинетов')
            });
        },
    }
</script>
