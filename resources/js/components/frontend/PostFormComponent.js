class PostFormComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            editor_api_key: process.env.MIX_EDITOR_API_KEY,
            editor_config: {
                path_absolute: "http://localhost:8000/",
                plugins: [
                    'autoresize', 'code', 'codesample', 'emoticons', 'hr', 'image', 'imagetools', 'insertdatetime', 'link', 'lists', 'media', 'preview', 'print', 'table'
                ],
                toolbar: 'undo redo print | styleselect | fontselect | fontsizeselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | link image media | bullist numlist outdent indent',
                relative_urls: false,
                file_picker_callback: (callback, value, meta) => {
                    let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                    
                    let type = 'image' === meta.filetype ? 'Images' : 'Files',
                    url  = this.state.editor_config.path_absolute + 'laravel-filemanager?editor=tinymce5&type=' + type;

                    tinymce.activeEditor.windowManager.openUrl({
                        url : url,
                        title : 'Filemanager',
                        width : x * 0.8,
                        height : y * 0.8,
                        onMessage: (api, message) => {
                            callback(message.content);
                        }
                    });
                },
            },
            postId: props.postId,
            post: {},
            postTags: [],
            categories: [],
            tags: [],
        }
    }

    async componentDidMount() {
        this.getCategories();

        this.getTags();

        if (this.state.postId != -1) {
            this.getPost();
        }
    }

    getCategories = () => {
        axios.get('/api/categories/all').then((response) => {
            let newCategories = [];
            response.data.data.forEach(category => {
                let newCategory = {
                    value: category.id,
                    label: category.name
                };
                newCategories.push(newCategory);
            });
            this.setState({
                categories: newCategories
            });
        });
    }

    getTags = () => {
        axios.get('/api/tags/all').then((response) => {
            let newTags = [];
            response.data.data.forEach(tag => {
                let newTag = {
                    value: tag.id,
                    label: tag.name
                };
                newTags.push(newTag);
            });
            this.setState({
                tags: newTags
            });
        });
    }

    getPost = () => {
        axios.get('/api/posts/' + this.state.postId).then((response) => {
            this.setState({
                post: response.data
            });
        });
    }

    handleCategory = (newValue) => {
        let newPost = this.state.post;
        newPost.category_id = newValue.value;
        this.setState({
            post: newPost
        });
    }

    handleTags = (newValue) => {
        let newPostTags = newValue;
        this.setState({
            postTags: newPostTags
        });
    }

    handleEditor = (e) => {
        let newPost = this.state.post;
        newPost.description = e.target.getContent();
        this.setState({
            post: newPost
        });
    }

    handleOtherInputChange = (e) => {
        let newPost = this.state.post;
        if (e.target.name == 'title') newPost.title = e.target.value;
        else if (e.target.name == 'subtitle') newPost.subtitle = e.target.value;
        else if (e.target.name == 'publish') newPost.is_published = e.target.checked;
        this.setState({
            post: newPost
        });
    }

    handleFormSubmit = (e) => {
        e.preventDefault();
        let tags = [];
        this.state.postTags.forEach(tag => {
            tags.push(tag.value);
        });

        if (this.state.postId == -1) {
            axios.post('/api/posts/create/new', {
                title: this.state.post.title,
                subtitle: this.state.post.subtitle,
                category: this.state.post.category_id,
                tags: tags,
                description: this.state.post.description,
                publish: this.state.post.is_published
            }).then(() => {
                swal.fire(
                    'Added!',
                    'This post has been added successfully!',
                    'success'
                ).then (() => {
                    window.location.href = "/";
                });
            }).catch(() => {
                swal.fire({
                    title: 'Update failed',
                    icon: 'error'
                });
            });
        }
        else {
            axios.put('/api/posts/edit/' + this.state.postId, {
                title: this.state.post.title,
                subtitle: this.state.post.subtitle,
                category: this.state.post.category_id,
                tags: tags,
                description: this.state.post.description,
                publish: this.state.post.is_published
            }).then(() => {
                swal.fire(
                    'Updated!',
                    'This post has been updated successfully!',
                    'success'
                ).then (() => {
                    window.location.href = "/";
                });
            }).catch(() => {
                swal.fire({
                    title: 'Update failed',
                    icon: 'error'
                });
            });
        }
    }
    
    render() {
        return (
            <React.Fragment>
                <LazyLoad>
                    <form method={(this.state.postId == -1) ? "post" : "put"} onSubmit={this.handleFormSubmit}>
                        <div className="form-group">
                            <label htmlFor="post_title">Title</label>
                            <input type="text" className="form-control" id="post_title" aria-describedby="Title" placeholder="Enter title" name="title" onChange={this.handleOtherInputChange} value={(this.state.post.title) ? this.state.post.title : ""} required />
                        </div>
                        <div className="form-group">
                            <label htmlFor="post_subtitle">Subtitle</label>
                            <input type="text" className="form-control" id="post_subtitle" placeholder="Enter the subtitle" name="subtitle" onChange={this.handleOtherInputChange} value={(this.state.post.subtitle) ? this.state.post.subtitle : ""} required />
                        </div>
                        <div className="form-group">
                            <label htmlFor="post_category">Category</label>
                            <Select
                                isClearable
                                onChange={this.handleCategory}
                                options={this.state.categories}
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="post_tags">Tags</label>
                            <Select
                                isClearable
                                isMulti
                                onChange={this.handleTags}
                                options={this.state.tags}
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="description">Description</label>
                            <Editor
                                apiKey={this.state.editor_api_key}
                                initialValue={(this.state.post.description) ? this.state.post.description : ""}
                                init={this.state.editor_config}
                                onChange={this.handleEditor}
                            />
                        </div>
                        <div className="form-check">
                            <input type="checkbox" className="form-check-input" id="publish" name="publish" onChange={this.handleOtherInputChange} checked={this.state.post.is_published} />
                            <label className="form-check-label" htmlFor="publish">Publish now?</label>
                        </div>
                        <div className="form-group mt-2">
                            <button type="submit" className="btn btn-danger" style={{borderRadius: '0 !important'}}>Save</button>
                        </div>
                    </form>
                </LazyLoad>
            </React.Fragment>
        );
    }
}

export default PostFormComponent;

var rootElement = document.getElementById('showPostForm');

if (rootElement) {
    ReactDOM.render(<PostFormComponent postId={rootElement.getAttribute('data-post-id')} />, rootElement);
}
