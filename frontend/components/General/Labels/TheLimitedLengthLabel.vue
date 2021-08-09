<template>
  <span>{{ getLimittedText(text, length) }}</span>
</template>
<script>
export default {
  props: {
    text: {
      type: String,
      required: true
    },
    length: {
      type: Number,
      required: true
    }
  },
  methods: {
    getLimittedText (text, length) {
      return text && text.length > length ? text.substr(0, length) + '...' : text
    }
  }
}
</script>
