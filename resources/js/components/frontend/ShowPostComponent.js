import CommentComponent from './CommentComponent';

class ShowPostComponent extends Component {
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
            post: {},
            category: {},
            tags: [],
            user: {},
            comments: [],
            postId: props.postId,
            replyDescription: '',
            reportDescription: '',
        }
    }

    async componentDidMount() {
        axios.get('/api/posts/' + this.state.postId).then((response) => {
            this.setState({post: response.data});
            axios.get('/api/categories/' + this.state.post.category_id).then((res2) => {
                this.setState({category: res2.data});
            });
            axios.get('/api/users/' + this.state.post.user_id).then((res2) => {
                this.setState({user: res2.data});
            });
        });
        axios.get('/api/posts/' + this.state.postId + '/tags').then((response) => {
            this.setState({tags: response.data});
        });
        
        this.fetchComments();
    }

    fetchComments = () => {
        axios.get('/api/posts/' + this.state.postId + '/comments').then((response) => {
            this.setState({comments: response.data});
        });
    }

    handleEditor = (e) => {
        let rev = e.target.getContent();
        this.setState({
            replyDescription: rev
        });
    }

    reply = () => {
        axios.post('/api/comments/add', {
            post_id: this.state.postId,
            description: this.state.replyDescription
        }).then(() => {
            this.fetchComments();
            this.setState({
                replyDescription: ''
            });
        });
    }

    handleReport = (e) => {
        let rev = e.target.value;

        this.setState({
            reportDescription: rev
        });
    }

    report = () => {
        swal.fire({
            title: 'Are you sure you want to report to this post?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Report!'
        }).then((result) => {
            if (result.value) {
                axios.post('/api/reports/add', {
                    post_id: this.state.postId,
                    description: this.state.reportDescription
                }).then(() => {
                    swal.fire(
                        'Thanks for reporting!',
                        'Your contribution will help this community to maintain a healthy society',
                        'success'
                    ).then(() => {
                        this.setState({
                            reportDescription: ''
                        });
                    });
                });
            }
        });
    }

    render() {
        return (
            <React.Fragment>
                <LazyLoad>
                    <div className="row">
                        <main className="post blog-post"> 
                            <div className="container">
                                <div className="post-single">
                                    <div className="post-details">
                                        <div className="post-meta d-flex justify-content-between">
                                            <div className="category"><a href="#">{this.state.category.name}</a></div>
                                        </div>
                                        <h1>{this.state.post.title}</h1>
                                        <div className="post-footer d-flex align-items-center flex-column flex-sm-row">
                                            <a href={"/profile/" + this.state.user.username} className="author d-flex align-items-center flex-wrap">
                                                <div className="avatar"><img src={this.state.user.profile_picture_url} alt="..." className="img-fluid" /></div>
                                                <div className="title"><span>{this.state.user.name}</span></div>
                                            </a>
                                            <div className="d-flex align-items-center flex-wrap">       
                                                <div className="date"><i className="icon-clock"></i> {moment.utc(this.state.post.created_at).fromNow()}</div>
                                                <div className="contributions"> <i className="fab fa-cuttlefish"></i> {this.state.post.total_contribution} contribuions</div>
                                                <div className="love"><i className="far fa-grin-hearts"></i> {this.state.post.total_love}</div>
                                                <div className="wow"><i className="far fa-grin-stars"></i> {this.state.post.total_wow}</div>
                                                <div className="haha"><i className="far fa-laugh-squint"></i> {this.state.post.total_haha}</div>
                                                <div className="angry"><i className="far fa-angry"></i> {this.state.post.total_angry}</div>
                                                <div className="comments meta-last"><i className="icon-comment"></i>{23} comments</div>
                                            </div>
                                        </div>
                                        <div className="post-body" dangerouslySetInnerHTML={{__html: DOMPurify.sanitize(this.state.post.description)}}></div>
                                        <div className="post-tags">
                                            {this.state.tags.map((tag) => 
                                                <a href="#" key={tag.id} className="tag">#{tag.name}</a>
                                            )}
                                        </div>
                                        <div className="posts-nav">
                                            <div className="row">
                                                <div className="col-md-4">
                                                    <h3 className="h6">Is it helpful?</h3>
                                                    <table className="table reaction_table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div className="reaction_holder" data-name="helpful" data-type="1">
                                                                        <i className="far fa-thumbs-up"></i><br />
                                                                        <span className="reaction_counter">0</span>
                                                                        <p className="reaction_name">Yes</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div className="reaction_holder active" data-name="unhelpful" data-type="2">
                                                                        <i className="far fa-thumbs-down"></i><br />
                                                                        <span className="reaction_counter">0</span>
                                                                        <p className="reaction_name">Not so</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div className="col-md-8">
                                                    <h3 className="h6">Express your feelings regarding this post</h3>
                                                    <table className="table reaction_table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div className="reaction_holder" data-name="love" data-type="3">
                                                                        <i className="far fa-grin-hearts"></i><br />
                                                                        <span className="reaction_counter">{this.state.post.total_love}</span>
                                                                        <p className="reaction_name">Love</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div className="reaction_holder active" data-name="wow" data-type="4">
                                                                        <i className="far fa-grin-stars"></i><br />
                                                                        <span className="reaction_counter">{this.state.post.total_wow}</span>
                                                                        <p className="reaction_name">Wow</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div className="reaction_holder" data-name="haha" data-type="5">
                                                                        <i className="far fa-laugh-squint"></i><br />
                                                                        <span className="reaction_counter">{this.state.post.total_haha}</span>
                                                                        <p className="reaction_name">Haha</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div className="reaction_holder" data-name="angry" data-type="6">
                                                                        <i className="far fa-angry"></i><br />
                                                                        <span className="reaction_counter">{this.state.post.total_angry}</span>
                                                                        <p className="reaction_name">Angry</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-md-12">
                                                <div className="accordion">
                                                    <ul className="nav">
                                                        <li className="nav-item">
                                                            <a className="nav-link" href="#reply-post" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="reply-options">Reply</a>
                                                        </li>
                                                        <li className="nav-item">
                                                            <a className="nav-link" href="#report-post" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="report-options">Report</a>
                                                        </li>
                                                    </ul>
                                                    <div className="collapse" id="reply-post" data-parent=".accordion">
                                                        <Editor
                                                            apiKey={this.state.editor_api_key}
                                                            init={this.state.editor_config}
                                                            onChange={this.handleEditor}
                                                        />
                                                        <button type="button" className="btn btn-danger btn-sm mt-2" onClick={this.reply}>Reply</button>
                                                    </div>
                                                    <div className="collapse" id="report-post" data-parent=".accordion">
                                                        <textarea className="form-control" rows="3" onChange={this.handleReport} placeholder="Give some description so that we can identify"></textarea>
                                                        <button type="button" className="btn btn-danger btn-sm mt-2" onClick={this.report}>Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="post-comments">
                                            <header>
                                                <h3 className="h6">Post Comments<span className="no-of-comments">(3)</span></h3>
                                            </header>
                                            {this.state.comments.map((comment) =>
                                                <LazyLoad key={comment.id}>
                                                    <CommentComponent key={comment.id} commentId={comment.id} />
                                                </LazyLoad>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </LazyLoad>
            </React.Fragment>
        );
    }
}

export default ShowPostComponent;

var rootElement = document.getElementById('showPost');

if (rootElement) {
    ReactDOM.render(<ShowPostComponent postId={rootElement.getAttribute('data-post-id')} />, rootElement);
}
