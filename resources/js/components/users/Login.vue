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
                        <input type="text" v-model="user.password" class="form-control">
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
            loginUser() {
                let login_btn = document.querySelector('#login-btn');
                let login_status = document.querySelector('#login-status');
                login_btn.disabled = true;
                login_btn.innerHTML = "Please wait...";
                
                event.preventDefault();
                var app = this;
                var newUser = app.user;
                axios.post('/api/v1/login', newUser)
                    .then(function (response) {
                        if(response.data.type == 'success') {
                            app.$router.push({path: '/products'});
                        } else {
                            login_status.innerHTML = "<p style='color:red'>Incorrect login details. Try again</p>";
                        }
                    })
                    .catch(function (response) {
                        login_status.innerHTML = "<p style='color:red'>Incorrect login details. Try again</p>";
                    });
                login_btn.disabled = false;
                login_btn.innerHTML = "Login";
            }
        }
    }
</script>
