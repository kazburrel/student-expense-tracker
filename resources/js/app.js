import "./bootstrap";

import { createApp } from "vue";
import IndexExpenses from "./components/IndexExpenses.vue";
import RecieptIndex from "./components/Reciept/Index.vue";
import RecieptDetails from "./components/Reciept/Details.vue";

createApp({})
    .component("IndexExpenses", IndexExpenses)
    .component("RecieptIndex", RecieptIndex)
    .component("RecieptDetails", RecieptDetails)
    .mount("#app");
