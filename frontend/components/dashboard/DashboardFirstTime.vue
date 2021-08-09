<template>
  <v-row
    align="start"
    justify="center"
    no-gutters
  >
    <v-col cols="11" sm="10" md="8" lg="6">
      <v-card>
        <v-card-title>
          {{ $t('dashboard.welcome') }}
        </v-card-title>
        <TheAlignedCenterText>
          <img src="/dashboard/dashboard.png">
        </TheAlignedCenterText>
        <v-card-text>
          <div>
            {{ $t('dashboard.text1') }}
          </div>
          <div>
            {{ $t('dashboard.text2') }}
          </div>
          <div class="text-green">
            {{ $t('dashboard.text_green') }}
          </div>
        </v-card-text>
        <v-card-actions>
          <ThePrimaryButton to="/profile" block :inner-text="$t('dashboard.lets_start')" />
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>
