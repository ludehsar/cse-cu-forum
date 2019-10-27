<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <div class="clearfix">
                    <h1 class="h3 mb-2 text-gray-800 float-left">
                        {{ id }}# {{ title }}
                    </h1>
                </div>
                <div class="clearfix">
                    <p>{{ subtitle }}</p>
                    <p>
                        Category: <span class="text-dark">{{ category }}</span>
                    </p>
                </div>
            </div>
            <div class="col-md-2">
                <router-link :to="edit_link" class="btn btn-block btn-primary"><i class="fa fa-edit"></i> Edit</router-link>
            </div>
        </div>
        <div class="card shadow mt-4 mb-4">
            <div class="card-body">
                <div id="user-info">
                    By <span class="text-dark">{{ username }}</span> at <span class="text-dark">{{ created_at }}</span>, last updated at <span class="text-dark">{{ updated_at }}</span>.
                    <div class="clearfix mt-1">
                        <span v-if="publish" class="badge badge-success">Published</span>
                        <span v-else class="badge badge-danger">Not Published</span>
                    </div>
                </div>
                <div id="description">
                    <div v-html="description"></div>
                </div>
                <div id="slug">
                    Slug: <span class="text-dark">{{ slug }}</span>
                    <ul class="list-inline">
                        <li v-for="tag in tags" :key="tag" class="list-inline-item">
                            <span class="badge badge-primary badge-lg"># {{ tag }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    export default {
        mounted () {
            this.param = this.$route.params.postId;

            if (this.param != undefined) {
                this.decoratePost(this.param);
            }
        },
        data () {
            return {
                param: undefined,
                id: '',
                title: '',
                subtitle: '',
                slug: '',
                description: '',
                publish: false,
                created_at: '',
                updated_at: '',
                total_contribution: 0,
                total_love: 0,
                total_wow: 0,
                total_haha: 0,
                total_angry: 0,
                category: '',
                username: '',
                tags: [],
                edit_link: ''
            }
        },
        methods: {
            decoratePost(postId) {
                axios.get('/api/posts/' + postId).then((response) => {
                    this.id = response.data.id;
                    this.title = response.data.title;
                    this.subtitle = response.data.subtitle;
                    this.slug = response.data.slug;
                    this.description = response.data.description;
                    this.publish = response.data.is_published;
                    this.created_at = response.data.created_at;
                    this.updated_at = response.data.updated_at;
                    this.total_contribution = response.data.total_contribution;
                    this.total_love = response.data.total_love;
                    this.total_wow = response.data.total_wow;
                    this.total_haha = response.data.total_haha;
                    this.total_angry = response.data.total_angry;

                    axios.get('/api/categories/' + response.data.category_id).then((response2) => {
                        this.category = response2.data.name;
                    });

                    axios.get('/api/users/' + response.data.user_id).then((response2) => {
                        this.username = response2.data.name;
                    });

                    this.edit_link = '/admin/posts/edit/' + this.id;
                });

                axios.get('/api/posts/' + postId + '/tags').then((response) => {
                    response.data.forEach(tag => {
                        this.tags.push(tag.name);
                    });
                });
            }
        }
    }
</script>

<style>
    #user-info {
        font-size: 12pt;
    }

    #description {
        margin: 22pt 0;
        color: #000;
    }
</style>
