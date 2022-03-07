import Vue from "vue";
import "./plugins/axios";
import App from "./App.vue";
import vuetify from "./plugins/vuetify";
import moment from "moment";

Vue.filter("formatDate", function (value) {
  if (value) {
    return moment(String(value)).format("DD/MM/YYYY");
  }
});
Vue.config.productionTip = false;

new Vue({
  vuetify,
  render: (h) => h(App),
}).$mount("#app");
