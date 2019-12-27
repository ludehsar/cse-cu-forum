<template>
    <!-- Begin Page Content -->
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img :src="profile_picture_url" alt="User profile picture" class="img-thumbnail"/>
                        <div class="file btn btn-lg btn-primary">
                            Change Photo
                            <input type="file" name="file" accept="image/*" @change="uploadProfilePhoto"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="profile-head">
                        <h5>
                            {{ name }}
                        </h5>
                        <div>
                            <h6>Bio</h6>
                            <form @submit.prevent="updateBio" @keydown="bio.onKeydown($event)" method="post">
                                <editor v-model="bio.bio" :api-key="editor_api_key" id="description" :init="editor_config"></editor>
                                <button type="submit" class="btn btn-primary btn-sm mt-3">Save Bio</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true">Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="university-tab" data-toggle="tab" href="#university" role="tab" aria-controls="university" aria-selected="false">University Information</a>
                        </li>
                    </ul>
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <form @submit.prevent="updateAccountInfo" method="post">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>User Id</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" :value="id" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" :value="name" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>User Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" :value="username" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" :value="email" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Old password</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="account.old_password" class="form-control" :class="{ 'is-invalid': account.errors.has('old_password') }" type="password" placeholder="Enter the old password" required>
                                        <has-error :form="account" field="old_password"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>New password</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="account.new_password" class="form-control" :class="{ 'is-invalid': account.errors.has('new_password') }" type="password" placeholder="Enter a new password" required>
                                        <has-error :form="account" field="new_password"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Confirm password</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="account.password_confirmation" class="form-control" :class="{ 'is-invalid': account.errors.has('password_confirmation') }" type="password" placeholder="Confirm password" required>
                                        <has-error :form="account" field="password_confirmation"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <button type="submit" class="btn btn-primary btn-sm mx-auto">Change Password</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form @submit.prevent="updateProfileInfo" method="post">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Date of Birth</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="birth_date_picker" data-toggle="datetimepicker" data-target="#birth_date_picker" class="form-control" :class="{ 'is-invalid': profile.errors.has('birth_date') }" placeholder="Enter your birth date" required readonly>
                                        <has-error :form="profile" field="birth_date"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Gender</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select v-model="profile.gender" class="form-control" :class="{ 'is-invalid': profile.errors.has('gender') }">
                                            <option disabled value="">Please select one</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <has-error :form="profile" field="gender"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Mobile Number</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="profile.mobile_number" type="text" class="form-control" :class="{ 'is-invalid': profile.errors.has('mobile_number') }" placeholder="Enter your mobile number" required>
                                        <has-error :form="profile" field="mobile_number"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Blood Group</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select v-model="profile.blood_group" class="form-control" :class="{ 'is-invalid': profile.errors.has('blood_group') }">
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
                                        <has-error :form="profile" field="blood_group"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <button type="submit" class="btn btn-primary btn-sm mx-auto">Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="university" role="tabpanel" aria-labelledby="university-tab">
                            <form @submit.prevent="updateUniversityProfileInfo" method="post">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Role</label>
                                    </div>
                                    <div class="col-md-8">
                                        <p v-if="is_teacher">Teacher</p>
                                        <p v-else>Student</p>
                                    </div>
                                </div>
                                <div v-if="!is_teacher" class="row form-group">
                                    <div class="col-md-4">
                                        <label>Student ID</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="university.student_id" type="text" class="form-control" :class="{ 'is-invalid': university.errors.has('student_id') }" placeholder="Enter your student ID no.">
                                        <has-error :form="university" field="student_id"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Department</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="university.department" type="text" class="form-control" :class="{ 'is-invalid': university.errors.has('department') }" placeholder="Enter your department">
                                        <has-error :form="university" field="department"></has-error>
                                    </div>
                                </div>
                                <div v-if="!is_teacher" class="row form-group">
                                    <div class="col-md-4">
                                        <label>Ongoing Degree</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="university.ongoing_degree" type="text" class="form-control" :class="{ 'is-invalid': university.errors.has('ongoing_degree') }" placeholder="Ongoing Degree">
                                        <has-error :form="university" field="ongoing_degree"></has-error>
                                    </div>
                                </div>
                                <div v-if="!is_teacher" class="row form-group">
                                    <div class="col-md-4">
                                        <label>Session</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="university.session" type="text" class="form-control" :class="{ 'is-invalid': university.errors.has('session') }" placeholder="Enter your session">
                                        <has-error :form="university" field="session"></has-error>
                                    </div>
                                </div>
                                <div v-if="!is_teacher" class="row form-group">
                                    <div class="col-md-4">
                                        <label>Alloted Hall</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input v-model="university.alloted_hall" type="text" class="form-control" :class="{ 'is-invalid': university.errors.has('alloted_hall') }" placeholder="Alloted hall">
                                        <has-error :form="university" field="alloted_hall"></has-error>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <button type="submit" class="btn btn-primary btn-sm mx-auto">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    export default {
        mounted () {
            axios.get('/api/user').then((response) => {
                this.id = response.data.id;
                
                this.decorateUser(this.id);
            });

            $('#birth_date_picker').datetimepicker({
                format: 'YYYY-MM-DD',
                ignoreReadonly: true,
            });

            $(document).on('change.datetimepicker', (e) => {
                if (e.date) {
                    this.profile.birth_date = e.date.format("YYYY-MM-DD");
                }
            });
        },
        watch: {
            '$route': function() {
                axios.get('/api/user').then((response) => {
                    this.id = response.data.id;
                    
                    this.decorateUser(this.id);
                });
            }
        },
        data () {
            return {
                profile_picture: new Form({
                    file: null,
                }),
                editor_api_key: process.env.MIX_EDITOR_API_KEY,
                editor_config: {
                    path_absolute: "http://localhost:8000/",
                    plugins: [
                        'autoresize', 'code', 'codesample', 'emoticons', 'hr', 'image', 'imagetools', 'insertdatetime', 'link', 'lists', 'media', 'preview', 'print', 'table'
                    ],
                    toolbar: 'undo redo print | styleselect | fontselect | fontsizeselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | link image media | bullist numlist outdent indent',
                    relative_urls: false,
                    file_picker_callback: function (callback, value, meta) {
                        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                        let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                        let type = 'image' === meta.filetype ? 'Images' : 'Files',
                            url  = this.editor_config.path_absolute + 'laravel-filemanager?editor=tinymce5&type=' + type;

                        tinymce.activeEditor.windowManager.openUrl({
                            url : url,
                            title : 'Filemanager',
                            width : x * 0.8,
                            height : y * 0.8,
                            onMessage: (api, message) => {
                                callback(message.content);
                            }
                        });
                    }.bind(this)
                },
                bio: new Form({
                    bio: '',
                }),
                account: new Form({
                    old_password: '',
                    new_password: '',
                    password_confirmation: '',
                }),
                profile: new Form({
                    birth_date: '',
                    gender: '',
                    mobile_number: '',
                    blood_group: '',
                }),
                university: new Form({
                    student_id: '',
                    department: '',
                    ongoing_degree: '',
                    session: '',
                    alloted_hall: '',
                }),
                id: '',
                name: '',
                email: '',
                username: '',
                profile_picture_url: '',
                is_teacher: false,
            }
        },
        methods: {
            decorateUser(userId) {
                axios.get('/api/users/' + userId + '/complete').then((response) => {
                    this.id = response.data.id;
                    this.name = response.data.name;
                    this.username = response.data.username;
                    this.email = response.data.email;
                    if (response.data.birth_date) {
                        this.profile.birth_date = response.data.birth_date;
                        $("#birth_date_picker").datetimepicker("defaultDate", moment(this.profile.birth_date).format("YYYY-MM-DD"));
                    }
                    if (response.data.gender) this.profile.gender = response.data.gender;
                    if (response.data.mobile_number) this.profile.mobile_number = response.data.mobile_number;
                    if (response.data.blood_group) this.profile.blood_group = response.data.blood_group;
                    if (response.data.bio) this.bio.bio = response.data.bio;
                    if (response.data.profile_picture_url) this.profile_picture_url = response.data.profile_picture_url;
                    else this.profile_picture_url = "/photos/shares/profile.png";
                    if (response.data.is_teacher) this.is_teacher = response.data.is_teacher;
                    if (response.data.student_id) this.university.student_id = response.data.student_id;
                    if (response.data.department) this.university.department = response.data.department;
                    if (response.data.ongoing_degree) this.university.ongoing_degree = response.data.ongoing_degree;
                    if (response.data.session) this.university.session = response.data.session;
                    if (response.data.alloted_hall) this.university.alloted_hall = response.data.alloted_hall;
                });
            },
            uploadProfilePhoto(e) {
                const file = e.target.files[0];

                this.profile_picture.file = file;
                
                this.$Progress.start();

                this.profile_picture.submit('post', '/api/user/upload', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }],

                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                }).catch(() => {
                    this.$Progress.fail();
                });
            },
            updateBio() {
                this.$Progress.start();

                this.bio.post('/api/user/bio',  {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'Updated bio!',
                        'You bio has been successfully updated!',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                }).catch(() => {
                    this.$Progress.fail();
                });
            },
            updateAccountInfo() {
                this.$Progress.start();

                this.account.post('/api/user/change_password',  {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'Updated password successfully!',
                        'You password has been successfully updated!',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                }).catch(() => {
                    this.$Progress.fail();
                });
            },
            updateProfileInfo() {
                this.$Progress.start();

                this.profile.post('/api/user/change_profile',  {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'Updated profile information successfully!',
                        'You profile information has been successfully updated!',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                }).catch(() => {
                    this.$Progress.fail();
                });
            },
            updateUniversityProfileInfo() {
                this.$Progress.start();

                this.university.post('/api/user/change_university_profile',  {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'Updated university information successfully!',
                        'You university profile information has been successfully updated!',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                }).catch(() => {
                    this.$Progress.fail();
                });
            }
        }
    }
</script>

<style scoped>
    .emp-profile{
        padding: 3%;
        margin-top: 3%;
        margin-bottom: 3%;
        border-radius: 0.5rem;
        background: #fff;
    }
    .profile-img{
        text-align: center;
    }
    .profile-img img {
        width: 70%;
        height: auto;
    }
    .profile-img .file {
        position: relative;
        overflow: hidden;
        margin-top: 10px;
        width: 100%;
        border: none;
        border-radius: 0;
        font-size: 15px;
        background: #0062cc;
    }
    .profile-img .file input {
        position: absolute;
        opacity: 0;
        right: 0;
        top: 0;
    }
    .profile-head h5{
        color: #333;
    }
    .profile-head h6{
        color: #0062cc;
    }
    .nav-tabs{
        margin-bottom:5%;
    }
    .nav-tabs .nav-link{
        font-weight:600;
        border: none;
    }
    .nav-tabs .nav-link.active{
        border: none;
        border-bottom:2px solid #0062cc;
    }
    .profile-work{
        padding: 14%;
        margin-top: -15%;
    }
    .profile-work p{
        font-size: 12px;
        color: #818182;
        font-weight: 600;
        margin-top: 10%;
    }
    .profile-work a{
        text-decoration: none;
        color: #495057;
        font-weight: 600;
        font-size: 14px;
    }
    .profile-work ul{
        list-style: none;
    }
    .profile-tab label{
        font-weight: 600;
    }
    .profile-tab p{
        font-weight: 600;
        color: #0062cc;
    }
</style>
