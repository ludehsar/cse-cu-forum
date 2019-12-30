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
        }
    }

    handleEditor = (e) => {
        console.log(e.target.getContent());
    }

    reply = () => {

    }

    handleReport = (e) => {
        
    }

    report = () => {

    }

    render() {
        return (
            <div className="post-comments">
                <header>
                    <h3 className="h6">Post Comments<span className="no-of-comments">(3)</span></h3>
                </header>
                <div className="comment">
                    <div className="comment-header d-flex justify-content-between">
                        <div className="user d-flex align-items-center">
                            <div className="image"><img src="/frontend/img/user.svg" alt="..." className="img-fluid rounded-circle" /></div>
                            <div className="title"><strong>Jabi Hernandiz</strong><span className="date">May 2016</span></div>
                        </div>
                    </div>
                    <div className="comment-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                    </div>
                    <div className="comment-footer accordion">
                        <ul className="nav">
                            <li className="nav-item">
                                <a className="nav-link" href="#react-comment" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="react-options">React</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#reply-comment" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="reply-options">Reply</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#report-comment" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="report-options">Report</a>
                            </li>
                        </ul>
                        <div className="collapse" id="react-comment" data-parent=".comment-footer">    
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
                                                        <span className="reaction_counter">2</span>
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
                                                        <span className="reaction_counter">0</span>
                                                        <p className="reaction_name">Love</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div className="reaction_holder active" data-name="wow" data-type="4">
                                                        <i className="far fa-grin-stars"></i><br />
                                                        <span className="reaction_counter">2</span>
                                                        <p className="reaction_name">Wow</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div className="reaction_holder" data-name="haha" data-type="5">
                                                        <i className="far fa-laugh-squint"></i><br />
                                                        <span className="reaction_counter">0</span>
                                                        <p className="reaction_name">Haha</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div className="reaction_holder" data-name="angry" data-type="6">
                                                        <i className="far fa-angry"></i><br />
                                                        <span className="reaction_counter">0</span>
                                                        <p className="reaction_name">Angry</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div className="collapse" id="reply-comment" data-parent=".comment-footer">
                            <Editor
                                apiKey={this.state.editor_api_key}
                                init={this.state.editor_config}
                                onChange={this.handleEditor}
                            />
                            <button type="button" className="btn btn-danger btn-sm mt-2" onClick={this.reply}>Reply</button>
                        </div>
                        <div className="collapse" id="report-comment" data-parent=".comment-footer">
                            <textarea class="form-control" rows="3" onChange={this.handleReport} placeholder="Give some description so that we can identify"></textarea>
                            <button type="button" className="btn btn-danger btn-sm mt-2" onClick={this.report}>Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default CommentComponent;