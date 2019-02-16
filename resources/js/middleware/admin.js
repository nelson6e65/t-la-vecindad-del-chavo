import Vue from 'vue'
import store from '~/store'

export default (to, from, next) => {
  if (!store.getters['auth/user'].is_admin) {
    Vue.swal({
      type: 'error',
      title: 'Oops...',
      text: 'Only admin users can acces this route!'
    })

    next({ name: 'home' })
  } else {
    next()
  }
}
