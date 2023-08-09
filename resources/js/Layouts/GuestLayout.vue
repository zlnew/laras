<template>
  <q-layout view="hHh lpR fFf" class="bg-blue-grey-1">

    <q-page-container>
      <slot></slot>
    </q-page-container>

    <q-toolbar class="q-pa-lg bg-blue-grey-1">
      <q-toolbar-title class="text-center text-secondary text-subtitle2">
        Copyright © 2023 Creatoku All Rights Reserved.
      </q-toolbar-title>
    </q-toolbar>
  </q-layout>
</template>