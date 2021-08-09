<template>
  <TheAutocompleteInput
    multiple
    :label="$t('tax_plural')"
    :items="me.taxes"
    item-value="id"
    item-text="name"
    v-bind="$attrs"
    v-on="$listeners"
  />
</template>
<script>
import GetMyTaxes from '~/../graphql/tax/GetMyTaxes.graphql'
export default {
  apollo: {
    me: {
      prefetch: true,
      query: GetMyTaxes
    }
  },
  data: () => ({
    me: {
      taxes: []
    }
  })
}
</script>
