import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { Quasar } from 'quasar'
import quasarLang from 'quasar/lang/fr'
import '@quasar/extras/material-icons/material-icons.css'
import 'quasar/src/css/index.sass'

createInertiaApp({
  resolve: name => import(`./Layout/Pages/${name}.vue`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Quasar, { lang: quasarLang })
      .mount(el)
  },
})
