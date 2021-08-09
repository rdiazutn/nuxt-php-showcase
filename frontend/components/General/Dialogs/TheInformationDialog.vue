<template>
  <TheDialog
    v-model="dialog"
    width="600px"
  >
    <template v-slot:activator="{ on, attrs }">
      <slot name="activator" :on="on" :attrs="attrs" />
    </template>
    <v-card>
      <v-card-title>
        {{ title }}
      </v-card-title>
      <v-card-text>
        <slot name="body">
          {{ text }}
        </slot>
      </v-card-text>
      <v-divider />
      <v-card-actions>
        <v-spacer />
        <TheSecondaryButton
          :inner-text="$t(closeText)"
          @click="dialog = false"
        />
      </v-card-actions>
    </v-card>
  </TheDialog>
</template>
<script>
export default {
  props: {
    closeText: {
      type: String,
      default: 'close'
    },
    title: {
      type: String,
      required: true
    },
    text: {
      type: String,
      required: true
    }
  },
  data: () => ({
    dialog: false
  })
}
</script>
