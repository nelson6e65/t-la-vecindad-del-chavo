<template>
  <card title="Lista de Inquilinos">
    <v-server-table ref="datatable" url="/api/tenants" :columns="columns" :options="options">
      <div slot="avatar_url" slot-scope="props" class="text-center">
        <img :src="props.row.avatar_url" class="img-thumbnail" height="70" width="70">
      </div>

      <ul slot="nicknames" slot-scope="props" class="list-unstyled mb-0">
        <li v-for="apodo in props.row.nicknames" class="my-0">
          {{ apodo }}
        </li>

        <li v-if="!props.row.nicknames || !props.row.nicknames.length" class="font-italic">
          Ninguno
        </li>
      </ul>

      <div slot="actions" slot-scope="props" class="text-center text-nowrap">
        <router-link :to="{ name: 'tenants.show', params: { id: props.row.id }}" class="text-info">
          <fa icon="eye" fixed-width />
        </router-link>

        <router-link :to="{ name: 'tenants.edit', params: { id: props.row.id }}">
          <fa icon="edit" fixed-width />
        </router-link>

        <a href="#" class="text-danger" @click="deleteTenant(props.row)">
          <fa icon="trash-alt" fixed-width />
        </a>
      </div>
    </v-server-table>
  </card>
</template>

<script>
import axios from 'axios'
window.axios = axios

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: 'Inquilinos | Lista' }
  },

  data: () => ({
    columns: ['avatar_url', 'name', 'nicknames', 'number', 'actions'],

    options: {
      skin: 'table table-striped table-bordered table-hover',
      sortIcon: {
        base: 'fas',
        up: 'fa-sort-alpha-down',
        down: 'fa-sort-alpha-up',
        is: 'fa-sort'
      },
      headings: {
        'avatar_url': 'Foto',
        'name': 'Nombre',
        'nicknames': 'Apodos',
        'number': 'Nº apto.',
        'actions': ''
      },
      preserveState: true,
      perPage: 5,
      perPageValues: [5, 10, 15, 20, 30, 50],
      filterable: [
        'name',
        'nicknames'
      ],
      sortable: [
        'name',
        'nicknames',
        'number'
      ],
      orderBy: {
        column: 'name'
      },
      requestKeys: {
        limit: 'per_page'
      },
      responseAdapter: function (resp) {
        var data = this.getResponseData(resp)

        return {
          data: data.data,
          count: data.total
        }
      }
    }
  }),

  created () {
  },

  methods: {
    deleteTenant (user) {
      this.$swal({
        type: 'warning',
        title: '¿Estás seguro?',
        html: 'Estás a punto de eliminar a "' + user.name + '"',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: 'gray',
        confirmButtonText: '¡Sí, elimínalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
          axios.delete('/api/tenants/' + user.id)
            .then((r) => {
              this.$swal(
                '¡Eliminado!',
                'El inquilino ha sido eliminado.',
                'success'
              )

              this.$refs.datatable.refresh()
            }).catch((error) => {
              this.$swal(
                '¡Error!',
                error.response.data.message,
                'error'
              )
            })
        }
      })
    }
  }
}
</script>
