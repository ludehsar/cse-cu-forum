class CommentComponent extends Component {
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
            commentId: props.commentId,
            selfId: -1,
            comment: {},
            replies: [],
            user: {},
            editDescription: '',
            replyDescription: '',
            reportDescription: '',
        }
    }

    async componentDidMount() {
        
        this.fetchComment();

        axios.get('/api/user').then((response) => {
            this.setState({selfId: response.data.id});
        });
    }

    fetchComment = () => {
        axios.get('/api/comments/' + this.state.commentId).then((response) => {
            this.setState({comment: response.data});
            axios.get('/api/users/' + this.state.comment.user_id).then((res2) => {
                this.setState({user: res2.data});
            });
        });

        this.fetchReplies();
    }

    fetchReplies = () => {
        axios.get('/api/comments/' + this.state.commentId + '/replies').then((response) => {
            this.setState({replies: response.data});
        });
    }

    handleReplyEditor = (e) => {
        let rev = e.target.getContent();
        this.setState({
            replyDescription: rev
        });
    }

    handleEditEditor = (e) => {
        let rev = e.target.getContent();
        this.setState({
            editDescription: rev
        });
    }

    reply = () => {
        axios.post('/api/comments/add', {
            post_id: this.state.comment.post_id,
            parent_id: this.state.commentId,
            description: this.state.replyDescription
        }).then(() => {
            this.fetchReplies();
            this.setState({
                replyDescription: ''
            });
        });
    }

    edit = () => {
        axios.put('/api/comments/' + this.state.commentId + '/edit', {
            description: this.state.editDescription
        }).then(() => {
            this.fetchComment();
        });
    }

    deleteComment = () => {
        swal.fire({
            title: 'Are you sure you want to delete this comment?',
            text: "All other replies of this comment will also be deleted!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                axios.delete('/api/comments/' + this.state.commentId + '/delete').then(() => {
                    swal.fire(
                        'Deleted!',
                        'This comment has been deleted successfully!',
                        'success'
                    ).then(() => {
                        document.location.reload(true);
                    });
                });
            }
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
            title: 'Are you sure you want to report to this comment?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Report!'
        }).then((result) => {
            if (result.value) {
                axios.post('/api/reports/add', {
                    comment_id: this.state.commentId,
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
            <div>
                <div className="comment">
                    <div className="comment-header d-flex justify-content-between">
                        <a href={"/profile/" + this.state.user.username} className="user d-flex align-items-center">
                            <div className="image"><img src={this.state.user.profile_picture_url} alt="..." className="img-fluid rounded-circle" /></div>
                            <div className="title"><strong>{this.state.user.name}</strong><span className="date">{moment.utc(this.state.comment.created_at).fromNow()}</span></div>
                        </a>
                    </div>
                    <div className="comment-body" dangerouslySetInnerHTML={{__html: DOMPurify.sanitize(this.state.comment.description)}}></div>
                    <div className="comment-footer accordion">
                        <ul className="nav">
                            {(this.state.selfId == this.state.user.id) && (
                                <li className="nav-item">
                                    <a className="nav-link" href={"#edit-comment-" + this.state.commentId} data-toggle="collapse" role="button" aria-expanded="false" aria-controls="edit-options">Edit</a>
                                </li>
                            )}
                            <li className="nav-item">
                                <a className="nav-link" href={"#react-comment-" + this.state.commentId} data-toggle="collapse" role="button" aria-expanded="false" aria-controls="react-options">React</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href={"#reply-comment-" + this.state.commentId} data-toggle="collapse" role="button" aria-expanded="false" aria-controls="reply-options">Reply</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href={"#report-comment-" + this.state.commentId} data-toggle="collapse" role="button" aria-expanded="false" aria-controls="report-options">Report</a>
                            </li>
                            {(this.state.selfId == this.state.user.id) && (
                                <li className="nav-item">
                                    <a className="nav-link" href="#" onClick={this.deleteComment}>Delete</a>
                                </li>
                            )}
                        </ul>
                        {(this.state.selfId == this.state.user.id) && (
                            <div className="collapse" id={"edit-comment-" + this.state.commentId} data-parent=".comment-footer">
                                <Editor
                                    initialValue={this.state.comment.description}
                                    apiKey={this.state.editor_api_key}
                                    init={this.state.editor_config}
                                    onChange={this.handleEditEditor}
                                />
                                <button type="button" className="btn btn-danger btn-sm mt-2" onClick={this.edit}>Edit</button>
                            </div>
                        )}
                        <div className="collapse" id={"react-comment-" + this.state.commentId} data-parent=".comment-footer">    
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
                                    <h3 className="h6">Express your feelings regarding this comment</h3>
                                    <table className="table reaction_table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div className="reaction_holder" data-name="love" data-type="3">
                                                        <i className="far fa-grin-hearts"></i><br />
                                                        <span className="reaction_counter">{this.state.comment.total_love}</span>
                                                        <p className="reaction_name">Love</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div className="reaction_holder active" data-name="wow" data-type="4">
                                                        <i className="far fa-grin-stars"></i><br />
                                                        <span className="reaction_counter">{this.state.comment.total_wow}</span>
                                                        <p className="reaction_name">Wow</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div className="reaction_holder" data-name="haha" data-type="5">
                                                        <i className="far fa-laugh-squint"></i><br />
                                                        <span className="reaction_counter">{this.state.comment.total_haha}</span>
                                                        <p className="reaction_name">Haha</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div className="reaction_holder" data-name="angry" data-type="6">
                                                        <i className="far fa-angry"></i><br />
                                                        <span className="reaction_counter">{this.state.comment.total_angry}</span>
                                                        <p className="reaction_name">Angry</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div className="collapse" id={"reply-comment-" + this.state.commentId} data-parent=".comment-footer">
                            <Editor
                                apiKey={this.state.editor_api_key}
                                init={this.state.editor_config}
                                onChange={this.handleReplyEditor}
                            />
                            <button type="button" className="btn btn-danger btn-sm mt-2" onClick={this.reply}>Reply</button>
                        </div>
                        <div className="collapse" id={"report-comment-" + this.state.commentId} data-parent=".comment-footer">
                            <textarea className="form-control" rows="3" onChange={this.handleReport} placeholder="Give some description so that we can identify"></textarea>
                            <button type="button" className="btn btn-danger btn-sm mt-2" onClick={this.report}>Submit</button>
                        </div>
                    </div>
                </div>
                <div style={{marginLeft: '5%'}}>
                    {this.state.replies.map((reply) =>
                        <LazyLoad key={reply.id}>
                            <CommentComponent key={reply.id} commentId={reply.id} />
                        </LazyLoad>
                    )}
                </div>
            </div>
        );
    }
}

export default CommentComponent;