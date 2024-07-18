// plugins/vuetify.js
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { data } from '@/stores/data.js'

export default {

  install: (app) => {
    let lesData = data()
    const vuetify = createVuetify({
      components,
      directives,
      theme: {
        defaultTheme: lesData.themeChoisi,
      },
    })

    app.use(vuetify)
  }
}
