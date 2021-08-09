<template>
  <TheAutocompleteInput
    :items="items"
    :no-data-text="$t('no_data_autocomplete')"
    :item-text="(v) => $t(v.text)"
    item-value="value"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <template #item="{item}">
      <v-chip :color="item.color" dark>
        {{ item.text }}
      </v-chip>
    </template>
  </TheAutocompleteInput>
</template>
<script>
export default {
  props: {
    items: {
      type: Array,
      default: () => [{ text: 'yes', value: true, color: 'primary' }, { text: 'no', value: false, color: 'negate' }]
    }
  }
}
</script>
