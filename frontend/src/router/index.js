import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Client/Home.vue";
import Register from "../components/Auth/Register.vue";
import Login from "../components/Auth/Login.vue";
import Chambers from "../components/Client/Room/Chambers.vue";
import Plats from "../components/Client/Resto/Plats.vue";
import MyReservation from "../components/Client/Room/MyReservation.vue";
import SPA from "../components/Client/spa/allSaps.vue";
import adminDashboard from "../components/Admin/dashbordAdmin.vue"
import AddPlat from "../components/Admin/AddPlat.vue"
import AddDepartement from "../components/Admin/AddDepartement.vue"
import AddChambers from "../components/Admin/AddChamber.vue";
import AddWorkShift from "../components/Admin/AddWorkShift.vue";
import DashbordRH from "../components/Staff/RH/DashbordRH.vue";
import Personnel from "../components/Staff/RH/GestionPersonnel.vue"
import Taches from "../components/Staff/RH/gestionTaches.vue"

// // temporary component (so you don't get errors)

const routes = [

    // Auth views
  {
    path: "/",
    name: "home",
    component: Home,
  },
  //////
  {
    path: "/register",
    name: "register",
    component: Register,
  },
  //////
  {
    path: "/login",
    name: "login",
    component: Login,
  },
 // client views
  {
    path: "/room",
    name: "room",
    component: Chambers,
  },
  {
    path: "/menu",
    name: "menu",
    component: Plats,
  },
  {
    path: "/reservation",
    name: "reservation",
    component: MyReservation,
  },
  {
    path: "/SPA",
    name: "SPA",
    component: SPA,
  },
// Admin views

{
  path: "/admin/dashboard",
  name: "admin",
  component: adminDashboard,
},
{
    path : "/admin/plats",
    name : "plats",
    component : AddPlat
},
{
  path : "/admin/departements",
  name : "departement",
  component : AddDepartement
},
{
    path : "/admin/chambers",
    name : "chambers",
    component : AddChambers
},
{
    path : "/admin/WorkShift",
    name : "WorkShift",
    component : AddWorkShift
},
{
    path : "/RH/dashbord",
    name : "DashbordRH",
    component : DashbordRH
},
{
  path : "/RH/personnel",
  name : "personnel",
  component : Personnel
},
{
  path : "/RH/taches",
  name : "taches",
  component : Taches
}
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
