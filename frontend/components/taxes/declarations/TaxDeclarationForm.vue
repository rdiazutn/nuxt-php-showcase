<template>
  <v-form class="px-2" @submit.prevent="saveTax">
    <div class="headline-2 my-8">
      {{ $t('load') }}
    </div>
    <div>
      <TheAlertWarning
        :text="$t('taxes.declarations.load_suggestion')"
      />
    </div>
    <TaxDeclarationFormIIBB v-if="declaration.tax.short_name === 'IIBB'" />
    <v-divider />
    <TheAlignedEndText>
      <div class="mt-3">
        <ThePrimaryButton :inner-text="$t('confirm')" />
      </div>
    </TheAlignedEndText>
  </v-form>
</template>
<script>
import GetMyTaxPeriods from '~/../graphql/tax/GetMyTaxPeriods.graphql'
export default {
  apollo: {
    variableLoa: {
      prefetch: true,
      query: GetMyTaxPeriods
    }
  },
  props: {
    taxDeclarationId: {
      type: String,
      required: true
    }
  },
  data: () => ({
    declaration: {
      tax: {}
    }
  }),
  methods: {
    saveTax () {

    }
  }
}
</script>
