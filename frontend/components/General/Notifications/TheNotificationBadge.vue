<template>
  <v-menu
    offset-y
    content-class="elevation-1"
    :close-on-content-click="false"
    max-height="400"
  >
    <template v-slot:activator="{ on }">
      <v-badge
        :content="notifications.length"
        :value="notifications.length"
        color="red lighten-1"
        class="mt-2"
        overlap
      >
        <v-icon
          v-on="on"
        >
          {{ notificationIcon }}
        </v-icon>
      </v-badge>
    </template>
    <v-card>
      <v-card-title class="py-1 center">
        {{ $t('notifications') }}
      </v-card-title>
      <v-divider />
      <div
        v-for="(notification,index) in notifications"
        :key="`notification-key-${index}`"
      >
        <slot
          name="notification"
          :item="notification"
        />
        <v-divider />
      </div>
      <template class="pt-4 pb-8 center">
        <v-list-item v-if="notifications.length" :to="notificationsRoute">
          {{ $t('see_all_notifications') }}
        </v-list-item>
        <v-subheader v-else>
          {{ $t('no_notifications_message') }}
        </v-subheader>
      </template>
    </v-card>
  </v-menu>
</template>
<script>
export default {
  props: {
    notificationIcon: {
      type: String,
      default: 'mdi-bell'
    },
    notifications: {
      type: Array,
      required: true
    },
    notificationsRoute: {
      type: String,
      default: '/notifications'
    }
  }
}
</script>
