// dataTablesPlugin.js

import 'datatables.net-vue3';
import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-bs4/css/dataTables.bootstrap4.css';
import $ from 'jquery';



export default {
  install(app) {
    app.config.globalProperties.$DataTable = $;
  },
};
