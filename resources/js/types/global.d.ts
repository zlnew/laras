import type { PageProps as InertiaPageProps } from '@inertiajs/core'
import type { AxiosInstance } from 'axios'
import type ziggyRoute, { Config as ZiggyConfig } from 'ziggy-js'
import type { PageProps as AppPageProps } from './'

declare global {
  interface Window {
    axios: AxiosInstance
  }

  const route: typeof ziggyRoute
  const Ziggy: ZiggyConfig
}

declare module 'vue' {
  interface ComponentCustomProperties {
    route: typeof ziggyRoute
  }
}

declare module '@inertiajs/core' {
  interface PageProps extends InertiaPageProps, AppPageProps {}
}
