<template>
  <TheLayoutWithHeader title="taxes.title">
    <template #outerAppend>
      <v-skeleton-loader v-if="$apollo.loading" type="article, actions" />
      <v-card v-for="(tax,index) in taxes" v-else :key="index" class="my-7 px-6">
        <v-row>
          <v-col cols="auto" class="mt-4">
            <TaxAvatar :short-name="tax.short_name" />
          </v-col>
          <v-col cols="auto" class="mt-4">
            <div class="headline-question mt-4">
              {{ tax.name }}
            </div>
          </v-col>
          <v-spacer />
          <v-col cols="auto" class="mt-8">
            <TaxStatusChip :status="tax.status" is-icon />
          </v-col>
        </v-row>
        <v-row class="px-1">
          <v-col>
            <strong class="mr-6">{{ $t('status') }}</strong>
            <TaxStatusChip :status="tax.status" />
          </v-col>
        </v-row>
        <v-row class="mb-5 px-1">
          <v-col>
            <strong class="mr-6">{{ $t('update_date') }}</strong>
            {{ tax.updated_at }}
          </v-col>
        </v-row>
        <v-divider />
        <v-card-actions>
          <v-col cols="6">
            <ThePrimaryButton
              height="52"
              text
              block
              :inner-text="$t('taxes.show_historic')"
              :to="`/taxes/historic?tax_id=${tax.id}`"
            />
          </v-col>
          <v-col cols="6">
            <TaxesDeclarationsDialog :tax="tax" />
          </v-col>
        </v-card-actions>
      </v-card>
    </template>
  </TheLayoutWithHeader>
</template>
<style scoped>
.card-headline-question{
  padding-top: 16px !important;
}
</style>
<script>
import GetMyTaxes from '~/../graphql/tax/GetMyTaxes.graphql'
export default {
  apollo: {
    taxes: {
      prefetch: true,
      query: GetMyTaxes,
      update: result => result.me.taxes
    }
  },
  data: () => ({
    taxes: []
  })
}
</script>
