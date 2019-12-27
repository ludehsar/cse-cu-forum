function SinglePostReview(props) {
    return (
        <div className="row d-flex align-items-stretch">
            <div className="text w-100">
                <div className="text-inner d-flex align-items-center">
                    <div className="content">
                        <header className="post-header">
                            <div className="category"><a href="#">{props.category_name}</a></div>
                            <a href={"/posts/" + props.slug}><h2 className="h4">{props.title}</h2></a>
                        </header>
                        <p>{props.subtitle}</p>
                        <footer className="post-footer d-flex align-items-center">
                            <a href="#" className="author d-flex align-items-center flex-wrap">
                                <div className="avatar"><img src={props.user_profile_picture_url} alt="..." className="img-fluid" /></div>
                                <div className="title"><span>{props.username}</span></div>
                            </a>
                            <div className="date"><i className="icon-clock"></i> {props.created_at}</div>
                            <div className="contributions"> <i className="fab fa-cuttlefish"></i> {props.total_contribution} contribuions</div>
                            <div className="love"><i className="far fa-grin-hearts"></i> {props.total_love}</div>
                            <div className="wow"><i className="far fa-grin-stars"></i> {props.total_wow}</div>
                            <div className="haha"><i className="far fa-laugh-squint"></i> {props.total_haha}</div>
                            <div className="angry"><i className="far fa-angry"></i> {props.total_angry}</div>
                            <div className="comments"><i className="icon-comment"></i>{props.total_comments} comments</div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    );
}

class HomepageComponent extends Component {
    constructor() {
        super();
        this.state = {
            posts: [],
            activePage: 1,
            itemsCountPerPage: 1,
            totalItemsCount: 1,
        }
    }

    async componentDidMount() {
        this.handlePageChange();
    }

    handlePageChange = async (pageNumber = 1) => {
        axios.get('/api/posts/frontend?page=' + pageNumber).then(response => {
            this.setState({
                posts: response.data.data,
                activePage: response.data.current_page,
                itemsCountPerPage: response.data.per_page,
                totalItemsCount: response.data.total
            });
        });
    }

    render() {
        return (
            <React.Fragment>
                <div className="container">
                    {this.state.posts.map((post) =>
                        <SinglePostReview
                            key={post.id}
                            category_name={post.category_name}
                            slug={post.slug}
                            title={post.title}
                            subtitle={post.subtitle}
                            user_profile_picture_url={post.user_profile_picture_url}
                            username={post.username}
                            created_at={moment.utc(post.created_at).fromNow()}
                            total_contribution={post.total_contribution}
                            total_love={post.total_love}
                            total_wow={post.total_wow}
                            total_haha={post.total_haha}
                            total_angry={post.total_angry}
                            total_comments={post.total_comments}
                        />
                    )}
                    <div className="clearfix">
                        <Pagination
                            activePage={this.state.activePage}
                            itemsCountPerPage={this.state.itemsCountPerPage}
                            totalItemsCount={this.state.totalItemsCount}
                            pageRangeDisplayed={5}
                            innerClass="pagination pagination-template d-flex justify-content-center"
                            itemClass='page-item'
                            linkClass='page-link'
                            onChange={this.handlePageChange}
                        />
                    </div>
                </div>
            </React.Fragment>
        );
    }
}

export default HomepageComponent;

if (document.getElementById('homepage')) {
    ReactDOM.render(<HomepageComponent />, document.getElementById('homepage'));
}
