<template>
  <TheLayoutWithHeader title="dashboard.title" :title-params="{ name: userName }">
    <template #appendBody>
      <v-skeleton-loader
        v-if="$apollo.loading"
        type="article"
      />
      <template v-else>
        <v-tabs v-model="selectedTab" grow>
          <v-tab>{{ $t('messages') }}</v-tab>
          <v-tab>{{ $t('dashboard.next_expirations') }}</v-tab>
        </v-tabs>
        <v-row>
          <v-col>
            <DashboardMessages v-if="selectedTab === 0" />
            <DashboardNextExpirations v-if="selectedTab === 1" />
          </v-col>
        </v-row>
      </template>
    </template>
    <template #outerAppend>
      <v-row class="mt-6">
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title class="headline-card">
              {{ $t('information') }}
            </v-card-title>
            <v-card-text>
              <TheCardList :items="taxStatuses">
                <template #content="{ item }">
                  <v-row no-gutters class="d-flex align-center">
                    <v-col cols="5" md="5" class="body-1">
                      {{ item.name }}
                    </v-col>
                    <v-col cols="4" md="4" class="d-flex justify-center">
                      <TaxStatusChip :status="item.status" class="details-2 text-uppercase" />
                    </v-col>
                    <v-col cols="3" md="3" class="d-flex justify-end">
                      <TheButtonWithTooltip icon="mdi-help-circle-outline" bottom color="primary" :title="item.message" />
                    </v-col>
                  </v-row>
                </template>
              </TheCardList>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title class="headline-card">
              {{ $t('dashboard.last_events') }}
            </v-card-title>
            <TheCardList :items="lastEvents">
              <template #content="{ item }">
                <v-row class="mx-2 my-2">
                  <v-col cols="auto">
                    <TaxAvatar medium :short-name="item.tax.short_name" />
                  </v-col>
                  <v-col cols="auto">
                    <div class="body-1">
                      {{ item.event_name }}
                    </div>
                    <div class="details-1" style="color:#9A9A9A">
                      {{ item.period }} - {{ item.owner }}
                    </div>
                  </v-col>
                  <v-spacer />
                  <v-col cols="auto mt-3 pt-0">
                    <TheButtonWithTooltip color="grey darken-2" icon="mdi-chevron-right" :title="$t('dashboard.check_event')" />
                  </v-col>
                </v-row>
              </template>
            </TheCardList>
            <v-divider />
            <v-card-actions class="py-0 px-0">
              <TheTextBlockButton :inner-text="$t('dashboard.see_all_events')" icon="mdi-chevron-right" />
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </template>
  </TheLayoutWithHeader>
</template>
<script>
import { get } from 'lodash'
export default {
  data: () => ({
    selectedTab: 0,
    taxStatuses: [
      {
        name: 'Monotributo',
        status: 'ON_TIME',
        message: 'Tu documentación fue aceptada'
      },
      {
        name: 'Ingresos Brutos',
        status: 'PENDING',
        message: '¡Despreocupate! Cargá la documentación y te ayudaremos'
      },
      {
        name: 'Bienes Personales',
        status: 'PREPARING',
        message: 'Preparamos tu documentación para presentarla'
      }
    ],
    lastEvents: [
      {
        tax: {
          short_name: 'M'
        },
        event_name: 'Carga de Monotributo',
        period: '2020/02',
        owner: 'Tu',
        id: 1234
      },
      {
        tax: {
          short_name: 'M'
        },
        event_name: 'Pago del Monotributo',
        period: '2020/02',
        owner: 'TM',
        id: 1234
      },
      {
        tax: {
          short_name: 'BP'
        },
        event_name: 'Carga de Bienes Personales',
        period: '2020/02',
        owner: 'Tu',
        id: 1234
      },
      {
        tax: {
          short_name: 'IIBB'
        },
        event_name: 'Carga de Ingresos Brutos',
        period: '2020/02',
        owner: 'TM',
        id: 1234
      }
    ]
  }),
  computed: {
    userName () {
      return get(this.$store.state, 'userInformation.name')
    }
  }
}
</script>
