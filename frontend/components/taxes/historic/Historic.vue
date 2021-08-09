<template>
  <TheLayoutWithHeader title="historic.title" :loading="loading">
    <template #filter>
      <v-row>
        <v-col md="3" cols="12">
          <TheTaxesAutocomplete v-model="filter.tax" />
        </v-col>
        <v-col md="3" cols="12">
          <TheTaxDeclarationStatusAutocomplete v-model="filter.status" />
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
      <TheFilterTable :headers="headers" :items="taxes" :total="taxes.length">
        <template v-if="taxes.length === 0" #body>
          <td :colspan="headers.length">
            <TheAlignedCenterText>
              <img src="/tables/documents.png">
            </TheAlignedCenterText>
          </td>
        </template>
        <template #[`item.status`]="{ item }">
          <TaxStatusChip :status="item.status" />
        </template>
        <template #[`item.actions`]="{}">
          <TheButtonWithTooltip color="primary" icon="mdi-eye" :title="$t('see')" />
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
    taxes: [
      {
        name: 'Bienes personales',
        status: 'ON_TIME',
        period: '12/2020'
      },
      {
        name: 'Ingresos Brutos',
        status: 'RETURNED',
        period: '12/2020'
      },
      {
        name: 'Ganancias',
        status: 'PENDING',
        period: '12/2020'
      },
      {
        name: 'Monotributo',
        status: 'PREPARING',
        period: '12/2020'
      }
    ]
  }),
  computed: {
    headers () {
      return [
        {
          text: this.$t('tax'),
          value: 'name'
        },
        {
          text: this.$t('status'),
          value: 'status'
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
