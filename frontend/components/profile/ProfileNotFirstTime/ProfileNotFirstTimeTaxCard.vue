<template>
  <div class="mb-2">
    <v-row>
      <v-col cols="auto" class="headline-question pt-8">
        {{ tax.name }}
      </v-col>
      <v-col cols="auto" :class="{'pt-8': true, 'pr-8': $vuetify.breakpoint.mdAndUp}">
        <span :class="[isCompleted ? 'green-bg-text' : 'orange-bg-text', $vuetify.breakpoint.mdAndUp ? 'px-8' : 'px-4', 'py-1']">
          {{ `${totalCompleted}/${totalSteps}` }}
        </span>
      </v-col>
      <v-col cols="auto">
        <v-icon v-if="isCompleted" color="green" class="pt-4">
          mdi-check-circle
        </v-icon>
        <v-icon v-else color="orange" class="pt-4">
          mdi-clock-outline
        </v-icon>
      </v-col>
    </v-row>
    <TheCardList :items="tax.profileQuestions">
      <template #content="{ item }">
        <v-row class="my-2">
          <v-col cols="12" md="6">
            {{ item.title }}
          </v-col>
          <v-col cols="11" md="5">
            <TheLimitedLengthLabel :text="getQuestionAnswer(item)" :length="32" />
          </v-col>
          <v-col cols="auto">
            <ProfileNotFirstTimeQuestionDialog :question="clone(item)" @save="val => copyValues(val, item)" />
          </v-col>
        </v-row>
      </template>
    </TheCardList>
  </div>
</template>
<script>
import { cloneDeep } from 'lodash'
import ProfileMixin from '~/services/mixins/ProfileMixin'
export default {
  mixins: [ProfileMixin],
  props: {
    tax: {
      type: Object,
      required: true
    }
  },
  methods: {
    clone: cloneDeep,
    copyValues (origin, destination) {
      Object.assign(destination, origin)
    },
    getQuestionAnswer (profileQuestion) {
      const findOptionLabelByValue = value => profileQuestion.question.options.find(op => op.value === value).label
      return profileQuestion.question.value
        ? findOptionLabelByValue(profileQuestion.question.value)
        : profileQuestion.type === 'MULTIPLE_CHOICE' ? profileQuestion.question.selected.map(val => findOptionLabelByValue(val)).join(', ')
          : profileQuestion.question.values.map(val => val.label).join(', ')
    }
  }
}
</script>
