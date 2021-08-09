
import AnswerProfileQuestions from '~/../graphql/profile/AnswerProfileQuestions.graphql'
export default class Profile {
  constructor ({ $apollo }) {
    this.$apollo = $apollo
  }

  answerQuestions (profileQuestions) {
    return this.$apollo.mutate({
      mutation: AnswerProfileQuestions,
      variables: {
        answers: profileQuestions
      }
    })
  }
}
