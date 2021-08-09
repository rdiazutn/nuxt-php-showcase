export default class Rules {
  constructor (i18n) {
    this.i18n = i18n
  }

  required (field) {
    return value => !!value || this.i18n.t('errors.required')
  }

  positive (field) {
    return value => (!!value && value >= 0) || this.i18n.t('errors.positive')
  }
}
