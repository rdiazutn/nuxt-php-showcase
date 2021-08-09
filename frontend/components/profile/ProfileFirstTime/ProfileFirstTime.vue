<template>
  <TheLayoutWithHeader title="profile.first_time.title">
    <template #outerBody>
      <v-skeleton-loader
        v-if="loading"
        type="article,image, actions"
      />
      <v-expansion-panels v-else v-model="currentlyOpenned">
        <ProfileFirstTimeQuestionCard v-for="tax in taxes" :key="tax.id" :tax="tax" @nextTax="saveAndChange" />
      </v-expansion-panels>
      <ThePrimaryButton
        height="52"
        :disabled="loading"
        :loading="saving"
        class="mt-8"
        block
        :inner-text="$t('send_form')"
        @click="saveAll"
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
    currentlyOpenned: 0,
    saving: false
  }),
  methods: {
    saveAll () {
      const allAnswers = this.taxes.map(this.formatTaxFunction).flat()
      this.saveAnswers(allAnswers)
    },
    saveAndChange (tax2Save) {
      const index2Open = this.taxes.indexOf(tax2Save) + 1
      if (index2Open === this.taxes.length) {
        this.currentlyOpenned = null
      } else {
        this.currentlyOpenned = index2Open
      }
      const answers2Save = this.formatTaxFunction(tax2Save)
      tax2Save.loadingTax = true
      this.saveAnswers(answers2Save).finally(() => { tax2Save.loadingTax = false })
    },
    saveAnswers (answers2Save) {
      this.saving = true
      return this.$profileGql
        .answerQuestions(answers2Save)
        .then((res) => {
          this.$notification.toast(this.$t('saved_ok'))
        })
        .finally(() => { this.saving = false })
    }
  }
}
</script>
