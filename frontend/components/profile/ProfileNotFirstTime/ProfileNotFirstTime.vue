<template>
  <TheLayoutWithHeader title="profile.not_first_time.title">
    <template #body>
      <v-skeleton-loader
        v-if="loading"
        type="article"
      />
      <template v-else>
        <ProfileNotFirstTimeTaxCard v-for="(tax, index) in taxes" :key="`tax-${index}`" :tax="tax" />
      </template>
      <ThePrimaryButton
        :loading="saving"
        :disabled="loading"
        class="mt-6"
        block
        :inner-text="$t('confirm')"
        @click="saveTaxes"
      />
    </template>
  </TheLayoutWithHeader>
</template>
<script>
export default {
  props: {
    taxes: {
      type: Array,
      required: true
    },
    loading: {
      type: Boolean,
      required: true
    },
    formatTaxFunction: {
      type: Function,
      required: true
    }
  },
  data: () => ({
    saving: false
  }),
  methods: {
    saveTaxes () {
      const allAnswers = this.taxes.map(this.formatTaxFunction).flat()
      this.saving = true
      this.$profileGql
        .answerQuestions(allAnswers)
        .then((res) => {
          this.$notification.toast(this.$t('saved_ok'))
        }).finally(() => { this.saving = false })
    }
  }
}
</script>
