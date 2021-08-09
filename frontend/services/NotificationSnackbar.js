export default class NotificationSnackbar {
  constructor () {
    this.observers = []
  }

  attach (observer) {
    this.observers.push(observer)
  }

  toast (text, timeout = 5000) {
    this.observers.forEach(observer => observer.showSnackbar(text, timeout))
  }
}
