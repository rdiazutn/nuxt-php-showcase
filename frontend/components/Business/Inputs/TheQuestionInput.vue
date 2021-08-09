<template>
  <div>
    <template v-if="question.type === 'COMBO_BOX'">
      <template v-if="question.question.options.length < 3">
        <v-radio-group
          v-model="question.question.value"
          class="radio-button-centered"
          :column="$vuetify.breakpoint.mdAndDown"
        >
          <v-radio
            v-for="(option,idx) in question.question.options"
            :key="question.title + idx"
            class="mr-5"
            :label="option.label"
            :value="option.value"
          />
        </v-radio-group>
      </template>
    </template>
    <template v-else-if="['INPUT_MULTIPLE_CHOICE'].includes(question.type)">
      <v-autocomplete
        v-model="question.question.values"
        :items="question.question.options"
        multiple
        item-text="label"
        height="40"
        return-object
      >
        <template #selection="{index, item}">
          <span v-if="[0,1].includes(index)" class="mx-2">
            {{ item.label }}{{ index === 1 && question.question.values.length > 2 ? '...' : '' }}
          </span>
        </template>
      </v-autocomplete>
    </template>
    <template v-else-if="['MULTIPLE_CHOICE'].includes(question.type)">
      <v-autocomplete
        v-model="question.question.selected"
        :items="question.question.options"
        multiple
        item-text="label"
        item-value="value"
        height="40"
      >
        <template #selection="{index, item}">
          <span v-if="[0,1].includes(index)" class="mx-2">
            {{ item.label }}{{ index === 1 && getVal(question, 'question.selected.length') > 2 ? '...' : '' }}
          </span>
        </template>
      </v-autocomplete>
    </template>
  </div>
</template>
<style>
.radio-button-centered > div > div > div{
  justify-content: center;
}
</style>
<script>
import { get } from 'lodash'
export default {
  props: {
    question: {
      type: Object,
      required: true
    }
  },
  methods: {
    getVal: get
  }
}
</script>
