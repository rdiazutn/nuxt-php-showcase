<template>
  <TheButtonWithTooltip
    :title="$t(title)"
    dark
    :loading="loading"
    v-bind="$attrs"
    icon="mdi-file-excel"
    color="green darken-1"
    @click="getPdf"
  />
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: 'report.get_excel'
    },
    getExcelFunction: {
      type: Function,
      required: true
    },
    fileName: {
      type: String,
      default: 'filename.xlsx'
    }
  },
  data () {
    return {
      loading: false
    }
  },
  methods: {
    getPdf () {
      this.loading = true
      this.getExcelFunction().then((result) => {
        if (result) {
          const a = document.createElement('a')
          a.href = `data:pdf/png;base64,${result.message}`
          a.download = this.fileName
          a.click()
        }
      }).finally(() => { this.loading = false })
    }
  }
}
</script>
