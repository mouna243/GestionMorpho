import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Client/Home.vue'
import Register from '../components/Auth/Register.vue'
import Login from '../components/Auth/Login.vue'
import Chambers from '../components/Client/Room/Chambers.vue'
import Plats from '../components/Client/Resto/Plats.vue'
import MyReservation from '../components/Client/Room/MyReservation.vue'
// // temporary component (so you don't get errors)


const routes = [
    {
      path: '/',
      name: 'home',
      component:Home
    },
    //////
    {
        path:'/register',
        name:'register',
        component: Register
    },
    //////
    {
        path:'/login',
        name:'login',
        component: Login
    },

    {
        path : '/room',
        name :'room' ,
        component : Chambers
    },
    {
        path: '/menu',
        name : 'menu',
        component : Plats
    },
   {
        path : '/reservation',
        name : 'reservation',
        component : MyReservation
    },
    {

    } 

]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router