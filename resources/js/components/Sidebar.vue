<template>
    <div class="sidebar min-vh-100 overflow-hidden">
        <div class="head text-center">
            <p class="name p-0 m-0">PinBonus</p>
        </div>
        <nav class="nav flex-column">
            <router-link class="nav-link" active-class="active" :to="{ name: 'home' }" exact>
                <i class="fa fa-home"></i>
                <span class="text">Главная</span>
            </router-link>
            <vk-auth>
                <router-link class="nav-link" active-class="active" :to="{ name: 'cabinets' }" exact>
                    <i class="fa fa-globe"></i>
                    <span class="text">Кабинеты</span>
                </router-link>
            </vk-auth>
            <router-link class="nav-link" active-class="active" :to="{ name: 'profile' }" exact>
                <i class="fa fa-user"></i>
                <span class="text">{{ $auth.user().login }}</span>
            </router-link>
            <a class="nav-link" href="javascript:void(0)" @click.prevent="$auth.logout()">
                <i class="fa fa-power-off"></i>
                <span class="text">Выйти</span>
            </a>
        </nav>
    </div>
</template>

<script>
    import VkAuth from './VkAuth';
    
    export default {
        components: {
            VkAuth,
        }
        
    }
</script>

<style lang="scss">
    .sidebar {
        background-color: #242939;
        color: white;
        transition: all 0.5s;
        flex-grow: 1;
        flex-shrink: 0;
        
        .head {
            padding: 20px;
            
            .name {
                transition: all 0.5s;
            }
        }
        
        width: 200px;
        
        nav {
            padding: 0 20px;
            
            .nav-link {
                padding: 10px 0;
                color: #c0c4d1;
                display: flex;
                align-items: stretch;
                
                .fa {
                    flex: 0 0 30px;
                    display: flex;
                    align-items: center;
                    font-size: 1.3rem;
                }
                
                &:hover {
                    background-color: #1f2433;
                    color: #fff;
                    
                    .fa {
                        color: #5d78ff;
                    }
                }
            }
        }
    }
</style>
