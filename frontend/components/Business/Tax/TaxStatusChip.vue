<template>
  <v-icon v-if="isIcon" :color="getColorFor(status)">
    {{ getIconFor(status) }}
  </v-icon>
  <v-chip v-else block :color="getColorFor(status)" class="w-10-em text-center-chip chip-size">
    <span class="text-white">
      {{ $t(status) }}
    </span>
  </v-chip>
</template>
<style>
.w-10-em{
  width: 9em;
}
.text-center-chip > span{
  margin: auto !important;
}
.chip-size{
  height: 28px !important;
}

@media (max-width: 959px) {

.chip-size{
  height: 24px !important;
}
}
</style>
<script>
import TaxStatusMixin from '~/services/mixins/TaxStatusMixin'
export default {
  mixins: [TaxStatusMixin],
  props: {
    status: {
      type: String,
      required: true
    },
    isIcon: {
      type: Boolean,
      default: false
    }
  }
}
</script>
