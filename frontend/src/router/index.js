import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Client/Home.vue";
import Register from "../components/Auth/Register.vue";
import Login from "../components/Auth/Login.vue";
import Chambers from "../components/Client/Room/Chambers.vue";
import Plats from "../components/Client/Resto/Plats.vue";
import SPA from "../components/Client/spa/allSaps.vue";
import adminDashboard from "../components/Admin/dashbordAdmin.vue"
import AddPlat from "../components/Admin/AddPlat.vue"
import AddDepartement from "../components/Admin/AddDepartement.vue"
import AddChambers from "../components/Admin/AddChamber.vue";
import AddWorkShift from "../components/Admin/AddWorkShift.vue";
import DashbordRH from "../components/Staff/RH/DashbordRH.vue";
import Personnel from "../components/Staff/RH/GestionPersonnel.vue"
import DashbordChef from "../components/Staff/ChefPersonnel/DashbordChef.vue"
import Absences from "../components/Staff/RH/GestionAbsences.vue"
import DashbordStaff from "../components/Staff/DashbordStaff.vue";
import AddSpaSession from "../components/Admin/AddSpa.vue"
import Profile from "../components/Client/profile.vue"
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
    path: "/SPA",
    name: "SPA",
    component: SPA,
  },
  {
    path:"/client/profile",
    name:"profile",
    component:Profile
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
    path : "/admin/SpaSession",
    name : "AddSpaSession",
    component : AddSpaSession
},
/* Staff views */
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
/* Chef Personnel */
{
  path : "/ChefPersonnel/dashbord",
  name : "ChefDashbord",
  component : DashbordChef
},
{

  path : "/RH/Absences",
  name : "Absences",
  component : Absences
},
{

  path : "/Staff/dashbord",
  name : "DashbordStaff",
  component : DashbordStaff
}
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
