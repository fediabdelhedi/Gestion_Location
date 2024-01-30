import Accueil from './component/accueil.vue';
import viewVoiture from "./component/voiture/viewVoiture.vue";
import viewLocation from "./component/location/viewLocation.vue";
import ListeLocation from "./component/location/ListeLocation.vue";
import Login from './component/auth/login.vue'
import Register from './component/auth/register.vue'
export const routes = [
    {
        name: 'accueil',
        path: '/',
        component: Accueil
    },
    {
        name: "viewVoiture",
        path: "/voitures",
        component: viewVoiture
    },
    {
        name: "viewLocation",
        path: "/locations",
        component: viewLocation
    }, 
    {
        name:"listeLocation",
        path:"/listlocations",
        component: ListeLocation
        },
    {
        name: "login",
        path: "/login",
        component: Login,
    },
    {
        name: "register",
        path: "/register",
        component: Register,
    },
];