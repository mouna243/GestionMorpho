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

function isAuth(to, from, next) {
  if (localStorage.getItem("token")) {
    next();
  } else {
    next({ name: "login" });
  }
}

function isGuest(to, from, next) {
  if (!localStorage.getItem("token")) {
    next();
  } else {
    next({ name: "home" });
  }
}

function isAdmin(to, from, next) {
  if (localStorage.getItem("role") === "admin") {
    next();
  } else {
    next({ name: "home" });
  }
}

function isClient(to, from, next) {
  if (localStorage.getItem("role") === "client") {
    next();
  } else {
    next({ name: "home" });
  }
}

function isChef (to, from, next) {
  if (localStorage.getItem("role") === "staff" && localStorage.getItem("department") === "ChefPersonnel") {
    next();
  } else {
    next({ name: "home" });
  }
}

function isRH (to, from, next) {
  if (localStorage.getItem("role") === "staff" && localStorage.getItem("department") === "RH") {
    next();
  } else {
    next({ name: "home" });
  }
}

function isStaff (to, from, next) {
  if (localStorage.getItem("role") === "staff" && localStorage.getItem("department") !== "ChefPersonnel" && localStorage.getItem("department") !== "RH") {
    next();
  } else {
    next({ name: "home" });
  }
}

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
    beforeEnter: [isGuest],
  },
  //////
  {
    path: "/login",
    name: "login",
    component: Login,
    beforeEnter: [isGuest],
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
    component:Profile,
    beforeEnter: [isAuth, isClient]
  },
// Admin views

{
  path: "/admin/dashboard",
  name: "admin",
  component: adminDashboard,
  beforeEnter: [isAuth, isAdmin]
},
{
    path : "/admin/plats",
    name : "plats",
    component : AddPlat,
    beforeEnter: [isAuth, isAdmin]
},
{
  path : "/admin/departements",
  name : "departement",
  component : AddDepartement,
  beforeEnter: [isAuth, isAdmin]
},
{
    path : "/admin/chambers",
    name : "chambers",
    component : AddChambers,
    beforeEnter: [isAuth, isAdmin]
},
{
    path : "/admin/WorkShift",
    name : "WorkShift",
    component : AddWorkShift,
    beforeEnter: [isAuth, isAdmin]
},
{
    path : "/admin/SpaSession",
    name : "AddSpaSession",
    component : AddSpaSession,
    beforeEnter: [isAuth, isAdmin]
},
/* Staff views */
{
    path : "/RH/dashbord",
    name : "DashbordRH",
    component : DashbordRH,
    beforeEnter: [isAuth, isRH]
},
{
  path : "/RH/personnel",
  name : "personnel",
  component : Personnel,
  beforeEnter: [isAuth, isRH]
},
/* Chef Personnel */
{
  path : "/ChefPersonnel/dashbord",
  name : "ChefDashbord",
  component : DashbordChef,
  beforeEnter: [isAuth, isChef]
},
{

  path : "/RH/Absences",
  name : "Absences",
  component : Absences,
  beforeEnter: [isAuth, isRH]
},
{

  path : "/Staff/dashbord",
  name : "DashbordStaff",
  component : DashbordStaff,
  beforeEnter: [isAuth, isStaff]
}
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
