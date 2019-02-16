<template>
  <card title="Escritorio">
    ¡Bienvenido, <strong>{{ user.name }}</strong>!
  </card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',

  computed: mapGetters({
    user: 'auth/user'
  }),

  metaInfo () {
    return { title: 'Home' }
  }
}
</script>
