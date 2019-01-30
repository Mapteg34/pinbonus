<template>
    <div id="app">
        <div v-if="!$auth.ready()" class="d-flex justify-content-center h-100" style="min-height: 100vh">
            <div class="spinner-border align-self-center" role="status">
                <span class="sr-only">Загрузка...</span>
            </div>
        </div>
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
                        <template v-if="$auth.ready() && !$auth.check()">
                            <router-link
                                tag="li"
                                class="nav-item align-self-center"
                                active-class="active"
                                :to="{ name: 'login' }"
                            ><a class="nav-link">Войти</a></router-link>
                        </template>
                        
                        <template v-if="$auth.ready() && $auth.check()">
                            <router-link
                                tag="li"
                                class="nav-item align-self-center"
                                active-class="active"
                                :to="{ name: 'accounts' }"
                            >
                                <a class="nav-link">Кабинеты</a>
                            </router-link>
                            <router-link
                                tag="li"
                                class="nav-item align-self-center"
                                active-class="active"
                                :to="{ name: 'campaigns' }"
                            >
                                <a class="nav-link">Кампании</a>
                            </router-link>
                            <router-link
                                tag="li"
                                class="nav-item align-self-center"
                                active-class="active"
                                :to="{ name: 'ads' }"
                            >
                                <a class="nav-link">Объявления</a>
                            </router-link>
                            <li class="nav-item dropdown align-self-center">
                                <span class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
                                    <img :src="$auth.user().photo" :alt="$auth.user().name"/> {{ $auth.user().name }}
                                </span>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                        <a href="javascript:void(0)" @click.prevent="$auth.logout({makeRequest:true})">
                                            <i class="fa fa-power-off"></i>
                                            Выйти
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </template>
                    </ul>
                </div>
            </nav>
            <main>
                <h1 v-if="$router.currentRoute.meta.title">{{ $router.currentRoute.meta.title }}</h1>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>
