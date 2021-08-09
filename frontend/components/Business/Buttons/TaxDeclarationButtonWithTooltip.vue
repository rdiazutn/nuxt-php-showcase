<template>
  <TheButtonWithTooltip
    v-if="['ON_TIME', 'PREPARING'].includes(declaration.status)"
    color="primary"
    icon="mdi-eye"
    :title="$t('see')"
    :to="`/taxes/declarations/${declaration.id}/view`"
    bottom
  />
  <TheButtonWithTooltip
    v-else-if="['RETURNED'].includes(declaration.status)"
    color="primary"
    icon="mdi-eye"
    :title="$t('see')"
    :to="`/taxes/declarations/${declaration.id}/generate_vep`"
    bottom
  />
  <TheButtonWithTooltip
    v-else-if="['PENDING'].includes(declaration.status)"
    color="primary"
    icon="mdi-upload"
    :title="$t('taxes.upload')"
    :to="`/taxes/declarations/${declaration.id}/load`"
    bottom
  />
</template>
<script>
export default {
  props: {
    declaration: {
      type: Object,
      required: true
    }
  }
}
</script>
