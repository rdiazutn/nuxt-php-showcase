<template>
  <ProfileFirstTime v-if="firstTime" :taxes="taxes" :loading="$apollo.loading" :format-tax-function="getTaxAnswers2Send" />
  <ProfileNotFirstTime v-else :taxes="taxes" :loading="$apollo.loading" :format-tax-function="getTaxAnswers2Send" />
</template>
<script>
import { get } from 'lodash'
import ProfileQuestionsQuery from '~/../graphql/profile/GetMyProfileQuestions.graphql'
export default {
  apollo: {
    taxes: {
      prefetch: true,
      query: ProfileQuestionsQuery,
      update: (data) => {
        const formatValue = (val, question) => ({
          ...question.question.options.find(op => op.value === val.key),
          percentage: val.value
        })

        const formatQuestion = profileQuestion => ({
          ...profileQuestion,
          question: {
            ...profileQuestion.question,
            values: (get(profileQuestion, 'question.values') || []).map(val => formatValue(val, profileQuestion))
          }
        })
        const taxes = data.me.taxes.map(tax => ({
          ...tax,
          profileQuestions: tax.profileQuestions.map(formatQuestion),
          loadingTax: false
        }))
        return taxes
      }
    }
  },
  data: () => ({
    taxes: []
  }),
  computed: {
    firstTime () {
      // TODO: depende del back
      return get(this.$store.state.userInformation, 'profile_status') === 'pending' && this === 'borrar esto'
    }
  },
  methods: {
    getTaxAnswers2Send (tax2Save) {
      return tax2Save.profileQuestions.map(question => ({
        profile_question_id: question.id,
        value: question.question.value,
        selected: question.question.selected,
        values: question.question.values.map(val => ({ key: val.value, value: val.percentage }))
      }))
    }
  }
}
</script>
