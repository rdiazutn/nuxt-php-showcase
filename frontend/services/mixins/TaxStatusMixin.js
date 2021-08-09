export default {
  data: () => ({
    statuses: [
      {
        name: 'ON_TIME',
        color: 'green',
        icon: 'mdi-check-circle'
      },
      {
        name: 'PENDING',
        color: 'orange',
        icon: 'mdi-alert'
      },
      {
        name: 'RETURNED',
        color: 'red',
        icon: 'mdi-file-alert'
      },
      {
        name: 'PREPARING',
        color: 'blue',
        icon: 'mdi-clock-time-four-outline'
      }
    ]
  }),
  methods: {
    getStatus (status) {
      return this.statuses.find(state => state.name === status)
    },
    getColorFor (status) {
      return this.getStatus(status)?.color || 'grey'
    },
    getIconFor (status) {
      return this.getStatus(status)?.icon || 'mdi-none'
    },
    getPendingTaxStatus () {
      return ['CREATED', 'DRAFT_VALIDATION', 'AWAITING_PRESENTATION', 'AWAITING_PAYMENT', 'AWAITING_APPROVAL', 'AWAITING_VOUCHER']
    }
  }
}
