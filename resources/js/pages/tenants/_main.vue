<template>
  <div class="row">
    <div class="col-md-3 mb-3">
      <card title="Inquilinos" class="settings-card mb-3">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route, exact: true }" class="nav-link" exact-active-class="active">
              <fa :icon="tab.icon" fixed-width />
              {{ tab.name }}
            </router-link>
          </li>
        </ul>
      </card>

      <card v-if="id" title="Inquilino" class="settings-card ">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in idTabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route, params: { id }, exact: true }" class="nav-link" exact-active-class="active">
              <fa :icon="tab.icon" fixed-width />
              {{ tab.name }}
            </router-link>
          </li>
        </ul>
      </card>
    </div>

    <div class="col-md-9">
      <transition name="fade" mode="out-in">        
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: ['auth'],

  data: () => ({
    // id: null
  }),

  computed: {
    tabs () {
      let tabs = []

      // Predeterminados
      tabs.push(
        {
          icon: 'users',
          name: 'Listar',
          route: 'tenants.index'
        },
        {
          icon: 'user-plus',
          name: 'Agregar',
          route: 'tenants.create'
        }
      )

      // TODO: Elementos dinámicos según el parámetro

      return tabs
    },
    id () {
      return this.$route.params.id
    },
    idTabs () {
      return [
        {
          icon: 'user',
          name: 'Detalles',
          route: 'tenants.show'
        },
        {
          icon: 'user-edit',
          name: 'Editar',
          route: 'tenants.edit'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
