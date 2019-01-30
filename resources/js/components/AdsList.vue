<template>
    <div v-if="ads" class="ads-list-component">
        <div v-for="ad in ads" class="ad" v-if="!notDeleted || !ad.removed">
            <ul>
                <li v-for="(val,field) in ad"><span class="text-info">{{ field }}:</span>{{ val }}</li>
            </ul>
            <div class="d-flex mx-n2 justify-content-center">
                <div class="mx-2">
                    <a
                        class="btn btn-danger"
                        @click.prevent="remove"
                        :data-adid="ad.id"
                    ><span class="fa fa-trash"></span>Удалить</a>
                </div>
                <div class="mx-2">
                    <a
                        class="btn btn-success"
                        onclick="$(this).closest('.ad').find('.editor').fadeToggle()"
                    ><span class="fa fa-edit"></span>Редактировать описание</a>
                </div>
            </div>
            <ad-editor
                :desc="ad.user_desc"
                :accountId="accountId"
                :campaignId="campaignId"
                :adId="ad.id"
                style="display:none"
                v-on:updated="adUpdated"
            ></ad-editor>
        </div>
    </div>
</template>

<script>
    import AdEditor from './AdEditor.vue';
    
    export default {
        props: {
            accountId:{},
            campaignId:{},
            notDeleted: {
                default: false,
            }
        },
        data() {
            return {
                ads: false,
            }
        },
        mounted() {
            this.reloadAds();
        },
        methods: {
            reloadAds() {
                let app = this;
                app.ads = false;
                if (parseInt(app.accountId) <= 0) return;
                if (parseInt(app.campaignId) <= 0) return;
                
                app.$http.get(`ads/${app.accountId}/${app.campaignId}`).then(function (resp) {
                    app.ads = resp.data.ads;
                }, function () {
                    window.alertify.error('Ошибка при получении списка объявлений')
                });
            },
            adUpdated(ad) {
                if (!this.ads.hasOwnProperty(ad.id)) return;
                this.ads[ad.id] = ad;
            },
            remove(e) {
                let adId = $(e.target).data('adid');
                if (parseInt(adId) <= 0) return;
                
                let app = this;
                app.$http.delete(`ads/${app.accountId}/${app.campaignId}/${adId}`).then(function (resp) {
                    app.ads = resp.data.ads;
                }, function () {
                    window.alertify.error('Ошибка при удалении объявления')
                });
            },
        },
        watch: {
            accountId: function (val, oldVal) {
                if (val === oldVal) return;
                this.reloadAds();
            },
            campaignId: function (val, oldVal) {
                if (val === oldVal) return;
                this.reloadAds();
            },
        },
        components: {
            AdEditor,
        },
    }
</script>

<style lang="scss">
    .ads-list-component .ad {
        border: 1px solid gray;
        margin: 10px 0;
        padding: 10px;
        
        ul {
            list-style: none;
            display: flex;
            margin-bottom: 10px;
            padding: 0;
            flex-wrap: wrap;
            
            li {
                flex: 1 1 30%;
                display: block;
                padding: 5px;
            }
        }
    }
</style>
