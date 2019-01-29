<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <router-link :to="{ name: 'home' }" class="navbar-brand">PinBonus</router-link>
            <button
                class="navbar-toggler navbar-toggler-right"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <router-link tag="li" class="nav-item" active-class="active" :to="{ name: 'home' }" exact><a class="nav-link">Главная</a></router-link>
                    <router-link tag="li" class="nav-item" active-class="active" :to="{ name: 'login' }"><a class="nav-link">Войти</a></router-link>
                    <router-link tag="li" class="nav-item" active-class="active" :to="{ name: 'register' }"><a class="nav-link">Регистрация</a></router-link>
                </ul>
            </div>
        </nav>
        <main>
            <h1 v-if="$router.currentRoute.meta.title">{{ $router.currentRoute.meta.title }}</h1>
            <router-view></router-view>
        </main>
    </div>
</template>
