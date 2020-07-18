<template>
    <div class="col-md-6 col-md-offset-2" style="margin:auto">
        <h2>Login</h2>
        <div>
            <form v-on:submit="loginUser()">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Email address</label>
                        <input type="text" v-model="user.email" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Password</label>
                        <input type="password" v-model="user.password" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <button class="btn btn-success" id="login-btn">Login</button>
                        <div id="login-status"></div>
                    </div>
                </div>
            </form>
        </div>
        <p>New to minishop? <router-link :to="{name: 'register'}">Create a new account</router-link></p>
    </div>
</template>

<script>
    import Functions from '@/components/functions';

    export default {
        data: function () {
            return {
                user: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            async loginUser() {
                let login_btn = document.querySelector('#login-btn');
                let login_status = document.querySelector('#login-status');
                Functions.disableBtn('Please wait...', login_btn);
                
                event.preventDefault();
                const app = this;
                const newUser = app.user;
                await axios.post('/api/v1/login', newUser)
                    .then(function (response) {
                        if(response.data.type == 'success') {
                            Functions.setCookie('user', response.data.token, 100);
                            app.$router.push({path: '/products'});
                        } else {
                            login_status.innerHTML = "<p style='color:red'>Incorrect login details. Try again</p>";
                        }
                    })
                    .catch(function (response) {
                        login_status.innerHTML = "<p style='color:red'>Incorrect login details. Try again</p>";
                    });
                Functions.enableBtn('Login', login_btn);
            }
        }
    }
</script>
