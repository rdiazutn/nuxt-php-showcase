<template>
  <TheFormDialog
    :value="show"
    :header-message="question.question.input_label"
    confirm-button="continue"
    :can-confirm="allFilled && sum100"
    @onConfirm="confirm"
    @onCancel="cancel"
  >
    <template>
      <v-row>
        <v-col v-for="(input, idx) in values" :key="`${question.question.input_label}-${idx}`" cols="12" md="6">
          <TheNumericInput
            v-model="input.percentage"
            :input-name="$t('percentage')"
            :label="input.label"
          />
        </v-col>
      </v-row>
      <div class="mt-2">
        <v-alert
          dense
          light
          :type="!allFilled ? 'info' : sum100 ? 'success' : 'warning'"
        >
          {{ $t('errors.sum_100') }}
        </v-alert>
      </div>
    </template>
  </TheFormDialog>
</template>
<script>
import { get } from 'lodash'
export default {
  props: {
    question: {
      type: Object,
      required: true
    },
    show: {
      type: Boolean,
      required: true
    },
    values: {
      type: Array,
      required: true
    }
  },
  computed: {
    allFilled () {
      return this.values.every(value => get(value, 'percentage'))
    },
    sum100 () {
      return this.values
        .reduce((prevVal, input) => parseInt(get(input, 'percentage') || 0) + prevVal, 0) === 100
    }
  },
  methods: {
    confirm () {
      this.$emit('completed')
      this.$emit('close')
    },
    cancel () {
      this.$emit('close')
    }
  }
}
</script>
