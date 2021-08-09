<template>
  <v-alert
    border="left"
    colored-border
    type="warning"
    elevation="2"
    class="bg-alert py-6"
  >
    <span v-if="text" class="alert-text">
      {{ text }}
    </span>
  </v-alert>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      default: ''
    }
  }
}
</script>
