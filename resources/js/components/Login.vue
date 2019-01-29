<template>
    <form autocomplete="off" @submit.prevent="submit" method="post">
        <p class="alert alert-danger" v-if="errors">
            Не удалось войти в систему. Исправьте ошибки ниже и повторите попытку.
        </p>
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" id="login" class="form-control" v-model="login" required>
            <invalid-feedback :errors="errors.login"></invalid-feedback>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" class="form-control" v-model="password" required>
            <invalid-feedback :errors="errors.password"></invalid-feedback>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-success">Войти</button>
            <p class="p-2 m-0">
                <router-link :to="{ name: 'register' }">Регистрация</router-link>
            </p>
        </div>
    </form>
</template>

<script>
    import InvalidFeedback from './InvalidFeedback.vue';
    
    export default {
        data() {
            return {
                login: null,
                password: null,
                errors: false,
            }
        },
        
        methods: {
            submit() {
                this.errors = false;
                let app = this;
                this.$auth.login({
                    params: {
                        login: app.login,
                        password: app.password
                    },
                    success: function () {
                    },
                    error: function () {
                    },
                    rememberMe: true,
                    redirect: '/',
                    fetchUser: true,
                });
            },
        },
        components: {
            InvalidFeedback,
        },
    }
</script>
