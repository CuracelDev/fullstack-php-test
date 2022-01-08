<template>
  <div>
    <Nav :user="user"></Nav>
  </div>
</template>

<script>
import Nav from './securedComponents/navbar.vue';
export default {
 setup(){
    const router = useRouter();
    const user = ref('');

  onMounted(async () => {
      try{
        const response = await axios.get('user');
        user.value = response.data.data
      } catch(e) {
        router.push('/login')
      }
    })
    return {user}
  }

}
</script>

<style>

</style>