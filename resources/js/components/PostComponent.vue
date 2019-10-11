<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Posts</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-header py-3">
                <button class="btn btn-primary float-right">Create New Post</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="width:200px; min-width:200px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <editor :api-key="editor_api_key" :init="{plugins: ['autoresize', 'code', 'codesample', 'emoticons', 'fullscreen', 'help', 'hr', 'image', 'imagetools', 'insertdatetime', 'link', 'lists', 'media', 'paste', 'preview', 'print', 'searchreplace', 'table'], toolbar: 'styleselect | bold italic underline | strikethrough subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media codesample table emoticons | print preview | forecolor backcolor code' }"></editor>
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
                editor_api_key: process.env.MIX_EDITOR_API_KEY
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
                        { data: 'created_at', name: 'created_at' },
                        { data: 'updated_at', name: 'updated_at' },
                        { data: 'action', name: 'action', orderable: false }
                    ]
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
                                'This post has been deleted successfully!',
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
