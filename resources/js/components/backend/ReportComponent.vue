<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Reports</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Post ID</th>
                                <th>Comment ID</th>
                                <th>Created By</th>
                                <th>Description</th>
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
            this.initializeReports();

            $('#dataTable').on('click', '#delete-report', function (event) {
                let reportId = $(event.target).data('id');
                this.deleteReport(reportId);
            }.bind(this));
        },
        data () {
            return {
                form: new Form({
                    id: -1,
                }),
            }
        },
        methods: {
            initializeReports: function () {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: '/api/reports/all',
                        type: 'get',
                        beforeSend: function (request) {
                            request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        }
                    },
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'post_id', name: 'post_id' },
                        { data: 'comment_id', name: 'comment_id' },
                        { data: 'created_by', name: 'created_by' },
                        { data: 'description', name: 'description' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'updated_at', name: 'updated_at' },
                        { data: 'action', name: 'action', orderable: false }
                    ]
                });
            },
            deleteReport: function (reportId) {
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
                        this.form.delete('/api/reports/delete/' + reportId).then(() => {
                            swal.fire(
                                'Deleted!',
                                'This Report has been deleted successfully!',
                                'success'
                            );
                            this.initializeReports();
                        });
                    }
                });
            }
        }
    }
</script>
