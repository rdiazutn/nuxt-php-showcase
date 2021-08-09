<template>
  <TheFormDialog
    ref="form"
    v-model="showForm"
    :header-message="titleText"
    :loading="loading || loadingForm"
    :readonly="readonly"
    v-bind="$attrs"
    @onConfirm="saveOrUpdate"
    @onCancel="closeForm"
    v-on="$listeners"
  >
    <template #activator="{on}">
      <TheButtonWithTooltip
        v-if="readonly"
        :title="$t(readonlyText)"
        :disabled="disabled"
        icon="mdi-book-information-variant"
        dark
        :color="readonlyColor"
        v-on="on"
      />
      <TheButtonWithTooltip
        v-else-if="isVersioning"
        :title="$t(versionText)"
        :disabled="disabled"
        icon="mdi-tag-outline"
        :color="versionIconColor"
        v-on="on"
      />
      <TheButtonWithTooltip
        v-else-if="isCloning"
        :title="$t(copyText)"
        :disabled="disabled"
        icon="mdi-content-copy"
        :color="copyIconColor"
        v-on="on"
      />
      <TheButtonWithTooltip
        v-else-if="editMode"
        :title="titleText"
        :disabled="disabled"
        icon="mdi-pencil"
        :color="editIconColor"
        v-on="on"
      />
      <slot name="createButton" :on="on">
        <TheButton
          v-if="!editMode && !isCloning"
          :color="createButtonColor"
          :inner-text="titleText"
          :disabled="disabled"
          icon="mdi-plus"
          v-on="on"
        />
      </slot>
    </template>
    <template>
      <slot />
    </template>
  </TheFormDialog>
</template>
<script>
export default {
  props: {
    readonly: {
      type: Boolean,
      default: false
    },
    item: {
      type: Object,
      default: () => ({})
    },
    isEditing: {
      type: Function,
      default: item => item.id
    },
    isCloning: {
      type: Boolean,
      default: false
    },
    isVersioning: {
      type: Boolean,
      default: false
    },
    createFunction: {
      type: Function,
      required: true
    },
    updateFunction: {
      type: Function,
      required: true
    },
    cloneFunction: {
      type: Function,
      default: () => Promise.resolve(true)
    },
    versionFunction: {
      type: Function,
      default: () => Promise.resolve(true)
    },
    disabled: {
      type: Boolean,
      default: false
    },
    loading: {
      type: Boolean,
      default: false
    },
    toastOk: {
      type: Boolean,
      default: true
    },
    readonlyText: {
      type: String,
      default: 'check_information'
    },
    createText: {
      type: String,
      default: 'create'
    },
    editText: {
      type: String,
      default: 'edit'
    },
    copyText: {
      type: String,
      default: 'clone'
    },
    versionText: {
      type: String,
      default: 'version_verb'
    },
    editIconColor: {
      type: String,
      default: ''
    },
    copyIconColor: {
      type: String,
      default: 'secondary'
    },
    readonlyColor: {
      type: String,
      default: 'accent'
    },
    versionIconColor: {
      type: String,
      default: 'primary'
    },
    createButtonColor: {
      type: String,
      default: 'secondary'
    },
    requestsSignature: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      loadingForm: false,
      showForm: false
    }
  },
  computed: {
    titleText () {
      return this.isCloning ? this.$t(this.copyText) : this.isVersioning
        ? this.$t(this.versionText) : this.editMode
          ? this.$t(this.editText) : this.$t(this.createText)
    },
    editMode () {
      return this.isEditing(this.item)
    }
  },
  watch: {
    showForm (val) {
      if (val) {
        this.$emit('open-dialog')
        setTimeout(() => {
          this.$refs.form.resetValidation()
        }, 50)
      } else {
        this.$emit('close-dialog')
      }
    }
  },
  methods: {
    saveOrUpdate () {
      const update = () => this.updateFunction(this.item).then(this.handleResult).finally(() => { this.loadingForm = false })
      const create = () => this.createFunction(this.item).then(this.handleResult).finally(() => { this.loadingForm = false })
      const clone = () => this.cloneFunction(this.item).then(this.handleResult).finally(() => { this.loadingForm = false })
      const version = () => this.cloneFunction(this.item).then(this.handleResult).finally(() => { this.loadingForm = false })
      const executeFunction = this.isVersioning ? version : this.isCloning ? clone : this.editMode ? update : create
      if (this.requestsSignature) {
        this.$signatureService.requestSignature(executeFunction, () => {})
      } else {
        this.loadingForm = true
        executeFunction()
      }
    },
    handleResult (response) {
      if (response) {
        if (this.$refs.form) {
          this.$refs.form.resetValidation()
        }
        this.showForm = false
        if (this.toastOk) {
          this.toastSuccess(this.$t('saved-ok'))
        }
        this.$emit('saved-ok', response)
      }
    },
    closeForm () {
      this.showForm = false
    }
  }
}
</script>
