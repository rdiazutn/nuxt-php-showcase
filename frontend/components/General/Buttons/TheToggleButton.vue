<template>
  <toggle-button
    :width="160"
    :height="40"
    :font-size="13"
    :label="$t('calculations.field.required')"
    :color="{checked: '#1BAEC2', unchecked: '#007EA7'}"
    :labels="{unchecked: $t('not_required'), checked: $t('required')}"
  />
</template>
<script>
import { ToggleButton } from 'vue-js-toggle-button'
export default {
  components: {
    ToggleButton
  },
  methods: {
    handleChange (event) {
      this.$emit('input', event.value)
    }
  }
}
</script>
