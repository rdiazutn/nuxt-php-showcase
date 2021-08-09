<template>
  <v-btn
    :disabled="disabled"
    :dark="dark && !disabled"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <v-icon v-if="icon" :color="iconColor">
      {{ icon }}
    </v-icon>
    <span v-if="innerText" class="px-5 py-2">
      {{ innerText }}
    </span>
    <v-icon v-if="appendIcon" :color="iconColor">
      {{ appendIcon }}
    </v-icon>
  </v-btn>
</template>
<script>
export default {
  props: {
    innerText: {
      type: String,
      default: ''
    },
    icon: {
      type: String,
      default: ''
    },
    appendIcon: {
      type: String,
      default: ''
    },
    iconColor: {
      type: String,
      default: ''
    },
    disabled: {
      type: Boolean,
      default: false
    },
    dark: {
      type: Boolean,
      default: false
    }
  }
}
</script>
