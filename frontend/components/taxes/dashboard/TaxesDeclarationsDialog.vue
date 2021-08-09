<template>
  <div class="text-center">
    <TheDialog
      v-model="dialog"
      :header-message="$t('load')"
    >
      <template #activator="{ on, attrs }">
        <ThePrimaryButton
          height="52"
          block
          :inner-text="$t('load')"
          v-bind="attrs"
          v-on="on"
        />
      </template>
      <div class="px-6 pb-8">
        <TheAlertInfo
          v-if="tax.status ==='ON_TIME'"
          class="mb-6"
          :text="$t('upload')"
        />
        <TheFilterTable
          class="mb-6"
          hide-default-footer
          item-key="name"
          :headers="headers"
          :items="declarationsPage.data"
          :total="declarationsPage.paginatorInfo.total"
        >
          <template #[`item.status`]="{ item }">
            <TaxStatusChip :status="item.status" />
          </template>
          <template #[`item.actions`]="{ item }">
            <TaxDeclarationButtonWithTooltip :declaration="item" />
          </template>
        </TheFilterTable>
      </div>
    </TheDialog>
  </div>
</template>

<script>
import GetMyTaxDeclarations from '~/../graphql/tax/GetMyTaxDeclarations.graphql'
import TaxStatusMixin from '~/services/mixins/TaxStatusMixin'
export default {
  apollo: {
    declarationsPage: {
      query: GetMyTaxDeclarations,
      variables () {
        return {
          taxId: this.tax.id,
          status: this.getPendingTaxStatus(),
          page: this.pageInfo.page,
          first: 10
        }
      },
      update (result) {
        return result.me.taxPeriods
      }
    }
  },
  mixins: [TaxStatusMixin],
  props: {
    tax: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      dialog: false,
      pageInfo: {
        page: 1
      },
      declarationsPage: {
        data: [],
        paginatorInfo: {
          total: 1
        }
      }
    }
  },
  computed: {
    headers () {
      return [
        {
          text: this.$t('tax'),
          value: 'tax.name',
          sortable: false
        },
        {
          text: this.$t('status'),
          value: 'status',
          sortable: false
        },
        {
          text: this.$t('period'),
          value: 'date',
          sortable: false
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
