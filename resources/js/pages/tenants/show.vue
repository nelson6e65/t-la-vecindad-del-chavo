<template>
  <div class="card">
    <div class="card-header">
      <fa icon="user" fixed-width />
      Detalles del Inquilino <code>{ {{ id }} }</code>
    </div>

    <div class="card-body">
      <div class="row">
        <div class="col-sm-3 col-md-4">
          <img :src="data.avatar_url" class="img-fluid img-thumbnail" height="200" width="100%">
        </div>

        <div class="col-sm">
          <div class="list-group">
            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h4 class="mb-1">
                  Título
                </h4>
              </div>

              <p class="mb-1">
                <span v-if="data.title">
                  {{ data.title.long }}
                </span>

                <span v-else class="font-italic">Ninguno</span>
              </p>
            </div>

            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h4 class="mb-1">
                  Nombre
                </h4>
              </div>

              <p class="mb-1">
                {{ data.name }}
              </p>
            </div>

            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h4 class="mb-1">
                  Apodos
                </h4>
              </div>

              <p class="mb-1">
                <span v-if="!data.nicknames || !data.nicknames.length" class="font-italic">
                  Ninguno
                </span>

                <template v-else >
                  <ul class="list-unstyled mb-0">
                    <li v-for="apodo in data.nicknames">
                      {{ apodo }}
                    </li>
                  </ul>
                </template>
              </p>
            </div>

            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h4 class="mb-1">
                  Apartamento
                </h4>
                <small>{{ data.number }}</small>
              </div>

              <p class="mb-1">
                Este inquilino vive en el apartamento <strong>Nº {{ data.number }}</strong>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="list-group">
      <div class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h4 class="mb-1">
            Creado el
          </h4>
          <small>{{ $moment.utc(data.created_at).local().fromNow() }}</small>
        </div>
        <p class="mb-1">
          {{ $moment.utc(data.created_at).local().format('YYYY-MM-DD HH:mm:ss Z') }}
        </p>
      </div>

      <div class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h4 class="mb-1">
            Actualizado el
          </h4>
          <small>{{ $moment.utc(data.updated_at).local().fromNow() }}</small>
        </div>
        <p class="mb-1">
          {{ $moment.utc(data.updated_at).local().format('YYYY-MM-DD HH:mm:ss Z') }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: 'Inquilino | Detalles' }
  },

  data: () => ({
    data: null
  }),
  computed: {
    id () {
      return this.$route.params.id
    }
  },

  watch: {
    id (to, from) {
      this.getData(to)
    }
  },

  created () {
    this.getData()
  },

  methods: {
    async getData (id) {
      if (!id) {
        id = this.id
      }

      const response = await axios.get('/api/tenants/' + id)

      this.data = response.data
    }

  }
}
</script>
