<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                        type="text"
                        name="email"
                        placeholder="Enter your E-mail"
                        class="form-control"
                        v-model="email"
                        :class="[{ 'is-invalid': errorFor('email') }]"
                    />
                    <div class="invalid-feedback" v-if="errors">
                        {{ errors }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your Password"
                        class="form-control"
                        v-model="password"
                        :class="[{ 'is-invalid': errorFor('password') }]"
                    />
                    <div class="invalid-feedback" v-if="errors">
                        {{ errors }}
                    </div>
                </div>
                <button
                    type="submit"
                    class="btn btn-primary btn-lg btn-block"
                    :disabled="loading"
                    @click.prevent="login"
                >
                    Login
                </button>

                <hr />

                <span>
                    Don't have an account?
                    <router-link :to="{ name: 'home' }" class="font-weight-bold"
                        >Register</router-link
                    >
                </span>
            </form>
        </div>
    </div>
</template>

<script>
import { logIn } from "../utils/auth";
export default {
    data() {
        return {
            email: null,
            password: null,
            errors: null,
            loading: false
        };
    },
    methods: {
        errorFor(field) {
            return this.errors !== null && this.errors[field]
                ? this.errors[field]
                : null;
        },
        async login() {
            this.loading = true;
            this.errors = null;

            try {
                await axios.get("/sanctum/csrf-cookie");
                await axios.post("/login", {
                    email: this.email,
                    password: this.password
                });

                logIn();
                this.$store.dispatch("loadUser");
                this.$router.push({ name: "home" });
            } catch (error) {
                this.errors = error.response && error.response.data.errors;
            }

            this.loading = false;
        }
    }
};
</script>
