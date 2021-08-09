<template>
  <TheComboboxInput
    v-model="val"
    :search-input.sync="textInput"
    :items="showableItems"
    :loading="loading"
    hide-no-data
    :cache-items="cacheItems"
    v-bind="$attrs"
    v-on="$listeners"
  />
</template>
<script>
import { debounce } from 'lodash'
export default {
  props: {
    getItemsFunction: {
      type: Function,
      required: true
    },
    cacheItems: {
      type: Boolean,
      default: true
    },
    defaultSelf: {
      type: Boolean,
      default: false
    },
    value: {
      validator: v => true,
      required: true
    }
  },
  data () {
    return {
      textInput: '',
      loading: false,
      items: []
    }
  },
  computed: {
    val: {
      get () {
        return this.value
      },
      set (v) {
        this.$emit('input', v)
      }
    },
    showableItems () {
      return this.items
    }
  },
  watch: {
    textInput (val) {
      if (val) {
        this.getItemsDebounced()
      }
    }
  },
  mounted () {
    if (this.defaultSelf && this.value) {
      if (Array.isArray(this.value)) {
        this.items.push(...this.value)
      } else {
        this.items.push(this.value)
      }
    }
  },
  methods: {
    getItemsDebounced: debounce(function () { this.getItems() }, 500),
    getItems () {
      this.loading = true
      this.getItemsFunction(this.textInput).then((result) => {
        if (result) {
          this.items = result
        }
      }).finally(this.stopLoading)
    },
    stopLoading () {
      this.loading = false
    }
  }
}
</script>
