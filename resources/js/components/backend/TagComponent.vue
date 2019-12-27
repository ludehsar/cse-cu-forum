<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Tags</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-header py-3">
                <button class="btn btn-primary float-right" @click="newForm">Add New Tag</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tag Name</th>
                                <th>Tag Slug</th>
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

        <!-- Create / Edit Tag Modal -->
        <div class="modal fade" id="tag-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="tag-form-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="submitForm" @keydown="form.onKeydown($event)">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tag-form-title">{{ formTitle }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tag-name">Tag Name</label>
                                <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" id="tag-name" name="tag_name" aria-describedby="tag" placeholder="Enter tag name" required>
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
            this.initializeTags();

            $('#dataTable').on('click', '#edit-tag', function (event) {
                let tagId = $(event.target).data('id');
                let tag;
                axios.get('/api/tags/' + tagId).then((response) => {
                    tag = {
                        id: response.data.id,
                        name: response.data.name
                    };
                    this.editForm(tag);
                });
            }.bind(this));

            $('#dataTable').on('click', '#delete-tag', function (event) {
                let tagId = $(event.target).data('id');
                this.deleteTag(tagId);
            }.bind(this));
        },
        data () {
            return {
                form: new Form({
                    id: -1,
                    name: ''
                }),
                formTitle: 'Add Tag'
            }
        },
        methods: {
            initializeTags: function () {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: '/api/tags/all',
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
                this.formTitle = 'Add Tag';
                $('#tag-form').modal('show');
            },
            editForm: function (tag) {
                this.form.reset();
                this.formTitle = 'Edit Tag';
                $('#tag-form').modal('show');
                this.form.fill(tag);
            },
            submitForm: function () {
                if (this.form.id === -1) this.addTag();
                else this.editTag();
            },
            addTag: function () {
                this.form.post('/api/tags/create/new').then(() => {
                    swal.fire(
                        'Added!',
                        'Tag has been added successfully!',
                        'success'
                    );
                    $('#tag-form').modal('hide');
                    this.initializeTags();
                });
            },
            editTag: function () {
                this.form.put('/api/tags/edit/' + this.form.id).then(() => {
                    swal.fire(
                        'Updated!',
                        'Tag has been updated successfully!',
                        'success'
                    );
                    $('#tag-form').modal('hide');
                    this.initializeTags();
                });
            },
            deleteTag: function (tagId) {
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
                        this.form.delete('/api/tags/delete/' + tagId).then(() => {
                            swal.fire(
                                'Deleted!',
                                'Tag has been deleted successfully!',
                                'success'
                            );
                            this.initializeTags();
                        });
                    }
                });
            }
        }
    }
</script>
