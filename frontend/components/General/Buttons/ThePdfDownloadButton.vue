<template>
  <TheButtonWithTooltip
    :title="$t(title)"
    dark
    :loading="loading"
    icon="mdi-file-pdf"
    color="red"
    v-bind="$attrs"
    @click="getPdf"
  />
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: 'report.get_pdf'
    },
    getPdfFunction: {
      type: Function,
      required: true
    },
    fileName: {
      type: String,
      default: 'filename.pdf'
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
      this.getPdfFunction().then((result) => {
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
