import { camelCase } from 'lodash'
import Rules from '~/services/rules'
import NotificationSnackbar from '~/services/NotificationSnackbar'
// DYNAMIC IMPORT OF SERVICES FROM API
const clazzList = []
const requireService = require.context(
  '~/services/api/',
  false,
  /[A-Z]\w+\.(js)$/
)
requireService.keys().forEach((fileName) => {
  const clazz = requireService(fileName)
  const serviceName = camelCase(fileName.replace(/^\.\/(.*)\.\w+$/, '$1')) + 'Service'
  clazzList.push({ Clazz: clazz.default, serviceName })
})

// DYNAMIC IMPORT OF GQL CONSUMERS
const gqlClazzList = []
const requiredGql = require.context(
  '~/services/gql/',
  false,
  /[A-Z]\w+\.(js)$/
)
requiredGql.keys().forEach((fileName) => {
  const clazz = requiredGql(fileName)
  const serviceName = camelCase(fileName.replace(/^\.\/(.*)\.\w+$/, '$1')) + 'Gql'
  gqlClazzList.push({ Clazz: clazz.default, serviceName })
})

export default function ({ app }, inject) {
  const rules = new Rules(app.i18n)
  inject('rl', rules)
  const notificationSnackbar = new NotificationSnackbar()
  inject('notification', notificationSnackbar)
  const classes = [...clazzList, ...gqlClazzList]
  classes.forEach((clazzObject) => {
    const instance = new clazzObject.Clazz({ $axios: app.$axios, i18n: app.i18n, $apollo: app.apolloProvider.defaultClient })
    inject(clazzObject.serviceName, instance)
  })
}
