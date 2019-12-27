<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Categories</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-header py-3">
                <button class="btn btn-primary float-right" @click="newForm">Add New Category</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="width:200px; min-width:200px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create / Edit Category Modal -->
        <div class="modal fade" id="category-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="category-form-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="submitForm" @keydown="form.onKeydown($event)">
                        <div class="modal-header">
                            <h5 class="modal-title" id="category-form-title">{{ formTitle }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category-name">Category Name</label>
                                <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" id="category-name" name="category_name" aria-describedby="category" placeholder="Enter category name" required>
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    export default {
        mounted () {
            this.initializeCategories();

            $('#dataTable').on('click', '#edit-category', function (event) {
                let categoryId = $(event.target).data('id');
                let category;
                axios.get('/api/categories/' + categoryId).then((response) => {
                    category = {
                        id: response.data.id,
                        name: response.data.name
                    };
                    this.editForm(category);
                });
            }.bind(this));

            $('#dataTable').on('click', '#delete-category', function (event) {
                let categoryId = $(event.target).data('id');
                this.deleteCategory(categoryId);
            }.bind(this));
        },
        data () {
            return {
                form: new Form({
                    id: -1,
                    name: ''
                }),
                formTitle: 'Add Category'
            }
        },
        methods: {
            initializeCategories: function () {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: '/api/categories/all',
                        type: 'get',
                        beforeSend: function (request) {
                            request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        }
                    },
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'slug', name: 'slug' },
                        { data: 'created_by', name: 'created_by' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'updated_at', name: 'updated_at' },
                        { data: 'action', name: 'action', orderable: false }
                    ]
                });
            },
            newForm: function () {
                this.form.reset();
                this.formTitle = 'Add Category';
                $('#category-form').modal('show');
            },
            editForm: function (category) {
                this.form.reset();
                this.formTitle = 'Edit Category';
                $('#category-form').modal('show');
                this.form.fill(category);
            },
            submitForm: function () {
                if (this.form.id === -1) this.addCategory();
                else this.editCategory();
            },
            addCategory: function () {
                this.form.post('/api/categories/create/new').then(() => {
                    swal.fire(
                        'Added!',
                        'Category has been added successfully!',
                        'success'
                    );
                    $('#category-form').modal('hide');
                    this.initializeCategories();
                });
            },
            editCategory: function () {
                this.form.put('/api/categories/edit/' + this.form.id).then(() => {
                    swal.fire(
                        'Updated!',
                        'Category has been updated successfully!',
                        'success'
                    );
                    $('#category-form').modal('hide');
                    this.initializeCategories();
                });
            },
            deleteCategory: function (categoryId) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('/api/categories/delete/' + categoryId).then(() => {
                            swal.fire(
                                'Deleted!',
                                'Category has been deleted successfully!',
                                'success'
                            );
                            this.initializeCategories();
                        });
                    }
                });
            }
        }
    }
</script>
