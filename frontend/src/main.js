import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import axios from 'axios';
import router from "./router";
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import ArgonDashboard from "./argon-dashboard";

const appInstance = createApp(App);
appInstance.config.globalProperties.$axios = axios;
appInstance.config.globalProperties.$apiAdress = process.env.VUE_APP_BASE_API_URL;
appInstance.use(store);
appInstance.use(router);
appInstance.use(ArgonDashboard);
appInstance.mount("#app");
