<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Comments</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Post ID</th>
                                <th>Parent ID</th>
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
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    export default {
        mounted () {
            this.initializeComments();

            $('#dataTable').on('click', '#view-comment', function (event) {
                let commentId = $(event.target).data('id');
                this.$router.push('/admin/comments/view/' + commentId);
            }.bind(this));

            $('#dataTable').on('click', '#edit-comment', function (event) {
                let commentId = $(event.target).data('id');
                this.$router.push('/admin/comments/edit/' + commentId);
            }.bind(this));

            $('#dataTable').on('click', '#delete-comment', function (event) {
                let commentId = $(event.target).data('id');
                this.deleteComment(commentId);
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
            initializeComments: function () {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: '/api/comments/all',
                        type: 'get',
                        beforeSend: function (request) {
                            request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        }
                    },
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'post_id', name: 'post_id' },
                        { data: 'parent_id', name: 'parent_id' },
                        { data: 'created_by', name: 'created_by' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'updated_at', name: 'updated_at' },
                        { data: 'action', name: 'action', orderable: false }
                    ]
                });
            },
            deleteComment: function (commentId) {
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
                        this.form.delete('/api/comments/' + commentId + '/delete').then(() => {
                            swal.fire(
                                'Deleted!',
                                'This comment has been deleted successfully!',
                                'success'
                            );
                            this.initializeComments();
                        });
                    }
                });
            }
        }
    }
</script>
