import Vue from 'vue'
import store from '~/store'

export default async (to, from, next) => {
  if (!store.getters['auth/check']) {
    Vue.swal({
      type: 'warning',
      title: 'Oops...',
      text: 'You need to login before access!'
    })

    next({ name: 'login' })
  } else {
    next()
  }
}
