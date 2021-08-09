<template>
  <div>
    Redireccionando...
  </div>
</template>
<script>
export default {
  layout: 'login',
  created () {
    // TODO: Expirar credenciales
    this.$router.push('/login')
  }
}
</script>
