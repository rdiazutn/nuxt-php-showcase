<template>
  <TheAutocompleteInput
    :label="$t('status')"
    :items="statuses"
    :item-text="status => $t(status.name)"
    item-value="name"
    v-bind="$attrs"
    v-on="$listeners"
  />
</template>
<script>
import TaxStatusMixin from '~/services/mixins/TaxStatusMixin'
export default {
  mixins: [TaxStatusMixin]
}
</script>
