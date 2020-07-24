<template>
    <div>
        <nav
            class="navbar navbar-expand-lg bg-white border-bottom navbar-light"
        >
            <router-link class="navbar-brand mr-auto" :to="{ name: 'home' }"
                >MiniStore</router-link
            >

            <ul class="navbar-nav">
                <li class="nav-item" v-if="isLoggedIn">
                    <router-link class="nav-link" to="/coupons"
                        >Coupons</router-link
                    >
                </li>
                <li class="nav-item" v-if="isLoggedIn">
                    <router-link class="nav-link" to="/coupon/add"
                        >Add Coupon</router-link
                    >
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link class="nav-link" :to="{ name: 'login' }"
                        >Login</router-link
                    >
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link class="nav-link" :to="{ name: 'register' }"
                        >Register</router-link
                    >
                </li>
                <li class="nav-item" v-if="isLoggedIn">
                    <a href="#" class="nav-link" @click.prevent="logout"
                        >Logout</a
                    >
                </li>
            </ul>
        </nav>

        <div class="container mt-4 mb-4 pr-4 pl-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            isLoggedIn: "isLoggedIn"
        })
    },
    methods: {
        async logout() {
            try {
                axios.post("/logout");
                this.$store.dispatch("logout");
            } catch (error) {
                this.$store.dispatch("logout");
            }
        }
    }
};
</script>
