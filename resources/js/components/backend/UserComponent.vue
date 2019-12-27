<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Users</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Verified</th>
                                <th>Admin</th>
                                <th>Banned</th>
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
            this.initializeUsers();

            $('#dataTable').on('click', '#view-user', function (event) {
                let userId = $(event.target).data('id');
                this.$router.push('/admin/users/view/' + userId);
            }.bind(this));

            $('#dataTable').on('click', '#block-user', function (event) {
                let userId = $(event.target).data('id');
                this.blockUser(userId);
            }.bind(this));

            $('#dataTable').on('click', '#unblock-user', function (event) {
                let userId = $(event.target).data('id');
                this.unblockUser(userId);
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
            initializeUsers: function () {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: '/api/users/all',
                        type: 'get',
                        beforeSend: function (request) {
                            request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        }
                    },
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'username', name: 'username' },
                        { data: 'email', name: 'email' },
                        { data: 'verified', name: 'verified' },
                        { data: 'admin', name: 'admin' },
                        { data: 'banned', name: 'banned' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'updated_at', name: 'updated_at' },
                        { data: 'action', name: 'action', orderable: false }
                    ]
                });
            },
            blockUser: function (userId) {
                swal.fire({
                    title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, block him!'
                }).then((result) => {
                    if (result.value) {
                        this.form.put('/api/users/block/' + userId).then(() => {
                            swal.fire(
                                'Blocked!',
                                'This person has been blocked!',
                                'success'
                            );
                            this.initializeUsers();
                        });
                    }
                });
            },
            unblockUser: function (userId) {
                swal.fire({
                    title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, unblock him!'
                }).then((result) => {
                    if (result.value) {
                        this.form.put('/api/users/unblock/' + userId).then(() => {
                            swal.fire(
                                'Unblocked!',
                                'This person has been unblocked!',
                                'success'
                            );
                            this.initializeUsers();
                        });
                    }
                });
            }
        }
    }
</script>
