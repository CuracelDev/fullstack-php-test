<template>
    <div class="col-md-6 col-md-offset-2" style="margin:auto">
        <h2>Create a new account </h2>
        <div>
            <form v-on:submit="registerUser()">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Fullname</label>
                        <input type="text" v-model="user.name" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Email address</label>
                        <input type="email" v-model="user.email" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Age</label>
                        <input type="number" v-model="user.age" class="form-control">
                    </div>
                </div> 
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Tax</label> (Optional)
                        <input type="text" v-model="user.tax" class="form-control">
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
                        <label class="control-label">Confirm Password</label>
                        <input type="password" v-model="user.password_confirmation" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <button class="btn btn-success" id="register-btn">Sign up!</button>
                        <div id="register-status"></div>
                    </div>
                </div>
            </form>
        </div>
        <p>Already have an account? <router-link :to="{name: 'login'}">Login now</router-link></p>
        <br/><br/>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
                user: {
                    name: '',
                    email: '',
                    age: '',
                    tax: '',
                    password: '',
                    password_confirmation: '',
                }
            }
        },
        methods: {
            async registerUser() {
                let register_btn = document.querySelector('#register-btn');
                let register_status = document.querySelector('#register-status');
                register_btn.disabled = true;
                register_btn.innerHTML = "Please wait...";
                
                event.preventDefault();
                const app = this;
                const newUser = app.user;
                await axios.post('/api/v1/register', newUser)
                    .then(function (response) {
                        if(response.data.type == 'success') {
                            register_status.innerHTML = `<p style='color:green'>Registration successful. Please wait ...</p>`;
                            setTimeout( () => {
                                app.$router.push({path: '/'});
                            }, 1500);
                        } else {
                            register_status.innerHTML = `<p style='color:red'>${response.data.message}</p>`;
                        }
                    })
                    .catch(function (response) {
                        register_status.innerHTML = "<p style='color:red'>Registration not successful. Try again</p>";
                    });
                register_btn.disabled = false;
                register_btn.innerHTML = "Sign up!";
            }
        }
    }
</script>
