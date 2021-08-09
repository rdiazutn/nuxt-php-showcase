<template>
  <v-menu
    min-width="230"
    max-height="400"
    content-class="elevation-5 mt-4"
    offset-y
  >
    <template v-slot:activator="{ on, attrs }">
      <v-avatar
        class="mx-5"
        color="secondary"
        size="40"
        v-bind="attrs"
        v-on="on"
      >
        <span class="text-white">AP</span>
      </v-avatar>
    </template>
    <v-list>
      <v-list-item
        v-for="(item, index) in items"
        :key="index"
        :to="item.to"
      >
        {{ $t(item.title) }}
      </v-list-item>
    </v-list>
  </v-menu>
</template>
<style scoped>
.text-white{
  color: white !important;
}
</style>
<script>
export default {
  data () {
    return {
      items: [
        {
          title: 'avatar.profile',
          to: '/profile'
        },
        {
          title: 'avatar.logout',
          to: '/logout'
        }
      ]
    }
  }
}
</script>
