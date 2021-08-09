<template>
  <span>
    <v-card-title>
      <TheAlignedCenterText class="headline-2">
        {{ profileQuestion.title }}
      </TheAlignedCenterText>
    </v-card-title>
    <TheAlignedCenterText>
      <img :src="profileQuestion.image" class="profile-question-picture">
    </TheAlignedCenterText>
    <v-row no-gutters justify="center">
      <v-col cols="10" md="8" lg="4">
        <TheQuestionInput :question="profileQuestion" />
      </v-col>
    </v-row>
  </span>
</template>
<style scoped>
.profile-question-picture{
  height: 100px;
}
</style>
<script>
export default {
  props: {
    profileQuestion: {
      type: Object,
      required: true
    }
  }
}
</script>
