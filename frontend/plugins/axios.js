const { get, set } = require('lodash')
export default function ({ store, $axios, redirect, app }) {
  $axios.onResponse((response) => {
    if (get(response, 'status') === 403 || get(response, 'status') === 401) {
      return redirect('/logout')
    }
    // TODO result.ok
    set(response, 'data.statusCode', response.status)
    return response
  })

  $axios.onError((error) => {
    const code = parseInt(error.response.status)
    if (code === 403 || code === 401) {
      return redirect('/logout')
    }
    // TODO: Ver manejo de errores
    // const errorMsg = get(error, 'response.data.message')
    // if (errorMsg) {
    //   app.toastBase.toastError(errorMsg)
    // }

    return error
  })

  $axios.onRequest((request) => {
    request.headers.common['Content-Language'] = app.i18n.locale || 'en'
    request.headers.common.intercepted = 'true'
    return request
  })

  const handleOrFalse = promise => promise.then((response) => {
    if (response.statusCode === 200) {
      return response
    } else {
      return false
    }
  }).catch(() => {
    return false
  })

  $axios.getOrFalse = (url, options) => {
    return handleOrFalse($axios.$get(`/api${url}`, options))
  }

  $axios.postOrFalse = (url, options) => {
    return handleOrFalse($axios.$post(`/api${url}`, options))
  }

  $axios.putOrFalse = (url, options) => {
    return handleOrFalse($axios.$put(`/api${url}`, options))
  }

  $axios.patchOrFalse = (url, options) => {
    return handleOrFalse($axios.$patch(`/api${url}`, options))
  }

  $axios.deleteOrFalse = (url, options) => {
    return handleOrFalse($axios.$delete(`/api${url}`, options))
  }
}
