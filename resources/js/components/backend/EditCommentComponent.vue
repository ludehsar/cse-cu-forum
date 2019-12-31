<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Edit Comment</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-body">
                <form @submit.prevent="submit" @keydown="form.onKeydown($event)" method="post">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <editor v-model="form.description" :api-key="editor_api_key" :class="{ 'is-invalid': form.errors.has('description') }" id="description" :init="editor_config"></editor>
                        <has-error :form="form" field="description"></has-error>
                    </div>
                    <div class="form-group mt-2">
                        <button :disabled="form.busy" type="submit" class="btn btn-primary" style="border-radius: 0 !important;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    export default {
        mounted () {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            this.param = this.$route.params.commentId;

            if (this.param != undefined) {
                this.decorateForm(this.param);
            }
        },
        data () {
            return {
                editor_api_key: process.env.MIX_EDITOR_API_KEY,
                param: undefined,
                form: new Form({
                    id: -1,
                    description: '',
                }),
                editor_config: {
                    path_absolute: "http://localhost:8000/",
                    plugins: [
                        'autoresize', 'code', 'codesample', 'emoticons', 'hr', 'image', 'imagetools', 'insertdatetime', 'link', 'lists', 'media', 'preview', 'print', 'table'
                    ],
                    toolbar: 'undo redo print | styleselect | fontselect | fontsizeselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | link image media | bullist numlist outdent indent',
                    relative_urls: false,
                    file_picker_callback: function (callback, value, meta) {
                        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                        let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                        let type = 'image' === meta.filetype ? 'Images' : 'Files',
                            url  = this.editor_config.path_absolute + 'laravel-filemanager?editor=tinymce5&type=' + type;

                        tinymce.activeEditor.windowManager.openUrl({
                            url : url,
                            title : 'Filemanager',
                            width : x * 0.8,
                            height : y * 0.8,
                            onMessage: (api, message) => {
                                callback(message.content);
                            }
                        });
                    }.bind(this)
                }
            }
        },
        methods: {
            submit() {
                this.form.put('/api/comments/' + this.form.id + '/edit').then(() => {
                    swal.fire(
                        'Updated!',
                        'This comment has been updated successfully!',
                        'success'
                    ).then (() => {
                        this.form.reset();
                        this.$router.push({ path: '/admin/comments' });
                    });
                });
            },

            decorateForm(postId) {
                axios.get('/api/comments/' + postId).then((response) => {
                    this.form.id = response.data.id;
                    this.form.description = response.data.description;
                });
            }
        }
    }
</script>
