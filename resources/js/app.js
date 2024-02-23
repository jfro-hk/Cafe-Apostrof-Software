import './bootstrap'
import '../scss/main.scss'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import vuetify from './Plugins/vuetify'
import toast from './Plugins/toast'
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import CKEditor from '@ckeditor/ckeditor5-vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Cafe'
// const ck = {
//   editor: ClassicEditor,
//   editorData: '<p>Content of the editor.</p>',
//   editorConfig: {
//     // The configuration of the editor.
//   }
// }
createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(vuetify)
      .use(toast)
      .use( CKEditor )
      .mount(el)
  },
  progress: {
    color: '#4CAF50',
  },
})
