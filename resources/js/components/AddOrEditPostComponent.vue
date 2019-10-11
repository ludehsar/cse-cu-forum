<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="clearfix">
            <h1 class="h3 mb-2 text-gray-800 float-left">Posts</h1>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" class="form-control" id="post_title" aria-describedby="Title" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="post_subtitle">Subtitle</label>
                        <input type="text" class="form-control" id="post_subtitle" placeholder="Enter sub title">
                    </div>
                    <div class="form-group">
                        <label for="post_category">Category</label>
                        <input type="text" class="form-control" id="post_category" placeholder="Select Category" list="categories" />
                        <datalist id="categories">
                            <option v-for="category in categories" :key="category.id">{{ category.name }}</option>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="post_tags">Tags</label>
                        <input type="text" class="form-control" id="post_tags" placeholder="Enter suitable tags">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <editor :api-key="editor_api_key" id="description" :init="{plugins: ['autoresize', 'code', 'codesample', 'emoticons', 'hr', 'image', 'imagetools', 'insertdatetime', 'link', 'lists', 'media', 'preview', 'print', 'table'], toolbar: 'undo redo print | styleselect | fontselect | fontsizeselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | link image media | bullist numlist outdent indent'}"></editor>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="publish">
                        <label class="form-check-label" for="publish">Publish now?</label>
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary" style="border-radius: 0 !important;">Save</button>
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

            this.getCategories();

            var tagInput = new TagsInput({
                selector: 'post_tags',
                duplicate: true
            });
        },
        data () {
            return {
                editor_api_key: process.env.MIX_EDITOR_API_KEY,
                categories: [],
                form: new Form({

                })
            }
        },
        methods: {
            getCategories () {
                axios.get('/api/categories/all').then((response) => {
                    this.categories = response.data.data;
                    console.log(this.categories);
                });
            }
        }
    }
</script>

<style>
    .tags-input-wrapper {
        background: #f9f9f9;
        padding: 10px;
        border-radius: 4px;
        max-width: 400px;
        border: 1px solid #ccc;
    }

    .tags-input-wrapper input {
        border: none;
        background: transparent;
        outline: none;
        width: 150px;
    }

    .tags-input-wrapper .tag {
        display: inline-block;
        background-color: #009432;
        color: white;
        border-radius: 40px;
        padding: 0px 3px 0px 7px;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .tags-input-wrapper .tag a {
        margin: 0 7px 3px;
        display: inline-block;
        cursor: pointer;
    }
</style>
