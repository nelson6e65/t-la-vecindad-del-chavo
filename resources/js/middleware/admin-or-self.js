import Vue from 'vue'
import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].id !== to.params.id && !store.getters['auth/user'].is_admin) {
    Vue.swal({
      type: 'error',
      title: 'Oops...',
      text: 'Only admin users or self can access this route!'
    })

    next({ name: 'home' })
  } else {
    next()
  }
}
