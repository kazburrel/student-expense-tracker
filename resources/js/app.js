import "./bootstrap";

import { createApp } from "vue";
import IndexExpenses from "./components/IndexExpenses.vue";

createApp({}).component("IndexExpenses", IndexExpenses).mount("#app");
