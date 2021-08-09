<template>
  <TheFormDialog v-model="show" :title="question.title" @onConfirm="try2Save" @onCancel="close">
    <template #activator="{on}">
      <TheButtonWithTooltip icon="mdi-pencil" color="orange" :title="$t('edit')" v-on="on" />
    </template>
    <template>
      <ProfileDetailQuestionDialog
        :question="question"
        :show.sync="showDetailQuestion"
        :values="question.question.values"
        @completed="saveAndClose"
        @close="closeDetailQuestionDialog"
      />
      <ProfileQuestionCardBody :profile-question="question" />
    </template>
  </TheFormDialog>
</template>
<script>
export default {
  props: {
    question: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    show: false,
    showDetailQuestion: false
  }),
  methods: {
    close () {
      this.show = false
    },
    try2Save () {
      if (this.question?.type === 'INPUT_MULTIPLE_CHOICE' && this.question?.question?.values?.length > 0) {
        this.showDetailQuestion = true
      } else {
        this.saveAndClose()
      }
    },
    saveAndClose () {
      this.$emit('save', this.question)
      this.close()
    },
    closeDetailQuestionDialog () {
      this.showDetailQuestion = false
    }
  }
}
</script>
