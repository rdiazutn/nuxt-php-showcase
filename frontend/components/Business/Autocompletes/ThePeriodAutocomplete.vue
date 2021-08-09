<template>
  <TheAutocompleteInput
    :label="$t('period')"
    :items="period"
    v-bind="$attrs"
    v-on="$listeners"
  />
</template>
<script>
export default {
  data: () => ({
    period: ['2020/01', '2020/02', '2020/03']
  })
}
</script>
