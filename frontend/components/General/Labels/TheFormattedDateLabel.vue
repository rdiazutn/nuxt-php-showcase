<template>
  <span>
    {{ date | moment('YYYY-MM-DD') }}
  </span>
</template>
<script>
export default {
  props: {
    date: {
      type: String,
      required: true
    }
  }
}
</script>
