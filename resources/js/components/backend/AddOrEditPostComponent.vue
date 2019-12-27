<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">{{ headerText }}</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-body">
                <form @submit.prevent="submit" @keydown="form.onKeydown($event)" method="post">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input v-model="form.title" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('title') }" id="post_title" aria-describedby="Title" placeholder="Enter title">
                        <has-error :form="form" field="title"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="post_subtitle">Subtitle</label>
                        <input v-model="form.subtitle" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('subtitle') }" id="post_subtitle" placeholder="Enter the subtitle">
                        <has-error :form="form" field="subtitle"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="post_category">Category</label>
                        <v-select v-model="form.category" :class="{ 'is-invalid': form.errors.has('category') }" id="post_category" :options="categories" label="name"></v-select>
                        <has-error :form="form" field="category"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="post_tags">Tags</label>
                        <v-select multiple v-model="form.tags" :class="{ 'is-invalid': form.errors.has('tags') }" id="post_tags" :options="tags" label="name"></v-select>
                        <has-error :form="form" field="tags"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <editor v-model="form.description" :api-key="editor_api_key" :class="{ 'is-invalid': form.errors.has('description') }" id="description" :init="editor_config"></editor>
                        <has-error :form="form" field="description"></has-error>
                    </div>
                    <div class="form-check">
                        <input v-model="form.publish" type="checkbox" class="form-check-input" :class="{ 'is-invalid': form.errors.has('publish') }" id="publish">
                        <label class="form-check-label" for="publish">Publish now?</label>
                        <has-error :form="form" field="publish"></has-error>
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

            this.getCategoriesAndTags();

            this.param = this.$route.params.postId;

            if (this.param != undefined) {
                this.headerText = 'Edit Post';
                this.decorateForm(this.param);
            } else {
                this.headerText = 'Add Post';
            }
        },
        data () {
            return {
                editor_api_key: process.env.MIX_EDITOR_API_KEY,
                headerText: 'Add Post',
                param: undefined,
                categories: [],
                tags: [],
                form: new Form({
                    id: -1,
                    title: '',
                    subtitle: '',
                    category: '',
                    tags: [],
                    description: '',
                    publish: false
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
            getCategoriesAndTags () {
                axios.get('/api/categories/all').then((response) => {
                    this.categories = response.data.data;
                });

                axios.get('/api/tags/all').then((response) => {
                    this.tags = response.data.data;
                });
            },

            submit() {
                this.form.category = this.form.category.id;

                this.form.tags.forEach(function(part, index) {
                    this[index] = this[index].id;
                }, this.form.tags);

                if (this.param === undefined) {
                    this.form.post('/api/posts/create/new').then(() => {
                        swal.fire(
                            'Added!',
                            'This post has been added successfully!',
                            'success'
                        ).then (() => {
                            this.form.reset();
                            this.$router.push({ path: '/admin/posts' });
                        });
                    });
                } else {
                    this.form.put('/api/posts/edit/' + this.form.id).then(() => {
                        swal.fire(
                            'Updated!',
                            'This post has been updated successfully!',
                            'success'
                        ).then (() => {
                            this.form.reset();
                            this.$router.push({ path: '/admin/posts' });
                        });
                    });
                }
            },

            decorateForm(postId) {
                axios.get('/api/posts/' + postId).then((response) => {
                    this.form.id = response.data.id;
                    this.form.title = response.data.title;
                    this.form.subtitle = response.data.subtitle;
                    this.form.category = this.categories.find(x => x.id == response.data.category_id);
                    this.form.description = response.data.description;
                    this.form.publish = response.data.is_published;
                });

                axios.get('/api/posts/' + postId + '/tags').then((response) => {
                    response.data.forEach(tag => {
                        this.form.tags.push(tag);
                    });
                });
            }
        }
    }
</script>
