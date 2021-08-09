<template>
  <v-row no-gutters>
    <v-col class="mr-8">
      <TheDateInput
        v-model="filter.dateFrom"
        :label="$t('dateFrom')"
        :max-date="filter.dateTo"
      />
    </v-col>
    <v-col>
      <TheDateInput
        v-model="filter.dateTo"
        :label="$t('dateTo')"
        :min-date="filter.dateFrom"
      />
    </v-col>
  </v-row>
</template>
<script>
export default {
  props: {
    filter: {
      type: Object,
      required: true
    }
  }
}
</script>
