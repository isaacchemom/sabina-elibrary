<template>
<!-- delete modal -->
<div v-if="showAlert">
    <div v-if="message">
        <h5 class="alert alert-danger  containerx "> {{ message}} </h5>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETE?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="text-danger">Are you sure you want to delete this items?</h6>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" @click="removeItem">Delete</button>
            </div>
        </div>
    </div>
</div>
<!--
    <div style="background-color:white;" class="mt-4 ml-4 mr-4">

        <hr />

        <div class="modal fade" id="taskmodal" tabindex="-1" role="dialogx" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centred modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="taskModalLabel">{{ !editMode ? 'Add Category.' : 'Update Category' }}</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div v-if="showAlert">
                        <div v-if="importErrors">
                            <p class="alert alert-danger col-md-8"> {{ importErrors }} </p>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 m-auto" ref="form" @submit.prevent="!editMode ? saveCategory() : editCategory()">
                            <div class="col-md-6">
                                <label class="form-label">NAME</label>
                                <input type="text" class="form-control" v-model="category.name" required pattern="[A-Za-z\s]+" placeholder="e.g consumables, learning materials">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" v-model="category.description" placeholder="Optional">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ !editMode ? 'Save' : 'Update' }}</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
-->
<!--

<hr>
<div class="ml-4">

    <h5 class="text-center">TRANSACTIONS</h5> -->



<!-- <table class="table table-stripped table-hover ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">TRANSACTION ID</th>
                    <th scope="col">USER&nbsp;PHONE</th>

                    <th scope="col">EMAIL</th>
                    <th scope="col">ITEM DESCRIPTION</th>
                    <th scope="col">PRICE</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">DATE</th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="(trans, index) in transaction" v-bind:key="index">
                    <td> {{ index+1 }} </td>
                    <td> {{ trans.transaction_id }} </td>
                    <td>{{ trans.phone }}</td>
                    <td>{{ trans.email }}</td>
                    <td>{{ trans.items.desc}}</td>
                    <td>{{ trans.items.price}}</td>

                    <td v-if="trans.status==0"  class="text-warning"> Pending</td>
                     <td v-else-if="trans.status==1" class="text-success">Completed</td>
                     <td v-else class="text-danger">INCOMPLETE</td>
                     <td >{{trans.created_at}}</td>

                    <td> <input type="text" v-model="myform.name[task.id]"></td> -->
<!--<td>

                           <input @onblur="update(task,$event.target.value)" >-
                          <a href="#" @click.prevent="updates(task)"><i class="fa fa-edit"></i></a>
                        </td>
                   <td v-if="trans.status==3">  <a href="#" @click.prevent="updateCategory(category)"><i class="fa fa-edit"></i></a>
                        <a href="#" @click.prevent="deleteTransaction(trans)"><i class="fa fa-trash text-danger ml-4">Delete</i></a>
                    </td>
                </tr>
            </tbody>
        </table> -->
<!--</div>-->

<div class="col-lg-12 offset-lg-2x " style="margin-top:-64px;">

    <div class="table caption-top table-responsive table-responsive-sm table-responsive-md table-responsive-xl  ">

        <DataTable style="text-transform:uppercase  " ref="myDataTable" class="cell-border  table-sm  display table table-striped table-hover  table-bordered " :columns="columns" :data="transaction" :options="{dom:'Bfrtip',responsive:'true',select: true,
autoWidth:false,language:{zeroRecords:'No items in the table!'}, buttons:botones}">

            <thead style="">

                <tr class="table-success">
                    <th></th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Transaction Id</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Created On</th>

                    <th>Action</th>

                </tr>
            </thead>

        </DataTable>
    </div>
</div>
</template>

<script>
import DataTable from 'datatables.net-vue3'
import DataTablesCore from 'datatables.net';
import DataTableLip from 'datatables.net-bs5'
import Buttons from 'datatables.net-buttons-bs5'
import ButtonsHtml from 'datatables.net-buttons/js/buttons.html5'
//import 'datatables.net-buttons/js/buttons.html5.mjs';
import print from 'datatables.net-buttons/js/buttons.print'
import pdfmake from 'pdfmake'

//import pdfFonts from "pdfmake/build/vfs_fonts";

import 'datatables.net-responsive-bs5'

import jsZip from 'jszip'
window.JSZip = jsZip
window.pdfMake = pdfmake;
DataTable.use(DataTablesCore);
DataTable.use(DataTableLip)
DataTable.use(print)
DataTable.use(Buttons)
DataTable.use(ButtonsHtml)
// import { format, parseISO } from 'date-fns'; // Import necessary functions
//import axios from 'axios';
//import mynav from '../nav.vue'
export default {
    components: {

        DataTable,

    },
    data() {
        return {
            transactions: {
                name: '',
                description: ''
            },
            showAlert: false,

            editMode: false,
            categories: [],
            transaction: [],
            // message:false



            columns: [{
                    data: null,
                    render: function (data, type, row, meta) {
                        return `${meta.row + 1}`;
                    },
                },
                {
                    // title: 'Staff name',
                    data: 'phone'
                },
                {
                    // title: 'items',
                    data: 'email'
                },
                {
                    // title: 'Quantity',
                    data: 'transaction_id'
                },
                {
                    // title: 'Quantity',
                    data: 'items.desc'
                },

                {
                    // title: 'Item NO',
                    data: 'items.price'
                },

                {
                    // title: 'Item NO',
                    data: 'status'
                },



                {
                    // title: 'Date',
                    data: 'created_at',
                    render: function (data) {
                        const dateObject = new Date(data);
                        const day = dateObject.getDate().toString().padStart(2, '0');
                        const month = (dateObject.getMonth() + 1).toString().padStart(2, '0'); // Note: Month is zero-based
                        const year = dateObject.getFullYear();
                        const hours = dateObject.getHours().toString().padStart(2, '0');
                        const minutes = dateObject.getMinutes().toString().padStart(2, '0');
                        //  const seconds = dateObject.getSeconds().toString().padStart(2, '0');
                        //const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
                        const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}`;
                        return formattedDate;
                    },
                },

                {
                    data: null,
                    render: (data, type, row) => {
                        if (row.status === 1) {
                            return '';
                        } else {
                            return `
                                <td>
                                    <button class="btn btn-default delete-btn fa fa-trash text-danger" data-row='${JSON.stringify(row).replace(/'/g, "\\'")}'></button>
                                </td>
                            `;
                        }
                    },},

            ],
            botones: [{
                    title: 'CHS Central Store Stock',
                    extend: 'excelHtml5',
                    text: '<i class=" fa fa-solid fa-file-excel fs-1"></i>Excel',
                    className: 'btn btn-success',

                },

                {
                    title: 'CHS Central Store items report',
                    extend: 'print',
                    text: '<i class="fa fa-solid fa-print"></i>Print',
                    className: 'btn btn-success',

                },
            ],


        }

    },

    mounted() {

        const dataTable = this.$refs.myDataTable.$el;
        dataTable.addEventListener('click', this.handleDataTableClick);
    },
    beforeDestroy() {
        const dataTable = this.$refs.myDataTable.$el;
        dataTable.removeEventListener('click', this.handleDataTableClick);
    },

    created() {
        this.getCategories()

    },
    methods: {

        handleDataTableClick(event) {
            const target = event.target;

            if (target.classList.contains('update-btn')) {
                const rowData = JSON.parse(target.dataset.row.replace(/\\'/g, "'"));
                this.updateItem(rowData);
            } else if (target.classList.contains('delete-btn')) {
                const rowData = JSON.parse(target.dataset.row.replace(/\\'/g, "'"));
                this.deleteRow(rowData);
            }
        },

        // formatFn(value) {
        //  return value === 1 ? 'Completed' : value === 3 ? 'Incomplete' : 'Pending';
        //},

        deleteRow(rowData) {
            // Handle delete logic here, e.g., show a confirmation dialog
            //console.log('Delete row:', row);
            // this.Transactions.id =row.id;
            // alert('alert man' );
            const id = rowData.id;
            this.transactions.id = id;

            $("#deleteModal").modal("show");
            //console.log('id:', this.transactions.id);

        },

        deleteTransaction(trans) {
            //this.editMode = false

            this.transactions.idx = trans.id;
            $("#deleteModal").modal("show");
        },

        newcategory() {

            this.editMode = false
            this.category = {
                name: '',
                description: '',

            };

            $("#taskmodal").modal("show");
            //this.categories.push(this.category);
        },

        updateCategory(mycategory) {
            //console.log(supplier);
            this.category = ''
            this.editMode = true;
            $("#taskmodal").modal("show");
            this.category = mycategory;
        },

        removeItem() {
            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("https://sabin-elibrary.co.ke/api/deleteTransaction/" + this.transactions.id).then(response => {

                $("#deleteModal").modal("hide");
                //this.category.value=this.category.value.filter(category.id!==this.category.id)

                this.$toast.success(`Deleted successfully`, {
                    position: "top",
                    dismissible: false
                })
                this.transaction = this.transaction.filter((transactions) => transactions.id !== this.transactions.id);

                this.$emitter.emit('changeLoaderStatus', false)
            }).catch(error => {

                //alert("Error in uploading,check your file type and try gain!");

                if (error.response && error.response.status === 500) {

                    this.importErrors = error.response.data.error;
                    this.showAlert = true;

                    setTimeout(() => {
                        this.showAlert = false;
                    }, 5000);

                    //console.log('Errors:', this.errors);
                } else if (error.response.status === 422) {

                    this.message = error.response.data.message;
                    this.showAlert = true;
                    $("#deleteModal").modal("hide");
                    setTimeout(() => {
                        this.showAlert = false;
                    }, 7000);
                } else {
                    //console.error('Unknown errors:', error);
                    // alert('check file again')
                    this.$toast.error(`serverError! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            });

        },

        saveCategory() {

            this.$emitter.emit('changeLoaderStatus', true)

            axios.post("https://sabin-elibrary.co.ke/api/addCategory", this.category).then(response => {

                this.$toast.success(`Category added successfully`, {
                    position: "top",
                    dismissible: false
                })
                $("#taskmodal").modal("hide");

                // this.categories='';

                this.$emitter.emit('changeLoaderStatus', false);
                this.categories.push(this.category);

            }).catch(error => {

                if (error.response && error.response.status === 500) {
                    this.importErrors = error.response.data.error;
                    this.showAlert = true;

                    setTimeout(() => {
                        this.showAlert = false;
                    }, 5000);

                } else {

                    this.$toast.error(`serverError! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            });
        },

        getCategories() {
            this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://sabin-elibrary.co.ke/api/transactions").then(response => {
                this.transaction = response.data.data;

                this.$emitter.emit('changeLoaderStatus', false)
            })

        },

        editCategory() {

            this.$emitter.emit('changeLoaderStatus', true)
            axios.patch("https://sabin-elibrary.co.ke/api/updateCategory/" + this.category.id, this.category).then(() => {

                this.$toast.success(`Updated successfully`,

                    {
                        position: "top",
                        dismissible: false

                    }

                )

                this.$emitter.emit('changeLoaderStatus', false);
                $("#taskmodal").modal("hide");

            }).finally(() => {
                $("#taskModal").modal("hide")
            }).catch(error => {

                if (error.response && error.response.status === 500) {
                    this.importErrors = error.response.data.error;
                    this.showAlert = true;

                    setTimeout(() => {
                        this.showAlert = false;
                    }, 5000);
                    //console.log('Errors:', this.errors);
                } else {
                    //console.error('Unknown errors:', error);
                    // alert('check file again')
                    this.$toast.error(`Error! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            }).finally(() => {
                $("#taskModal").modal("hide");
            });
        },

    },

}
</script>

<style>
/* In your component's style section or global CSS file */
.bg-success {
  background-color: #28a745 !important;
  color: white;
}

.bg-danger {
  background-color: #dc3545 !important;
  color: white;
}

.bg-warning {
  background-color: #ffc107 !important;
  color: black;
}


</style>
