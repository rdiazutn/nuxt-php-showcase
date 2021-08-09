<template>
  <span>
    <span v-for="(item, index) in items" :key="index">
      <div>
        <slot name="content" :item="item" />
      </div>
      <v-divider v-if="index !== (items.length - 1)" class="my-2" />
    </span>
  </span>
</template>
<script>
export default {
  props: {
    items: {
      type: Array,
      required: true
    }
  }
}
</script>
