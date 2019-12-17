import Vue from 'vue';
import Meetings from './Meetings.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import VueResource from "vue-resource";

Vue.use(VueResource);
Vue.http.options.root = '/api';

new Vue({
  render: h => h(Meetings),
}).$mount('#app');
