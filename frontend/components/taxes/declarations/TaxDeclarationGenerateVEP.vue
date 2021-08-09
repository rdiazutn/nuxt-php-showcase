<template>
  <TheLayoutWithHeader :title="taxDeclaration.tax.name" :loading="$apollo.loading">
    <template #body>
      <div class="headline-2 my-8 px-2">
        {{ $t('taxes.declaration.ready_presentation') }}
      </div>
      <div class="px-2">
        <TheAlertInfo text="hola" />
      </div>
      <v-container>
        <v-card class="px-2">
          <v-card-title class="headline-card px-4 pt-6">
            {{ $t('taxes.declaration.total_amount') }}
          </v-card-title>
          <v-card-text class="headline-2 pt-1">
            <div class="mb-4">
              ${{ taxDeclaration.total_amonunt }}
              <TheButtonWithTooltip color="primary" icon="mdi-help-circle-outline" title="Texto sin definir" bottom />
            </div>
            <v-divider />
            <div class="d-flex justify-space-between py-7">
              <div class="headline-card">
                {{ $t('taxes.declaration.download_presentation') }}
              </div>
              <div class="custom-link-primary font-weight-regular">
                {{ $t('taxes.need_help') }}
              </div>
            </div>
            <div class="pa-3 border-solid-lightgray d-flex justify-space-between mb-4">
              <v-icon color="red">
                mdi-file-pdf
              </v-icon>
              <TheButtonWithTooltip color="primary" icon="mdi-download" :title="$t('download')" bottom />
            </div>
          </v-card-text>
        </v-card>
      </v-container>
      <v-container>
        <v-card class="px-2">
          <v-card-title class="headline-card px-4 pt-6">
            {{ $t('taxes.declaration.available_balance') }}
          </v-card-title>
          <v-card-text class="headline-2 pt-1">
            <div class="mb-4">
              ${{ taxDeclaration.total_balance }}
              <TheButtonWithTooltip color="primary" icon="mdi-help-circle-outline" title="Texto sin definir" bottom />
            </div>
            <v-divider />
            <div class="d-flex justify-space-between py-7">
              <div class="headline-card">
                {{ $t('taxes.declaration.use_balance') }}
              </div>
              <div class="custom-link-primary font-weight-regular">
                {{ $t('taxes.need_help') }}
              </div>
            </div>
            <template>
              <TaxDeclarationGenerateVEPBalanceDialog :tax-declaration="taxDeclaration" />
            </template>
          </v-card-text>
        </v-card>
      </v-container>
      <v-container>
        <v-card>
          <v-card-title class="headline-card px-4 pt-6">
            {{ $t('taxes.declaration.payment_methods_vep') }}
          </v-card-title>
          <v-btn-toggle v-model="selected_payment_method">
            <v-row>
              <v-col v-for="(method, index) in payment_methods_vep" :key="index" cols="12" md="auto">
                <v-btn>
                  {{ method.name }}
                </v-btn>
              </v-col>
            </v-row>
          </v-btn-toggle>
        </v-card>
      </v-container>
      <v-container>
        <v-expansion-panels hover>
          <v-expansion-panel class="py-3">
            <v-expansion-panel-header class="headline-card px-4">
              {{ $t('taxes.declaration.your_steps') }}
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <TheFilterTable disable-sort :headers="headers" :items="taxDeclaration.steps" :total="taxDeclaration.steps.length" hide-default-footer>
                <template #[`item.status`]="{ item }">
                  <TaxStatusChip :status="item.status" />
                </template>
                <template #[`item.actions`]="{}">
                  <TheButtonWithTooltip color="primary" icon="mdi-eye" :title="$t('see')" bottom />
                  <TheButtonWithTooltip color="primary" icon="mdi-download" :title="$t('download')" bottom />
                </template>
              </TheFilterTable>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
      </v-container>
    </template>
  </TheLayoutWithHeader>
</template>
<style scoped>
.border-solid-lightgray{
  border: 1px solid lightgray;
  border-radius: 5px;
}
</style>
<script>

export default {
  data: () => ({
    selected_payment_method: null,
    checkbox: false,
    payment_methods_vep: [
      {
        name: 'Mercado Libre',
        image_src: '',
        icon: 'mdi-check-circle'
      },
      {
        name: 'Red Link',
        image_src: '',
        icon: 'mdi-check-circle'
      },
      {
        name: 'Pago mis cuentas',
        image_src: '',
        icon: 'mdi-check-circle'
      }
    ],
    taxDeclaration: {
      total_amonunt: 9456,
      total_balance: 3548,
      total_balance_to_use: 0,
      tax: {
        name: 'Monotributo'
      },
      steps: [
        {
          document_type: 'Confirmar presentacion',
          status: 'ON_TIME',
          update_date: '12/2020'
        },
        {
          document_type: 'Generar VEP de pago',
          status: 'PENDING',
          update_date: '12/2020'
        },
        {
          document_type: 'Confirmar pago',
          status: 'PREPARING',
          update_date: '12/2020'
        }
      ]
    }
  }),
  computed: {
    headers () {
      return [
        {
          text: this.$t('taxes.declaration.document_type'),
          value: 'document_type'
        },
        {
          text: this.$t('status'),
          value: 'status'
        },
        {
          text: this.$t('update_date'),
          value: 'update_date'
        },
        {
          text: this.$vuetify.breakpoint.mdAndDown ? this.$t('actions') : '',
          value: 'actions',
          sortable: false
        },
        {
          value: 'data-table-expand'
        }
      ]
    }
  }
}
</script>
