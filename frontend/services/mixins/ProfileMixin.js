export default {
  computed: {
    totalSteps () {
      return this.tax.profileQuestions.length
    },
    totalCompleted () {
      return this.completedQuestions.length
    },
    formPercentage () {
      return this.step / this.totalSteps * 100
    },
    completedQuestions () {
      return this.tax.profileQuestions.filter(question => question?.question?.value ||
        question?.question?.selected?.length > 0 ||
        (question?.question?.values && question?.question?.values?.every(val => val.percentage)))
    },
    isCompleted () {
      return this.totalCompleted === this.totalSteps
    }
  }
}
