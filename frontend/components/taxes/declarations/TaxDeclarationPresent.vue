<template>
  <TheLayoutWithHeader :title="taxDeclaration.tax.name" :loading="$apollo.loading">
    <template #title>
      <v-tabs v-model="selectedTab" grow>
        <v-tab>
          {{ $t('taxes.declaration.load') }}
        </v-tab>
        <v-tab>
          {{ $t('taxes.declaration.present') }}
        </v-tab>
      </v-tabs>
    </template>
    <template #body>
      <TaxDeclarationForm v-if="selectedTab === 0" :tax-declaration-id="taxDeclarationId" />
      <TaxDeclarationGenerateVEP v-if="selectedTab === 1" />
    </template>
  </TheLayoutWithHeader>
</template>
<script>
export default {
  props: {
    taxDeclarationId: {
      type: String,
      required: true
    },
    readonly: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    taxDeclaration: {
      tax: {
        name: 'Ingresos brutos',
        short_name: 'IIBB'
      }
    },
    selectedTab: 1
  })
}
</script>
