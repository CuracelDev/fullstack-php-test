<template>
  <div class="container">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <ul class="navbar-nav">
        <li v-if="!loggedIn" class="nav-item">
          <router-link to="/" class="nav-link">Login</router-link>
        </li>
        <li v-if="!loggedIn" class="nav-item">
          <router-link to="/register" class="nav-link">Register</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/coupons" class="nav-link">Coupons</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/products" class="nav-link">Products</router-link>
        </li>
        <li v-if="loggedIn" class="nav-item">
          <router-link to="/orders" class="nav-link">Orders</router-link>
        </li>
        <li v-if="loggedIn" class="nav-item">
          <a href="#" @click="logout()" class="nav-link">Logout</a>
        </li>
      </ul>
    </nav><br/>
    <transition name="fade">
      <router-view/></router-view>
    </transition>
  </div>
</template>

<style>
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
      opacity: 0
    }
</style>

<script>

    import Functions from '@/components/functions';

    export default {
      data: function () {
        return {
          loggedIn: false,  
        }
      },
      mounted() {
        const user = Functions.getCookie('user');

        if(user) {
          this.loggedIn = true;
        }
      }, 
      
      methods: {
        logout() {
          const confirmLogout = window.confirm('Logout?');
          if(confirmLogout) {
            const app = this;
            Functions.deleteCookie('user');
            window.location="/";
          }
        }
      }
    }
</script>