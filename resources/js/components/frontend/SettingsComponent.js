class SettingsComponent extends Component {
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
                }
            },
            profilePictureFile: null,
            progressOfUploading: 0,
            uploadProgressDisplayValue: 'none',
            user: {},
            userId: props.userId,
            bio: '',
            accountInfo: {
                old_password: '',
                new_password: '',
                password_confirmation: ''
            },
            profileInfo: {
                birth_date: '',
                gender: '',
                mobile_number: '',
                blood_group: '',
            },
            universityProfileInfo: {
                student_id: '',
                department: '',
                ongoing_degree: '',
                session: '',
                alloted_hall: '',
            }
        }
    }

    async componentDidMount() {
        this.getUser();
    }

    getUser = () => {
        axios.get('/api/users/' + this.state.userId + '/complete').then((response) => {
            this.setState({user: response.data}, () => {
                this.setState({bio: this.state.user.bio || ''});

                let newProfileInfo = this.state.profileInfo;
                
                newProfileInfo.birth_date = this.state.user.birth_date || '';
                newProfileInfo.gender = this.state.user.gender || '';
                newProfileInfo.mobile_number = this.state.user.mobile_number || '';
                newProfileInfo.blood_group = this.state.user.blood_group || '';
                this.setState({profileInfo: newProfileInfo});

                let newUniversityProfileInfo = this.state.universityProfileInfo;

                newUniversityProfileInfo.student_id = this.state.user.student_id || '';
                newUniversityProfileInfo.department = this.state.user.department || '';
                newUniversityProfileInfo.ongoing_degree = this.state.user.ongoing_degree || '';
                newUniversityProfileInfo.session = this.state.user.session || '';
                newUniversityProfileInfo.alloted_hall = this.state.user.alloted_hall || '';
                this.setState({universityProfileInfo: newUniversityProfileInfo});
            });
        });
    }

    changeProfilePicture = (e) => {
        if (!e.target.files) return;

        this.setState({
            profilePictureFile: e.target.files[0]
        }, function () {
            const formData = new FormData();
            formData.append(
                'file',
                this.state.profilePictureFile,
                this.state.profilePictureFile.name
            )
            
            this.setState({uploadProgressDisplayValue: 'block'});
            
            axios.post('/api/user/upload', formData, {
                onUploadProgress: progressEvent => {
                    this.setState({
                        progressOfUploading: Math.round(progressEvent.loaded / progressEvent.total * 100.00)
                    });
                }
            }).then((response) => {
                this.setState({
                    progressOfUploading: 0,
                    uploadProgressDisplayValue: 'none'
                });
                this.getUser();
            });
        });
    }

    handleEditor = (e) => {
        this.setState({
            bio: e.target.getContent()
        });
    }

    changeBio = () => {
        const formData = new FormData();
        formData.append('bio', this.state.bio);
        axios.post('/api/user/bio', formData).then(() => {
            this.getUser();
            swal.fire(
                'Updated bio!',
                'You bio has been successfully updated!',
                'success'
            );
        });
    }

    handleAccountChange = (e) => {
        const targetName = e.target.name;
        const targetValue = e.target.value;
        let newAccountInfo = this.state.accountInfo;
        if (targetName == 'old_password') newAccountInfo.old_password = targetValue;
        else if (targetName == 'new_password') newAccountInfo.new_password = targetValue;
        else if (targetName == 'password_confirmation') newAccountInfo.password_confirmation = targetValue;
        this.setState({
            accountInfo: newAccountInfo
        });
    }

    handleProfileBirthDateChange = (e) => {
        let newProfileInfo = this.state.profileInfo;
        newProfileInfo.birth_date = e.format("YYYY-MM-DD");
        this.setState({profileInfo: newProfileInfo});
    }

    handleProfileChange = (e) => {
        const targetName = e.target.name;
        const targetValue = e.target.value;
        let newProfileInfo = this.state.profileInfo;
        if (targetName == 'gender') newProfileInfo.gender = targetValue;
        else if (targetName == 'mobile_number') newProfileInfo.mobile_number = targetValue;
        else if (targetName == 'blood_group') newProfileInfo.blood_group = targetValue;
        this.setState({
            profileInfo: newProfileInfo
        });
    }

    handleUniversityProfileChange = (e) => {
        const targetName = e.target.name;
        const targetValue = e.target.value;
        let newUniversityProfileInfo = this.state.universityProfileInfo;
        if (targetName == 'student_id') newUniversityProfileInfo.student_id = targetValue;
        else if (targetName == 'department') newUniversityProfileInfo.department = targetValue;
        else if (targetName == 'ongoing_degree') newUniversityProfileInfo.ongoing_degree = targetValue;
        else if (targetName == 'session') newUniversityProfileInfo.session = targetValue;
        else if (targetName == 'alloted_hall') newUniversityProfileInfo.alloted_hall = targetValue;
        this.setState({
            universityProfileInfo: newUniversityProfileInfo
        });
    }

    updateAccountInfo = (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('old_password', this.state.accountInfo.old_password);
        formData.append('new_password', this.state.accountInfo.new_password);
        formData.append('password_confirmation', this.state.accountInfo.password_confirmation);
        axios.post('/api/user/change_password', formData).then(() => {
            swal.fire(
                'Updated password successfully!',
                'You password has been successfully updated!',
                'success'
            );
            this.getUser();
        }).catch(err => {
            swal.fire({
                title: 'Update failed',
                icon: 'error'
            });
        });
    }

    updateProfileInfo = (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('birth_date', this.state.profileInfo.birth_date);
        formData.append('gender', this.state.profileInfo.gender);
        formData.append('mobile_number', this.state.profileInfo.mobile_number);
        formData.append('blood_group', this.state.profileInfo.blood_group);
        axios.post('/api/user/change_profile', formData).then(() => {
            swal.fire(
                'Updated profile information successfully!',
                'You profile information has been successfully updated!',
                'success'
            );
            this.getUser();
        }).catch(err => {
            swal.fire({
                title: 'Update failed',
                icon: 'error'
            });
        });
    }

    updateUniversityProfileInfo = (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('student_id', this.state.universityProfileInfo.student_id);
        formData.append('department', this.state.universityProfileInfo.department);
        formData.append('ongoing_degree', this.state.universityProfileInfo.ongoing_degree);
        formData.append('session', this.state.universityProfileInfo.session);
        formData.append('alloted_hall', this.state.universityProfileInfo.alloted_hall);
        axios.post('/api/user/change_university_profile', formData).then(() => {
            swal.fire(
                'Updated university information successfully!',
                'You university profile information has been successfully updated!',
                'success'
            );
            this.getUser();
        }).catch(err => {
            swal.fire({
                title: 'Update failed',
                icon: 'error'
            });
        });
    }

    render() {
        return (
            <React.Fragment>
                <LazyLoad>
                <div className="profile">
                    <div className="row">
                        <div className="col-md-4">
                            <div className="profile-img">
                                    <img src={this.state.user.profile_picture_url} className="img-thumbnail" />
                                    <div className="file btn btn-lg btn-primary">
                                        Change Photo
                                        <input type="file" name="file" accept="image/*" onChange={this.changeProfilePicture}/>
                                    </div>
                                    <div className="progress" style={{display: this.state.uploadProgressDisplayValue}}>
                                        <div className="progress-bar progress-bar-striped progress-bar-animated bg-danger" style={{width: this.state.progressOfUploading + "%"}} role="progressbar" aria-valuenow={this.state.progressOfUploading} aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                            </div>
                        </div>
                        <div className="col-md-8">
                            <div className="user-details">
                                <h2>{this.state.user.name}</h2>
                                <h3>{this.state.user.username}</h3>
                                <div className="email">Email: {this.state.user.email}</div>
                            </div>
                        </div>
                    </div>
                    <div className="row p-3">
                        <div className="col-md-12">
                            <Editor
                                apiKey={this.state.editor_api_key}
                                initialValue={this.state.bio}
                                init={this.state.editor_config}
                                onChange={this.handleEditor}
                            />
                            <button className="btn btn-danger btn-sm mt-2 p-2" onClick={this.changeBio}>Save bio</button>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-12">
                            <ul className="nav nav-tabs" id="myTab" role="tablist">
                                <li className="nav-item">
                                    <a className="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true">Account</a>
                                </li>
                                <li className="nav-item">
                                    <a className="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                                </li>
                                <li className="nav-item">
                                    <a className="nav-link" id="university-tab" data-toggle="tab" href="#university" role="tab" aria-controls="university" aria-selected="false">University Information</a>
                                </li>
                            </ul>
                            <div className="tab-content profile-tab" id="myTabContent">
                                <div className="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                                    <form onSubmit={this.updateAccountInfo} method="post">
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>Old password</label>
                                            </div>
                                            <div className="col-md-8">
                                                <input className="form-control" type="password" name="old_password" placeholder="Enter the old password" onChange={this.handleAccountChange} required />
                                            </div>
                                        </div>
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>New password</label>
                                            </div>
                                            <div className="col-md-8">
                                                <input className="form-control" type="password" name="new_password" placeholder="Enter a new password" onChange={this.handleAccountChange} required />
                                            </div>
                                        </div>
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>Confirm password</label>
                                            </div>
                                            <div className="col-md-8">
                                                <input className="form-control" type="password" name="password_confirmation" placeholder="Confirm password" onChange={this.handleAccountChange} required />
                                            </div>
                                        </div>
                                        <div className="row form-group">
                                            <button type="submit" className="btn btn-danger btn-sm mx-auto">Change Password</button>
                                        </div>
                                    </form>
                                </div>
                                <div className="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <form onSubmit={this.updateProfileInfo} method="post">
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>Date of Birth</label>
                                            </div>
                                            <div className="col-md-8">
                                                <Datetime
                                                    value={moment(this.state.profileInfo.birth_date).format("YYYY-MM-DD")}
                                                    onChange={this.handleProfileBirthDateChange}
                                                    dateFormat="YYYY-MM-DD"
                                                    timeFormat={false}
                                                    inputProps={{
                                                        className: 'form-control',
                                                        placeholder: 'Enter your birth date',
                                                        name: 'birth_date',
                                                        readOnly: true,
                                                        required: true
                                                    }}
                                                />
                                            </div>
                                        </div>
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>Gender</label>
                                            </div>
                                            <div className="col-md-8">
                                                <select className="form-control" name="gender" onChange={this.handleProfileChange} value={this.state.profileInfo.gender}>
                                                    <option disabled value="">Please select one</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>Mobile Number</label>
                                            </div>
                                            <div className="col-md-8">
                                                <input type="text" name="mobile_number" className="form-control" placeholder="Enter your mobile number" value={this.state.profileInfo.mobile_number} onChange={this.handleProfileChange} required />
                                            </div>
                                        </div>
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>Blood Group</label>
                                            </div>
                                            <div className="col-md-8">
                                                <select className="form-control" name="blood_group" onChange={this.handleProfileChange} value={this.state.profileInfo.blood_group}>
                                                    <option disabled value="">Please select one</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div className="row form-group">
                                            <button type="submit" className="btn btn-danger btn-sm mx-auto">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div className="tab-pane fade" id="university" role="tabpanel" aria-labelledby="university-tab">
                                    <form onSubmit={this.updateUniversityProfileInfo} method="post">
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>Role</label>
                                            </div>
                                            <div className="col-md-8">
                                                {(this.state.user.is_teacher) ? (
                                                    <p>Teacher</p>
                                                ) : (
                                                    <p>Student</p>
                                                )}
                                            </div>
                                        </div>
                                        {!(this.state.user.is_teacher) && (
                                            <div className="row form-group">
                                                <div className="col-md-4">
                                                    <label>Student ID</label>
                                                </div>
                                                <div className="col-md-8">
                                                    <input type="text" name="student_id" className="form-control" onChange={this.handleUniversityProfileChange} placeholder="Enter your student ID no." value={this.state.universityProfileInfo.student_id} />
                                                </div>
                                            </div>
                                        )}
                                        <div className="row form-group">
                                            <div className="col-md-4">
                                                <label>Department</label>
                                            </div>
                                            <div className="col-md-8">
                                                <input type="text" name="department" className="form-control" onChange={this.handleUniversityProfileChange} placeholder="Enter your department" value={this.state.universityProfileInfo.department} />
                                            </div>
                                        </div>
                                        {!(this.state.user.is_teacher) && (
                                            <div className="row form-group">
                                                <div className="col-md-4">
                                                    <label>Ongoing Degree</label>
                                                </div>
                                                <div className="col-md-8">
                                                    <input type="text" name="ongoing_degree" className="form-control" onChange={this.handleUniversityProfileChange} placeholder="Ongoing Degree" value={this.state.universityProfileInfo.ongoing_degree} />
                                                </div>
                                            </div>
                                        )}
                                        {!(this.state.user.is_teacher) && (
                                            <div className="row form-group">
                                                <div className="col-md-4">
                                                    <label>Session</label>
                                                </div>
                                                <div className="col-md-8">
                                                    <input type="text" name="session" className="form-control" onChange={this.handleUniversityProfileChange} placeholder="Enter your session" value={this.state.universityProfileInfo.session} />
                                                </div>
                                            </div>
                                        )}
                                        {!(this.state.user.is_teacher) && (
                                            <div className="row form-group">
                                                <div className="col-md-4">
                                                    <label>Alloted Hall</label>
                                                </div>
                                                <div className="col-md-8">
                                                    <input type="text" name="alloted_hall" className="form-control" onChange={this.handleUniversityProfileChange} placeholder="Alloted hall" value={this.state.universityProfileInfo.alloted_hall} />
                                                </div>
                                            </div>
                                        )}
                                        <div className="row form-group">
                                            <button type="submit" className="btn btn-danger btn-sm mx-auto">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </LazyLoad>
            </React.Fragment>
        );
    }
}

export default SettingsComponent;

var rootElement = document.getElementById('settings');

if (rootElement) {
    ReactDOM.render(<SettingsComponent userId={rootElement.getAttribute('data-user-id')} />, rootElement);
}
