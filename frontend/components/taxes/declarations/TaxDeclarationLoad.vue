<template>
  <TheLayoutWithHeader :title="taxDeclaration.tax.name" :loading="$apollo.loading">
    <template #body>
      <TaxDeclarationForm :tax-declaration-id="taxDeclarationId" />
    </template>
  </TheLayoutWithHeader>
</template>
<script>
export default {
  props: {
    taxDeclarationId: {
      type: String,
      required: true
    }
  },
  data: () => ({
    taxDeclaration: {
      tax: {
        name: 'Ingresos brutos',
        short_name: 'IIBB'
      }
    }
  })
}
</script>
