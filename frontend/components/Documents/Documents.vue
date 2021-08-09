<template>
  <TheLayoutWithHeader title="documents.title" :loading="loading">
    <template #filter>
      <v-row class="pt-3">
        <v-col md="3" cols="12">
          <TheDocumentTypeAutocomplete v-model="filter.documentType" />
        </v-col>
        <v-col md="3" cols="12">
          <TheTaxesAutocomplete v-model="filter.tax" />
        </v-col>
        <v-col md="3" cols="12">
          <ThePeriodAutocomplete v-model="filter.period" />
        </v-col>
        <v-col md="3" cols="12" class="pt-6">
          <TheSearchButton />
        </v-col>
      </v-row>
    </template>
    <template #body>
      <TheFilterTable :headers="headers" :items="documents" :total="documents.length">
        <template v-if="documents.length === 0" #body>
          <td :colspan="headers.length">
            <TheAlignedCenterText>
              <img src="/tables/documents.png">
            </TheAlignedCenterText>
          </td>
        </template>
        <template #[`item.actions`]="{}">
          <TheButtonWithTooltip color="primary" icon="mdi-eye" :title="$t('see')" />
          <TheButtonWithTooltip color="grey darken-2" icon="mdi-arrow-down-bold" :title="$t('download')" />
        </template>
      </TheFilterTable>
    </template>
  </TheLayoutWithHeader>
</template>
<script>
export default {
  data: () => ({
    filter: {},
    loading: false,
    documents: [
      {
        document_type: 'Constancia de inscripción',
        tax: 'IIBB',
        period: '12/2020'
      },
      {
        document_type: 'Declaración',
        tax: 'Ganancias',
        period: '12/2020'
      },
      {
        document_type: 'Boleta de pago (VEP)',
        tax: 'Monotributo',
        period: '12/2020'
      }
    ]
  }),
  computed: {
    headers () {
      return [
        {
          text: this.$t('documents.document_type'),
          value: 'document_type'
        },
        {
          text: this.$t('tax'),
          value: 'tax'
        },
        {
          text: this.$t('period'),
          value: 'period'
        },
        {
          text: this.$vuetify.breakpoint.mdAndDown ? this.$t('actions') : '',
          value: 'actions',
          sortable: false
        }
      ]
    }
  }
}
</script>
