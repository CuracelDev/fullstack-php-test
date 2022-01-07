import Secure from '../Secure'

const routes = [
  {
    path: '',
    component: () => import('./components/SubmitOrder.vue'),
    name: 'home'
  },
  {
    path: 'login',
    component: () => import('./components/auth/'),
    name: 'about'
  },
  {
    path:'/user',
    component:Secure
  }
]

export default routes;