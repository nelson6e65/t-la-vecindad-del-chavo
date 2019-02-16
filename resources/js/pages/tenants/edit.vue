<template>
  <div class="card">
    <div class="card-header">
      <fa icon="user-edit" fixed-width />
      Editando Inquilino <code>{ {{ id }} }</code>
    </div>

    <div class="card-body">
      <card class="mb-3" title="Avatar">
        <div class="row">
          <div class="col-auto">
            <div><img :src="data.avatar_url" alt="avatar" height="150" width="150"></div>
          </div>

          <div class="col">
            <file-upload :url="'/api/tenants/' + id + '/media'" />
          </div>
        </div>
      </card>

      <card>
        <form novalidate autocomplete="off" @submit.prevent="update" @keydown="form.onKeydown($event)">
          <alert-success :form="form" message="Información actualizada" />
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
              <input v-model="form.number" class="form-control" type="number" name="number" min="0" step="1">
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
import FileUpload from '~/components/FileUpload'

export default {
  scrollToTop: false,

  components: {
    FileUpload
  },

  metaInfo () {
    return { title: 'User | Edit' }
  },

  data: () => ({
    form: new Form({
      name: '',
      title_id: null,
      nicknames: [],
      number: 0
    }),
    data: null,

    titles: [],
    titleSelected: null,

    nicknamesOptions: []
  }),
  computed: {
    id () {
      return this.$route.params.id
    }
  },

  watch: {
    id (to, from) {
      this.getData(to)
    },
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
    this.getData()
  },

  methods: {
    async getData (id) {
      if (!id) {
        id = this.id
      }

      const response = await axios.get('/api/tenants/' + id)

      this.data = response.data

      this.titleSelected = response.data.title

      this.form.name = response.data.name
      // this.form.title_id = response.data.title_id
      this.nicknamesOptions = response.data.nicknames
      this.form.nicknames = response.data.nicknames
      this.form.number = response.data.number
    },

    async update () {
      const response = await this.form.put('/api/tenants/' + this.id)

      getData()
    },

    async getTitles () {
      const response = await axios.get('/api/titles/')

      this.titles = response.data.data
    },

    addNickname (nickname) {
      this.nicknamesOptions.push(nickname)
    }
  }
}
</script>
