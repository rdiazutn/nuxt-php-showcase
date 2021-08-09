<template>
  <TheAutocompleteInput
    :label="$t('documents.document_type')"
    :items="documentTypes"
    item-text="label"
    item-value="value"
    v-bind="$attrs"
    v-on="$listeners"
  />
</template>
<script>
export default {
  data: () => ({
    documentTypes: [{
      value: 'BEP',
      label: 'Boleta de pago'
    },
    {
      value: 'CDI',
      label: 'Constancia de inscripción'
    }]
  })
}
</script>
