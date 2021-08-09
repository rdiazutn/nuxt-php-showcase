<template>
  <v-avatar
    class="border-black"
    color="#EAEBED"
    :size="getSize()"
  >
    <span class="headline-question">{{ shortName }}</span>
  </v-avatar>
</template>
<style scoped>
.border-black {
  border: 1px solid black !important;
}
</style>
<script>
export default {
  props: {
    shortName: {
      type: String,
      required: true
    },
    big: {
      type: Boolean,
      default: true
    },
    medium: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    getSize () {
      return this.medium ? 45 : this.big ? 60 : 30
    }
  }
}
</script>
