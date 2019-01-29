<template>
    <div>
        <h1>Список кабинетов</h1>
        <vk-auth>
            <table class="table" v-if="cabinets">
                <thead>
                    <tr>
                        <th>account_id</th>
                        <th>account_type</th>
                        <th>account_status</th>
                        <th>account_name</th>
                        <th>access_role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cabinet in cabinets">
                        <td>{{ cabinet.account_id }}</td>
                        <td>{{ cabinet.account_type }}</td>
                        <td>{{ cabinet.account_status }}</td>
                        <td>{{ cabinet.account_name }}</td>
                        <td>{{ cabinet.access_role }}</td>
                        <td>
                            <router-link
                                class="btn btn-info fa fa-search"
                                :to="{ name: 'cabinet', params:{id:cabinet.account_id} }"
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
                cabinets: [],
            }
        },
        components: {
            VkAuth,
        },
        mounted() {
            let app = this;
            
            this.$http.get('cabinets').then(function (resp) {
                app.cabinets = resp.data.cabinets;
            }, function (resp) {
                alert('Ошибка при получении списка кабинетов')
            });
        },
    }
</script>
