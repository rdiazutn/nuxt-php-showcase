<template>
  <TheAutocompleteInput
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
import TheAutocompleteInput from '~/components/General/Inputs/TheAutocompleteInput'
export default {
  components: {
    TheAutocompleteInput
  },
  props: {
    getItemsFunction: {
      type: Function,
      required: true
    },
    cacheItems: {
      type: Boolean,
      default: true
    },
    ignoreItems: {
      type: Array,
      default: () => []
    },
    matchIgnoreFunction: {
      type: Function,
      default: () => false
    },
    defaultSelf: {
      type: Boolean,
      default: false
    },
    value: {
      validator: v => true,
      required: true
    },
    hasValueFunction: {
      type: Function,
      default: () => true
    }
  },
  data () {
    return {
      textInput: '',
      loading: false,
      items: [],
      getItemsDebounced: debounce(function () { this.getItems() }, 500)
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
        .filter(item => !this.ignoreItems
          .some(ignorableItem => this.matchIgnoreFunction(ignorableItem, item)))
    }
  },
  watch: {
    textInput (val) {
      if (val) {
        this.getItemsDebounced()
      }
    },
    value (val) {
      if (Array.isArray(val)) {
        const values2Add = val.filter(item => !this.items.includes(item))
        this.items.push(...values2Add)
      } else if (val && !this.items.includes(val) && this.hasValueFunction(val)) {
        this.items.push(val)
      }
    }
  },
  mounted () {
    if (this.defaultSelf && this.value) {
      if (Array.isArray(this.value)) {
        this.items.push(...this.value)
      } else if (this.hasValueFunction(this.value) && !this.items.includes(this.value)) {
        this.items.push(this.value)
      }
    }
  },
  methods: {
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
