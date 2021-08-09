<template>
  <TheLayoutWithHeader>
    <template #filter>
      <v-row no-gutters class="mt-2">
        <v-col cols="11" md="4">
          <TheSearchTextInput :label="$t('dashboard.messages.search_message')" hide-details />
        </v-col>
        <v-spacer v-if="$vuetify.breakpoint.mdAndUp" />
        <v-col cols="1" md="auto" class="pt-2">
          <TheButtonWithTooltip color="grey darken-2" icon="mdi-reload" :title="$t('refresh')" />
        </v-col>
      </v-row>
      <v-row v-if="$vuetify.breakpoint.mdAndUp">
        <v-col cols="auto" class="pt-0">
          <v-checkbox v-model="allSelected" :label="$t('select_all')" />
        </v-col>
        <template v-if="anySelected">
          <v-col cols="auto">
            <TheConfirmAsyncDialog :body-message="$t('dashboard.bookmark_text')" :async-confirm-function="() => Promise.resolve(true)">
              <template #activator="{ on }">
                <TheButtonWithTooltip color="grey darken-2" :title="$t('bookmark')" icon="mdi-star-outline" v-on="on" />
              </template>
            </TheConfirmAsyncDialog>
          </v-col>
          <v-col cols="auto">
            <TheConfirmAsyncDialog :body-message="$t('dashboard.open_text')" :async-confirm-function="() => Promise.resolve(true)">
              <template #activator="{ on }">
                <TheButtonWithTooltip color="grey darken-2" :title="$t('read')" icon="mdi-email-open" v-on="on" />
              </template>
            </TheConfirmAsyncDialog>
          </v-col>
          <v-col cols="auto">
            <TheConfirmAsyncDialog :body-message="$t('dashboard.delete_text')" :async-confirm-function="() => Promise.resolve(true)">
              <template #activator="{ on }">
                <TheButtonWithTooltip color="grey darken-2" :title="$t('delete')" icon="mdi-delete" v-on="on" />
              </template>
            </TheConfirmAsyncDialog>
          </v-col>
        </template>
        <template v-else>
          <v-col cols="auto" class="pt-0">
            <v-checkbox v-model="filter.bookmarked" :label="$t('bookmarks')" />
          </v-col>
          <v-col cols="auto" class="pt-0">
            <v-combobox v-model="filter.readUnread" class="body-2" return-object item-text="text" :items="readUnreadMessagesOptions" />
          </v-col>
          <v-col cols="auto" class="pt-0">
            <v-combobox v-model="filter.status" class="body-2" return-object item-text="text" :items="statusOptions" />
          </v-col>
          <v-spacer />
          <v-col cols="auto">
            <TheButton class="body-2 text-capitalize" :inner-text="$t('clear_filters')" text color="grey" />
          </v-col>
        </template>
      </v-row>
    </template>
    <template #body>
      <TheFilterTable hide-default-header :headers="headers" :items="messages" :total="messages.length">
        <template #[`item.select`]="{ item }">
          <v-checkbox v-model="item.isSelected" />
        </template>
        <template #[`item.actions`]="{ item }">
          <TheBookmarkIcon v-model="item.isBookmarked" color="grey darken-2" :title="item.isBookmarked ? $t('unbookmark') : $t('bookmark')" />
        </template>
        <template #[`item.content`]="{ item }">
          <v-row>
            <v-col :cols="$vuetify.breakpoint.mdAndUp ? '12' : '10'">
              <div class="my-4">
                <div class="my-1 d-flex justify-start">
                  <span :class="['message-title', 'mr-1', 'subtitle-3', item.read ? 'message-title-read' : 'message-title-unread']">{{ item.title }}</span>
                  <v-chip v-if="item.status" class="text-white details-2 text-uppercase ml-1" color="#f8a463" small>
                    {{ item.status }}
                  </v-chip>
                </div>
                <div class="d-flex justify-start">
                  <TheLimitedLengthLabel :length="64" class="mt-1 body-2 text-left" :text="item.text" />
                </div>
              </div>
            </v-col>
            <v-col v-if="$vuetify.breakpoint.smAndDown" cols="auto" class="pt-10">
              <v-menu offset-y>
                <template #activator="{ on, attrs }">
                  <v-btn fab depressed v-bind="attrs" v-on="on">
                    <v-icon>
                      mdi-dots-vertical
                    </v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item>
                    <v-list-item-title @click="log(item)">
                      {{ $t('bookmark') }}
                    </v-list-item-title>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title>{{ $t('mark_as_read') }}</v-list-item-title>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title>{{ $t('delete') }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </v-col>
          </v-row>
        </template>
      </TheFilterTable>
    </template>
  </TheLayoutWithHeader>
</template>
<script>
export default {
  data: () => ({
    filter: {
      readUnread: {
        value: 'all_messages',
        text: 'Todos los mensajes'
      },
      status: {
        value: 'all_states',
        text: 'Todos los estados'
      }
    },
    messages: [
      {
        isSelected: true,
        isBookmarked: true,
        read: false,
        title: '¡Cargá tus datos!',
        text: 'Recordá que es necesario que cargues tus datos personales para que empecemos a trabajar. BLA BLA BLA BLA BLA',
        status: 'URGENT',
        period: '2020/02'
      },
      {
        isSelected: false,
        isBookmarked: false,
        read: true,
        title: 'Vencimiento de factura',
        text: '¡Subí tu factura cuanto antes! Recordá hacerla antes del 21 de enero. BLA BLA BLA BLA',
        status: '',
        period: '2020/03'
      }
    ],
    readUnreadMessagesOptions: [
      {
        value: 'all_messages',
        text: 'Todos los mensajes'
      },
      {
        value: 'read_past',
        text: 'Leídos'
      },
      {
        value: 'unread',
        text: 'No leídos'
      }
    ],
    statusOptions: [
      {
        value: 'all_states',
        text: 'Todos los estados'
      },
      {
        value: 'new',
        text: 'Nuevo'
      },
      {
        value: 'bla',
        text: 'Bla bla'
      }
    ]
  }),
  computed: {
    headers () {
      return this.$vuetify.breakpoint.mdAndUp ? [
        {
          value: 'select',
          width: '5%'
        },
        {
          value: 'actions',
          width: '5%'
        },
        {
          value: 'content',
          width: '80%'
        },
        {
          value: 'period'
        }
      ] : [
        {
          value: 'content',
          width: '80%'
        }
      ]
    },
    allSelected: {
      get () {
        return this.messages.every(message => message.isSelected)
      },
      set (value) {
        this.messages.forEach((message) => { message.isSelected = value })
      }
    },
    anySelected () {
      return this.messages.some(message => message.isSelected)
    }
  },
  methods: {
    log (a) {
    }
  }
}
</script>
