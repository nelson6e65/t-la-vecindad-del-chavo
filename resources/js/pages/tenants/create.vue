<template>
  <div class="card">
    <div class="card-header">
      <fa icon="user-edit" fixed-width />
      Agregar inquilino</code>
    </div>

    <div class="card-body">
      <card>
        <form novalidate autocomplete="off" @submit.prevent="create" @keydown="form.onKeydown($event)">
          <alert-success :form="form">
            ¡Registro creado exitosamente!
            
            <router-link :to="{ name: 'tenants.show', params: { id }}" class="alert-link">
              <fa icon="eye" fixed-width /> Ver
            </router-link>
          </alert-success>

          <alert-error :form="form" />

          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">
              Título
            </label>

            <div class="col-md-7">
              <multiselect v-model="titleSelected"
                           label="long"
                           track-by="id"
                           :options="titles"
                           searchable
                           close-on-select
                           show-labels
                           placeholder="Ninguno"
              />
            </div>
            <has-error :form="form" field="title_id" />
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">
              Nombre
            </label>

            <div class="col-md-7">
              <input v-model="form.name" class="form-control" type="text" name="name">
              <has-error :form="form" field="name" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">
              Apodos
            </label>

            <div class="col-md-7">
              <multiselect v-model="form.nicknames"
                           :options="nicknamesOptions"
                           multiple
                           :close-on-select="false"
                           taggable
                           placeholder="Ninguno"
                           tag-placeholder="Agregar apodo"
                           @tag="addNickname"
              />
              <has-error :form="form" field="nicknames" />
              <!-- TODO: Agregar para cada apodo -->
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">
              Apartamento Nº
            </label>

            <div class="col-md-7">
              <input v-model="form.number" class="form-control" type="number" name="number" min="1" step="1">
              <has-error :form="form" field="number" />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form.busy" type="success">
                Guardar
              </v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: 'Inquilino | Agregar' }
  },

  data: () => ({
    id: null,

    form: new Form({
      name: '',
      title_id: null,
      nicknames: [],
      number: 0
    }),

    titles: [],
    titleSelected: null,

    nicknamesOptions: []
  }),

  watch: {
    titleSelected (to, from) {
      if (!to) {
        this.form.title_id = null
      } else {
        this.form.title_id = to.id
      }
    }
  },

  created () {
    this.getTitles()
  },

  methods: {
    async create () {
      const response = await this.form.post('/api/tenants')
      this.id = response.data.id

      this.form.reset()
    },

    async getTitles () {
      const response = await axios.get('/api/titles/')

      this.titles = response.data.data
    },

    addNickname (nickname) {
      this.nicknamesOptions.push(nickname)
      this.form.nicknames.push(nickname)
    }
  }
}
</script>
