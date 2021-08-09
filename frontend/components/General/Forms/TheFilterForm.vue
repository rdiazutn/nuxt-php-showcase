<template>
  <v-form @submit.prevent="$emit('search')">
    <input type="submit" value="Submit" class="hideInput">
    <v-row class="small-row">
      <slot name="filter-prepend" />
      <template v-if="showFromTo">
        <v-col cols="6" :md="colSize">
          <TheDateInput
            v-model="filter.dateFrom"
            :label="$t('dateFrom')"
            :max-date="filter.dateTo"
          />
        </v-col>
        <v-col cols="6" :md="colSize">
          <TheDateInput
            v-model="filter.dateTo"
            :label="$t('dateTo')"
            :min-date="filter.dateFrom"
          />
        </v-col>
      </template>
      <slot name="filter-append" />
      <v-col v-if="showSearch" cols="6" :md="colSize" class="text-right pt-4">
        <TheButtonWithTooltip
          color="primary"
          :title="$t('search')"
          icon="mdi-magnify"
          @click="$emit('search')"
        />
      </v-col>
      <slot name="filter-actions-append" />
    </v-row>
  </v-form>
</template>
<script>
export default {
  props: {
    filter: {
      type: Object,
      required: true
    },
    showFromTo: {
      type: Boolean,
      default: false
    },
    showSearch: {
      type: Boolean,
      default: true
    },
    colSize: {
      type: String,
      default: '2'
    }
  }
}
</script>
