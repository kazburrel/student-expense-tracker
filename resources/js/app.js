import "./bootstrap";

import { createApp, ref } from "vue";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import IndexExpenses from "./components/IndexExpenses.vue";
import RecieptIndex from "./components/Reciept/Index.vue";
import RecieptDetails from "./components/Reciept/Details.vue";
const app = createApp({});
app.component("IndexExpenses", IndexExpenses);
app.component("RecieptIndex", RecieptIndex);
app.component("RecieptDetails", RecieptDetails);
app.use(Toast);
app.mount("#app");
