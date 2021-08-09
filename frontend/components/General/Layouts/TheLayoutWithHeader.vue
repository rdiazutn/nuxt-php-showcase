<template>
  <v-row justify="center">
    <v-col cols="auto">
      <v-row v-if="title" class="my-4">
        <v-col cols="auto">
          <h2 class="headline-1">
            {{ $t(title, titleParams) }}
          </h2>
        </v-col>
        <v-col v-show="slotInUse('header-action')" class="text-right">
          <slot name="header-action" />
        </v-col>
      </v-row>
      <template v-show="slotInUse('header')">
        <slot name="header" />
      </template>
      <slot name="outerBody" />
      <v-card raised class="mx-auto" min-width="70vw">
        <v-progress-linear v-show="bodyInUse()" :color="loading ? 'primary' : 'transparent'" :indeterminate="loading" />
        <v-card-title v-show="slotInUse('title')" class="px-0 py-0">
          <slot name="title" />
        </v-card-title>
        <v-card-subtitle v-show="slotInUse('filter')" class="py-2">
          <slot name="filter" />
        </v-card-subtitle>
        <v-card-text v-show="slotInUse('body')" class="py-0">
          <v-row v-show="slotInUse('body')">
            <v-col>
              <slot name="body" />
            </v-col>
          </v-row>
        </v-card-text>
        <slot name="appendBody" />
        <v-row v-show="slotInUse('footer')">
          <v-col>
            <slot name="footer" />
          </v-col>
        </v-row>
      </v-card>
      <slot name="outerAppend" />
    </v-col>
  </v-row>
</template>
<script>
export default {
  props: {
    loading: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: ''
    },
    titleParams: {
      type: Object,
      default: () => ({})
    }
  },
  methods: {
    slotInUse (slotName) {
      return !!this.$slots[slotName]
    },
    bodyInUse () {
      return ['title', 'body', 'filter', 'footer'].some(this.slotInUse)
    }
  }
}
</script>
