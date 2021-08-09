<template>
  <MikePad />
</template>
<style lang="scss">

$grey-color: #707070;
$green-link: #66BB6A;
$primary-color: #326CEA;
.spinner-inner .binding{
  border: 2px solid $primary-color !important;
}
.spinner-inner .pad {
  border: 2px solid $primary-color !important;
}
.spinner-inner .pad .line{
  border-top: 2px solid $primary-color !important;
}
</style>
<script>
import { MikePad } from 'vue-loading-spinner'
export default {
  components: {
    MikePad
  }
}
</script>
