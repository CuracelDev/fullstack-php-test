<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Navbar</a>
      <a href="#">{{ user.email }}</a>
    </nav>
  </div>
</template>

<script>
export default {
  props: ['user'],
}
</script>

<style>

</style>