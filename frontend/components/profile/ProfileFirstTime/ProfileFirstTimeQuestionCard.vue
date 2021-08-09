<template>
  <v-expansion-panel>
    <v-expansion-panel-header disable-icon-rotate expand-icon="mdi">
      <v-row>
        <v-col cols="auto">
          <TaxAvatar :short-name="tax.short_name" />
        </v-col>
        <v-col cols="auto" class="headline-question pt-8">
          {{ tax.name }}
        </v-col>
        <v-col cols="auto" class="pt-5">
          <TheButtonWithTooltip
            bottom
            color="primary"
            :loading="tax.loadingTax"
            icon="mdi-content-save-outline"
            :title="$t('profile.first_time.save_questions')"
            @click.prevent="nextTax"
          />
        </v-col>
        <v-spacer v-if="$vuetify.breakpoint.mdAndUp" />
        <v-col cols="auto" :class="{'pt-8': true, 'pr-8': $vuetify.breakpoint.mdAndUp}">
          <span :class="[isCompleted ? 'green-bg-text' : 'orange-bg-text', $vuetify.breakpoint.mdAndUp ? 'px-8' : 'px-4', 'py-1']">
            {{ `${step}/${totalSteps}` }}
          </span>
        </v-col>
      </v-row>
      <template #actions>
        <MikepadSpinner v-if="tax.loadingTax" />
        <v-icon v-else-if="isCompleted" color="green" class="pb-1">
          mdi-check-circle
        </v-icon>
        <v-icon v-else color="orange" class="pb-1">
          mdi-clock-outline
        </v-icon>
      </template>
      <ProfileDetailQuestionDialog
        :question="detailQuestion"
        :show.sync="showDetailQuestion"
        :values="detailQuestion.question.values"
        @completed="changeStep(1)"
        @close="closeDetailQuestionDialog"
      />
    </v-expansion-panel-header>
    <v-expansion-panel-content class="px-0 no-padding-child">
      <v-stepper v-model="step" class="flat-elevation">
        <v-stepper-content
          v-for="(profileQuestion,index) in tax.profileQuestions"
          :key="`${tax.id}-${index}-step-content`"
          class="pa-0"
          :step="index + 1"
        >
          <v-card flat>
            <ProfileQuestionCardBody :profile-question="profileQuestion" />
            <v-progress-linear :value="formPercentage" color="#66bb6a" />
            <v-card-actions>
              <TheAlignedEndText>
                <ThePrimaryButton
                  v-if="step !== 1"
                  height="52"
                  text
                  :inner-text="$t('go_back')"
                  class="mr-4"
                  @click="changeStep(-1)"
                />
                <ThePrimaryButton
                  v-if="step !== totalSteps"
                  height="52"
                  append-icon="mdi-chevron-right"
                  :inner-text="$t('continue')"
                  @click="changeStep(1, profileQuestion)"
                />
                <ThePrimaryButton
                  v-else
                  height="52"
                  append-icon="mdi-chevron-right"
                  :inner-text="$t('confirm')"
                  @click="nextTax"
                />
              </TheAlignedEndText>
            </v-card-actions>
          </v-card>
        </v-stepper-content>
      </v-stepper>
    </v-expansion-panel-content>
  </v-expansion-panel>
</template>
<style scoped>
.flat-elevation{
  box-shadow: none !important;
}
.no-padding-child > div{
  padding: 0px !important;
}
</style>
<script>
import ProfileMixin from '~/services/mixins/ProfileMixin'
export default {
  mixins: [ProfileMixin],
  props: {
    tax: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    step: 1,
    detailQuestion: {
      question: {
        values: []
      }
    },
    showDetailQuestion: false
  }),
  methods: {
    askForDetails (profileQuestion) {
      this.detailQuestion = profileQuestion
      this.showDetailQuestion = true
    },
    changeStep (amount, profileQuestion) {
      if (profileQuestion?.type === 'INPUT_MULTIPLE_CHOICE' && profileQuestion?.question?.values?.length > 0) {
        this.askForDetails(profileQuestion)
      } else {
        this.step += amount
      }
    },
    nextTax (ev) {
      ev.stopPropagation()
      this.$emit('nextTax', this.tax)
    },
    closeDetailQuestionDialog () {
      this.showDetailQuestion = false
    }
  }
}
</script>
