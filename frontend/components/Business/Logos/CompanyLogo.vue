<template>
  <img
    :class="'company-' + size"
    alt="Company"
    :src="logoSrc"
  >
</template>

<style sass>
.company-big {
  width: 280px;
  margin: 5px;
}
.company-medium-big {
  width: 215px;
  margin: 5px;
}
.company-medium {
  width: 155px;
  margin: 5px;
}
.company-medium-small {
  width: 125px;
  margin: 5px;
}
.company-small {
  width: 100px;
  margin: 5px;
}
</style>
<script>
export default {
  props: {
    dark: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      default: 'medium'
    }
  },
  computed: {
    logoSrc () {
      return this.dark ? '/taxmotor-white.svg' : '/taxmotor-color.svg'
    }
  }
}
</script>
