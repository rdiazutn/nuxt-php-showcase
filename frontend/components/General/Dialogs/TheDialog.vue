<template>
  <v-dialog
    v-model="mostrar"
    :persistent="persistent"
    v-bind="$attrs"
    :loading="loading"
    :max-width="maxWidth"
  >
    <template #activator="{on}">
      <slot name="activator" :on="on" />
    </template>
    <v-card>
      <v-progress-linear v-if="loading" :indeterminate="loading" />
      <v-card-title
        v-if="headerMessage"
        color="transparent"
        class="headline"
      >
        {{ headerMessage }}
        <v-spacer />
        <v-toolbar-items>
          <TheButtonWithTooltip bottom :title="$t('close')" icon="mdi-close" @click="cancel" />
        </v-toolbar-items>
      </v-card-title>
      <slot />
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: {
    persistent: {
      type: Boolean,
      default: true
    },
    value: {
      type: Boolean,
      default: true
    },
    loading: {
      type: Boolean,
      default: false
    },
    maxWidth: {
      type: String,
      default: '800'
    },
    headerMessage: {
      type: String,
      default: ''
    }
  },
  computed: {
    mostrar: {
      get () {
        return this.value
      },
      set (value) {
        this.$emit('input', value)
      }
    }
  },
  methods: {
    cancel (ev) {
      this.$emit('cancel', ev)
      this.mostrar = false
    }
  }
}
</script>
