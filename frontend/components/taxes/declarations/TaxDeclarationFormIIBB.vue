<template>
  <v-expansion-panels hover>
    <v-expansion-panel class="my-5 py-3">
      <v-expansion-panel-header class="headline-card">
        {{ $t('taxes.declaration.activity_bill') }}
      </v-expansion-panel-header>
      <v-expansion-panel-content>
        <div class="subtitle-1 px-6">
          {{ $t('taxes.declaration.soy_agriculture') }}
        </div>
      </v-expansion-panel-content>
    </v-expansion-panel>
    <v-expansion-panel class="mb-5 py-3">
      <v-expansion-panel-header class="headline-card">
        <div class="headline-card">
          {{ $t('taxes.declaration.province_bill') }}
        </div>
      </v-expansion-panel-header>
      <v-expansion-panel-content class="subtitle-1 px-6">
        Contenido
      </v-expansion-panel-content>
    </v-expansion-panel>
    <v-expansion-panel class="mb-5 py-3">
      <v-expansion-panel-header class="headline-card">
        <div class="headline-card">
          {{ $t('taxes.declaration.dont_billed_incomes') }}
        </div>
      </v-expansion-panel-header>
      <v-expansion-panel-content class="subtitle-1 px-6">
        Contenido
      </v-expansion-panel-content>
    </v-expansion-panel>
    <v-expansion-panel class="mb-5 py-3">
      <v-expansion-panel-header>
        <div class="headline-card">
          {{ $t('taxes.declaration.facturacion no-ingresos') }}:
        </div>
      </v-expansion-panel-header>
      <v-expansion-panel-content class="subtitle-1 px-6">
        Contenido
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>
