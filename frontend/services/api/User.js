export default class User {
  constructor ({ $axios, i18n }) {
    this.$axios = $axios
  }

  getUserInformation () {
    return this.$axios.getOrFalse('/api/auth/user')
  }
}
