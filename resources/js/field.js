Nova.booting((Vue, router, store) => {
  Vue.component('index-download-button', require('./components/IndexField'))
  Vue.component('detail-download-button', require('./components/DetailField'))
  Vue.component('form-download-button', require('./components/FormField'))
})
