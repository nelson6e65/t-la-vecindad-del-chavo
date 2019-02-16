const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/pages/dashboard').then(m => m.default || m)

const Tenants = () => import('~/pages/tenants/_main').then(m => m.default || m)
const TenantsIndex = () => import('~/pages/tenants/index').then(m => m.default || m)
const TenantsCreate = () => import('~/pages/tenants/create').then(m => m.default || m)
const TenantsEdit = () => import('~/pages/tenants/edit').then(m => m.default || m)
const TenantsShow = () => import('~/pages/tenants/show').then(m => m.default || m)

export default [
  { path: '/', name: 'welcome', component: Welcome },

  { path: '/login', name: 'login', component: Login },

  { path: '/dashboard', name: 'home', component: Home },
  { path: '/inquilinos',
    component: Tenants,
    children: [
      { path: '', name: 'tenants.index', component: TenantsIndex },
      { path: 'create', name: 'tenants.create', component: TenantsCreate }
    ] },
  { path: '/inquilinos/:id(\\d+)',
    component: Tenants,
    children: [
      { path: '', name: 'tenants.show', component: TenantsShow },
      { path: 'edit', name: 'tenants.edit', component: TenantsEdit }
    ] },

  { path: '*', component: NotFound }
]
