<template>
  <div class="container">
        <form @submit.prevent="submitLogin" class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login Page</div>
                    <div class="card-body">
                      <div>
                        <label for="">Email</label>
                        <input type="text" class="form-input" placeholder="Enter Email" v-model="email">
                      </div>
                      <div>
                        <label for="">Password</label>
                        <input type="password" class="form-input" placeholder="Enter Password" v-model="password">
                      </div>
                      <div class="d-flex justify-content-center my-2">
                        <button type="submit" class="btn btn-success btn-large">Submit</button>
                      </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { ref } from '@vue/reactivity';
import { useRouter } from 'vue-router';
export default {
  setup(){
    const email = ref('');
    const password = ref('');
    const router = useRouter();
    
    const submitLogin = async () => {
      const response = await axios.post('login', {
        email:email.value,
        password:password.value
      });
      
      localStorage.setItem('token', response.data.token);
        
      axios.defaults.headers['Authorization'] = `Bearer ${response.data.token}`
      
      router.push('/');
    }

    return {email, password, submitLogin}
  }
}
</script>

<style>

</style>