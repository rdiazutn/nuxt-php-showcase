<template>
  <v-btn
    block
    height="60"
    text
    color="primary"
    v-bind="$attrs"
    class="justify-start"
    v-on="$listeners"
  >
    <v-row no-gutters class="mx-4 d-flex align-center">
      <v-col v-if="innerText" cols="auto">
        {{ innerText }}
      </v-col>
      <v-spacer />
      <v-col v-if="icon" cols="auto">
        <v-icon>
          {{ icon }}
        </v-icon>
      </v-col>
    </v-row>
  </v-btn>
</template>
<script>
export default {
  props: {
    icon: {
      type: String,
      default: null
    },
    innerText: {
      type: String,
      default: null
    }
  }
}
</script>
