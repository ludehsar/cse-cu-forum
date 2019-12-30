class ProfileComponent extends Component {
    constructor(props) {
        super(props);

        this.state = {
            posts: [],
            categories: [],
            user: {},
            userId: props.userId,
            selfId: -1,
            activePage: 1,
            itemsCountPerPage: 1,
            totalItemsCount: 1,
        }
    }

    async componentDidMount() {
        axios.get('/api/users/' + this.state.userId + '/complete').then((response) => {
            this.setState({user: response.data});
        });

        axios.get('/api/user').then((response) => {
            this.setState({
                selfId: response.data.id
            });
        });

        this.handlePageChange();
    }

    handlePageChange = async (pageNumber = 1) => {
        axios.get('/api/users/' + this.state.userId + '/posts').then((response) => {
            this.setState({
                posts: response.data.data,
                activePage: response.data.current_page,
                itemsCountPerPage: response.data.per_page,
                totalItemsCount: response.data.total
            });
        });
    }

    deletePost = (postId) => {
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                axios.delete('/api/posts/delete/' + postId).then(() => {
                    swal.fire(
                        'Deleted!',
                        'This post has been deleted successfully!',
                        'success'
                    ).then(() => {
                        window.location.href="/";
                    });
                });
            }
        });
    }

    render() {
        return (
            <React.Fragment>
                <div className="profile">
                    <div className="row">
                        <div className="col-md-4">
                            <div className="profile-img">
                                <LazyLoad once>
                                    <img src={this.state.user.profile_picture_url} className="img-thumbnail" />
                                </LazyLoad>
                            </div>
                        </div>
                        <div className="col-md-8">
                            <div className="user-details">
                                <h2>{this.state.user.name}</h2>
                                <h3>{this.state.user.username}</h3>
                                <div className="mobile">Mobile number:
                                    {(this.state.user.mobile_number) ? (
                                        <strong> {this.state.user.mobile_number}</strong>
                                    ) : (
                                        <strong> None</strong>
                                    )}
                                </div>
                                <div className="blood-group">Blood group:
                                    {(this.state.user.mobile_number) ? (
                                        <strong> {this.state.user.blood_group}</strong>
                                    ) : (
                                        <strong> None</strong>
                                    )}
                                </div>
                                <div className="blood-group">Contribution point:
                                    {(this.state.user.contribution_point) ? (
                                        <strong> {this.state.user.contribution_point}</strong>
                                    ) : (
                                        <strong> 0</strong>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row p-3">
                        <div className="col-md-12">
                            {(this.state.user.bio) ? (
                                <div dangerouslySetInnerHTML={{__html: DOMPurify.sanitize(this.state.user.bio)}}></div>
                            ) : (
                                <p>No bio</p>
                            )}
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-12">
                            <ul className="nav nav-tabs" id="myTab" role="tablist">
                                <li className="nav-item">
                                    <a className="nav-link active" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">About</a>
                                </li>
                                <li className="nav-item">
                                    <a className="nav-link" id="post-tab" data-toggle="tab" href="#post" role="tab" aria-controls="post" aria-selected="false">Posts</a>
                                </li>
                            </ul>
                            <div className="tab-content profile-tab" id="myTabContent">
                                <div className="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
                                    <div className="row">
                                        <div className="col-md-4">
                                            <strong>Email</strong>
                                        </div>
                                        <div className="col-md-8">
                                            <p>{this.state.user.email}</p>
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-md-4">
                                            <strong>Gender</strong>
                                        </div>
                                        <div className="col-md-8">
                                            {(this.state.user.gender) ? (
                                                <p>{this.state.user.gender}</p>
                                            ) : (
                                                <p>Not specified</p>
                                            )}
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-md-4">
                                            <strong>Date of birth</strong>
                                        </div>
                                        <div className="col-md-8">
                                            {(this.state.user.birth_date) ? (
                                                <p>{moment(this.state.user.birth_date).format("DD MMMM, YYYY")}</p>
                                            ) : (
                                                <p>Not specified</p>
                                            )}
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-md-4">
                                            <strong>Role</strong>
                                        </div>
                                        <div className="col-md-8">
                                            {(this.state.user.is_teacher) ? (
                                                <p>Teacher</p>
                                            ) : (
                                                <p>Student</p>
                                            )}
                                        </div>
                                    </div>
                                    {(!this.state.user.is_teacher) && (
                                        <div className="row">
                                            <div className="col-md-4">
                                                <strong>Student ID</strong>
                                            </div>
                                            <div className="col-md-8">
                                                {(this.state.user.student_id) ? (
                                                    <p>{this.state.user.student_id}</p>
                                                ) : (
                                                    <p>Not specified</p>
                                                )}
                                            </div>
                                        </div>
                                    )}
                                    <div className="row">
                                        <div className="col-md-4">
                                            <strong>Department</strong>
                                        </div>
                                        <div className="col-md-8">
                                            {(this.state.user.department) ? (
                                                <p>{this.state.user.department}</p>
                                            ) : (
                                                <p>Not specified</p>
                                            )}
                                        </div>
                                    </div>
                                    {(!this.state.user.is_teacher) && (
                                        <div className="row">
                                            <div className="col-md-4">
                                                <strong>Ongoing degree</strong>
                                            </div>
                                            <div className="col-md-8">
                                                {(this.state.user.ongoing_degree) ? (
                                                    <p>{this.state.user.ongoing_degree}</p>
                                                ) : (
                                                    <p>Not specified</p>
                                                )}
                                            </div>
                                        </div>
                                    )}
                                    {(!this.state.user.is_teacher) && (
                                        <div className="row">
                                            <div className="col-md-4">
                                                <strong>Session</strong>
                                            </div>
                                            <div className="col-md-8">
                                                {(this.state.user.session) ? (
                                                    <p>{this.state.user.session}</p>
                                                ) : (
                                                    <p>Not specified</p>
                                                )}
                                            </div>
                                        </div>
                                    )}
                                    {(!this.state.user.is_teacher) && (
                                        <div className="row">
                                            <div className="col-md-4">
                                                <strong>Alloted hall</strong>
                                            </div>
                                            <div className="col-md-8">
                                                {(this.state.user.alloted_hall) ? (
                                                    <p>{this.state.user.alloted_hall}</p>
                                                ) : (
                                                    <p>Not specified</p>
                                                )}
                                            </div>
                                        </div>
                                    )}
                                </div>
                                <div className="tab-pane fade" id="post" role="tabpanel" area-labelledby="post-tab">
                                    {this.state.posts.map((post) =>
                                        <LazyLoad key={post.id}>
                                            <div className="row d-flex align-items-stretch">
                                                <div className="text w-100">
                                                    <div className="text-inner d-flex align-items-center">
                                                        <div className="content">
                                                            {(this.state.selfId == this.state.userId) && (
                                                                <div>
                                                                    <a className="float-right font-weight-light" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i className="fas fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <div className="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a className="dropdown-item" href={"/posts/edit/" + post.id}>Edit</a>
                                                                        <a className="dropdown-item" href="#" onClick={() => { this.deletePost(post.id) }}>Delete</a>
                                                                    </div>
                                                                </div>
                                                            )}
                                                            <header className="post-header">
                                                                <div className="category"><a href="#">{post.category_name}</a></div>
                                                                <a href={"/posts/" + post.slug}><h2 className="h4">{post.title}</h2></a>
                                                            </header>
                                                            <p>{post.subtitle}</p>
                                                            <footer className="post-footer d-flex align-items-center">
                                                                <div className="date"><i className="icon-clock"></i> {moment.utc(post.created_at).fromNow()}</div>
                                                                <div className="contributions"> <i className="fab fa-cuttlefish"></i> {post.total_contribution} contribuions</div>
                                                                <div className="love"><i className="far fa-grin-hearts"></i> {post.total_love}</div>
                                                                <div className="wow"><i className="far fa-grin-stars"></i> {post.total_wow}</div>
                                                                <div className="haha"><i className="far fa-laugh-squint"></i> {post.total_haha}</div>
                                                                <div className="angry"><i className="far fa-angry"></i> {post.total_angry}</div>
                                                                <div className="comments"><i className="icon-comment"></i>{post.total_comments} comments</div>
                                                            </footer>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </LazyLoad>
                                    )}
                                    <div className="clearfix mb-3">
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
                            </div>
                        </div>
                    </div>
                </div>
            </React.Fragment>
        );
    }
}

export default ProfileComponent;

var rootElement = document.getElementById('profile');

if (rootElement) {
    ReactDOM.render(<ProfileComponent userId={rootElement.getAttribute('data-user-id')} />, rootElement);
}
