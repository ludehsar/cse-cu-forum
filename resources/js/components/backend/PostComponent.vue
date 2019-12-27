<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Posts</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-header py-3">
                <router-link to="/admin/posts/create" class="btn btn-primary float-right">Create New Post</router-link>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="width:200px; min-width:200px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    export default {
        mounted () {
            this.initializePosts();

            $('#dataTable').on('click', '#view-post', function (event) {
                let postId = $(event.target).data('id');
                this.$router.push('/admin/posts/view/' + postId);
            }.bind(this));

            $('#dataTable').on('click', '#edit-post', function (event) {
                let postId = $(event.target).data('id');
                this.$router.push('/admin/posts/edit/' + postId);
            }.bind(this));

            $('#dataTable').on('click', '#delete-post', function (event) {
                let postId = $(event.target).data('id');
                this.deletePost(postId);
            }.bind(this));
        },
        data () {
            return {
                form: new Form({
                    id: -1,
                })
            }
        },
        methods: {
            initializePosts: function () {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: '/api/posts/all',
                        type: 'get',
                        beforeSend: function (request) {
                            request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        }
                    },
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'title', name: 'title' },
                        { data: 'category', name: 'category' },
                        { data: 'created_by', name: 'created_by' },
                        { data: 'status', name: 'status' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'updated_at', name: 'updated_at' },
                        { data: 'action', name: 'action', orderable: false }
                    ]
                });
            },
            deletePost: function (postId) {
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
                        this.form.delete('/api/posts/delete/' + postId).then(() => {
                            swal.fire(
                                'Deleted!',
                                'This post has been deleted successfully!',
                                'success'
                            );
                            this.initializePosts();
                        });
                    }
                });
            }
        }
    }
</script>
