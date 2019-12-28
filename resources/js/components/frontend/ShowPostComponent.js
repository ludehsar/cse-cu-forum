function SingleCommentComponent(props) {
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
            </div>
        </div>
    );
}

class ShowPostComponent extends Component {
    constructor(props) {
        super(props);

        this.state = {
            post: {},
            category: {},
            tags: [],
            user: {},
            postId: props.postId,
        }
    }

    async componentDidMount() {
        axios.get('/api/posts/' + this.state.postId).then((response) => {
            this.setState({post: response.data});
            axios.get('/api/categories/' + this.state.post.category_id).then((res2) => {
                this.setState({category: res2.data});
            });
            axios.get('/api/users/' + this.state.post.user_id).then((res4) => {
                this.setState({user: res4.data});
            });
        });
        axios.get('/api/posts/' + this.state.postId + '/tags').then((res3) => {
            this.setState({tags: res3.data});
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
                                            <a href="#" className="author d-flex align-items-center flex-wrap">
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
                                        <SingleCommentComponent />
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
