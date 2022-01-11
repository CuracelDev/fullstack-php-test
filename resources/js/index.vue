<template>
  <v-container class="p-0 m-0" fluid>
    <v-app>
      <div>
        <v-app-bar
          color="primary"
          :width="!$vuetify.breakpoint.xsOnly || drawer ? '81%' : '100%'"
          class="float-right"
        >
          <v-app-bar-nav-icon
            color="white"
            @click="drawer = !drawer"
            v-if="$vuetify.breakpoint.xsOnly"
          ></v-app-bar-nav-icon>
          <div class="text-white font-weight-bold">{{ title }}</div>
          <v-row justify="end">
            <cart-count />
          </v-row>
        </v-app-bar>

          <v-navigation-drawer
            v-model="drawer"
            absolute
            left
            :permanent="!$vuetify.breakpoint.xsOnly"
            app
          >
            <v-sheet
              class="py-8 px-5"
              color="grey lighten-3"
            >
              <v-avatar
                size="80"
              >
                <v-img :src="'/images/ready.jpg'"></v-img>
              </v-avatar>
              <v-divider></v-divider>
              <div>{{ user.name }}</div>
              <div>{{ user.email }}</div>
              <div>&#8358;{{ (user.balance) ? user.balance : '0' | formatAmount }}</div>
            </v-sheet>
              <v-list
                nav
                dense
              >
                <v-list-item-group
                  v-model="group"
                  active-class="deep-purple--text text--accent-4"
                >
                    <v-list-item v-for="(link, index) in links"
                                 :key="index" @click="$router.push({path: link.link})"
                    >
                      <v-list-item-title><v-icon>{{ link.icon }}</v-icon> {{ link.text }}</v-list-item-title>
                    </v-list-item>
                    <v-list-item v-if="token" @click="logoutUser()">
                      <v-list-item-title><v-icon>mdi-power</v-icon> Logout</v-list-item-title>
                    </v-list-item>
                </v-list-item-group>
              </v-list>
          </v-navigation-drawer>
      </div>
    <v-main>
      <router-view></router-view>
    </v-main>
    </v-app>
  </v-container>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import CartCount from "./components/CartCount";
    export default {
        components: {
            CartCount,
        },
        data() {
            return {
                drawer: false,
                group: null,
                links: [
                    {icon: 'mdi-view-dashboard-outline', text: 'Dashboard', link: '/dashboard'},
                    {icon: 'mdi-shopping-outline', text: 'Shop', link: '/shop'},
                    {icon: 'mdi-ticket-percent-outline', text: 'Coupons', link: '/coupons'},
                    {icon: 'mdi-basket-outline', text: 'Orders', link: '/orders'}
                ],
                title: '',
            }
        },

        watch: {
            group() {
                this.drawer = false
            },

            $route(value) {
                if (value.path.includes('/dashboard')) {
                    this.title = 'Dashboard'
                }
                if (value.path.includes('/coupons')) {
                    this.title = 'Coupons'
                }
                if (value.path.includes('/orders')) {
                    this.title = 'Orders'
                }
                if (value.path.includes('/shop')) {
                    this.title = 'Shop'
                }
                if (value.path.includes('/cart')) {
                    this.title = 'Cart'
                } else {
                    this.$root.$emit('clear-discount');
                }
            }
        },

        methods: {
            ...mapActions('auth', ['logout_user']),

            logoutUser() {
                this.logout_user();
                this.$router.push({name: 'Dashboard'});
            },
        },

        computed: {
            ...mapGetters('auth', ['user', 'token']),

        }
    }
</script>
