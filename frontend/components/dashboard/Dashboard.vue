<template>
  <DashboardFirstTime v-if="firstTime" />
  <DashboardNotFirstTime v-else />
</template>
<script>
import { get } from 'lodash'
export default {
  computed: {
    firstTime () {
      // TODO: borrar luego del or
      return get(this.$store.state.userInformation, 'IS_FIRST_TIME')
    }
  }
}
</script>
