export const state = () => ({
  userInformation: {}
})
export const mutations = {
  SET_USER_INFORMATION (state, userInfo) {
    state.userInformation = userInfo
  }
}
export const actions = {
  async nuxtClientInit ({ commit }, { $userService }) {
    const userInfo = await $userService.getUserInformation()
    if (userInfo) {
      commit('SET_USER_INFORMATION', userInfo)
    }
  }
}
