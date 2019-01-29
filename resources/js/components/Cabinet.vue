<template>
    <div>
        <h1>Кабинет</h1>
        <vk-auth>
            <p v-for="(val,key) in cabinet">
                <span class="text-info">{{ key }}</span>: {{ val }}
            </p>
            <table class="table" v-if="campaigns">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>type</th>
                        <th>name</th>
                        <th>status</th>
                        <th>day_limit</th>
                        <th>all_limit</th>
                        <th>start_time</th>
                        <th>stop_time</th>
                        <th>create_time</th>
                        <th>update_time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="campaign in campaigns">
                        <td>{{ campaign.id }}</td>
                        <td>{{ campaign.type }}</td>
                        <td>{{ campaign.name }}</td>
                        <td>{{ campaign.status }}</td>
                        <td>{{ campaign.day_limit }}</td>
                        <td>{{ campaign.all_limit }}</td>
                        <td>{{ campaign.start_time }}</td>
                        <td>{{ campaign.stop_time }}</td>
                        <td>{{ campaign.create_time }}</td>
                        <td>{{ campaign.update_time }}</td>
                        <td>
                            <router-link
                                class="btn btn-info fa fa-search"
                                :to="{ name: 'campaign', params:{cabinetId:cabinet.account_id, id:campaign.id} }"
                                exact
                            ></router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </vk-auth>
    </div>
</template>

<script>
    import VkAuth from './VkAuth';
    
    export default {
        data() {
            return {
                cabinet: false,
                campaigns: false,
            }
        },
        components: {
            VkAuth,
        },
        mounted() {
            let app = this;
            this.$http.get('cabinets/'+app.$route.params.id).then(function (resp) {
                app.cabinet = resp.data.cabinet;
                app.campaigns = resp.data.campaigns;
            }, function (resp) {
                alert('Ошибка при получении кабинета')
            });
        },
    }
</script>
