<template>
    <!-- Begin Page Content -->
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img class="img-thumbnail" :src="profile_picture_url" alt="User profile picture"/>
                    </div>
                    <div class="mt-2">
                        <h3 v-if="is_verified" class="text-primary text-center mb-2">Verified</h3>
                        <button type="button" v-else-if="self_id != id" @click="verify" class="btn btn-primary btn-sm btn-block mb-2">Verify</button>
                        <button type="button" v-if="is_blocked && self_id != id" @click="unblock" class="btn btn-success btn-sm btn-block">Unblock</button>
                        <button type="button" v-else-if="self_id != id" @click="block" class="btn btn-danger btn-sm btn-block">Block</button>
                        <button type="button" v-if="self_id != id && !is_teacher" @click="teacherFromStudent" class="btn btn-primary btn-sm btn-block">Make him teacher</button>
                        <button type="button" v-if="self_id != id && is_teacher" @click="studentFromTeacher" class="btn btn-primary btn-sm btn-block">Make him student</button>
                        <router-link v-if="self_id == id" class="btn btn-info btn-sm btn-block" :to="'/admin/user/settings'">Edit</router-link>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="profile-head">
                        <h5>
                            {{ name }}
                        </h5>
                        <div v-html="bio"></div>
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
                        <li class="nav-item">
                            <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">Timeline</a>
                        </li>
                    </ul>
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>User Id</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ id }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Name</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>User Name</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ username }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Verified</label>
                                </div>
                                <div class="col-md-8">
                                    <p v-if="is_verified">Verified</p>
                                    <p v-else>Not verified yet!</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Admin</label>
                                </div>
                                <div class="col-md-8">
                                    <p v-if="is_admin">Admin</p>
                                    <p v-else>Not Admin!</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Blocked</label>
                                </div>
                                <div class="col-md-8">
                                    <p v-if="is_blocked">Blocked</p>
                                    <p v-else>Not blocked!</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Date of Birth</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ birth_date }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Gender</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ gender }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Mobile Number</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ mobile_number }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Blood Group</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ blood_group }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Contribution Point</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ contribution_point }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="university" role="tabpanel" aria-labelledby="university-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Role</label>
                                </div>
                                <div class="col-md-8">
                                    <p v-if="is_teacher">Teacher</p>
                                    <p v-else>Student</p>
                                </div>
                            </div>
                            <div v-if="!is_teacher" class="row">
                                <div class="col-md-4">
                                    <label>Student ID</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ student_id }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Department</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ department }}</p>
                                </div>
                            </div>
                            <div v-if="!is_teacher" class="row">
                                <div class="col-md-4">
                                    <label>Ongoing Degree</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ ongoing_degree }}</p>
                                </div>
                            </div>
                            <div v-if="!is_teacher" class="row">
                                <div class="col-md-4">
                                    <label>Session</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ session }}</p>
                                </div>
                            </div>
                            <div v-if="!is_teacher" class="row">
                                <div class="col-md-4">
                                    <label>Alloted Hall</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ alloted_hall }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <div v-if="posts.length <= 0" class="row">
                                <div class="col-md-12">
                                    <p class="text-center">No posts yet!</p>
                                </div>
                            </div>
                            <div v-else>
                                <div v-for="post in posts.data" :key="post.id" class="row mb-5">
                                    <router-link :to="'/admin/posts/view/' + post.id" style="text-decoration: none;">
                                        <div class="col-md-12">
                                            <h3 class="post-title">{{ post.title }}</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <h5 class="post-subtitle">{{ post.subtitle }}</h5>
                                        </div>
                                    </router-link>
                                </div>
                                <pagination :data="posts" @pagination-change-page="getResults"></pagination>
                            </div>
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
            this.initialize();
        },
        watch: {
            '$route': 'initialize'
        },
        data () {
            return {
                param: undefined,
                id: '',
                name: '',
                username: '',
                is_verified: false,
                is_admin: false,
                is_blocked: false,
                email: '',
                birth_date: '',
                gender: '',
                mobile_number: '',
                blood_group: '',
                bio: '',
                profile_picture_url: '',
                contribution_point: 0,
                is_teacher: false,
                student_id: '',
                department: '',
                ongoing_degree: '',
                session: '',
                alloted_hall: '',
                self_id: '',
                posts: {},
            }
        },
        methods: {
            initialize() {
                this.param = this.$route.params.userId;
                if (this.param != undefined) {
                    let userId = this.param;
                    this.decorateUser(userId);
                    this.getResults();
                }
            },
            decorateUser(userId) {
                axios.get('/api/users/' + userId + '/complete').then((response) => {
                    this.id = response.data.id;
                    this.name = response.data.name;
                    this.username = response.data.username;
                    this.is_verified = response.data.is_verified;
                    this.is_admin = response.data.is_admin;
                    this.is_blocked = response.data.is_blocked;
                    this.email = response.data.email;
                    if (response.data.birth_date) this.birth_date = moment(response.data.birth_date).format("DD MMMM, YYYY");
                    else this.birth_date = "No Birth date inserted";
                    if (response.data.gender) this.gender = response.data.gender;
                    else this.gender = "No gender specified";
                    if (response.data.mobile_number) this.mobile_number = response.data.mobile_number;
                    else this.mobile_number = "No mobile number specified";
                    if (response.data.blood_group) this.blood_group = response.data.blood_group;
                    else this.blood_group = "No blood group mentioned";
                    if (response.data.bio) this.bio = response.data.bio;
                    else this.bio = "No bio";
                    if (response.data.profile_picture_url) this.profile_picture_url = response.data.profile_picture_url;
                    else this.profile_picture_url = "/photos/shares/profile.png";
                    if (response.data.contribution_point) this.contribution_point = response.data.contribution_point;
                    this.is_teacher = response.data.is_teacher;
                    if (response.data.student_id) this.student_id = response.data.student_id;
                    else this.student_id = "No student ID given";
                    if (response.data.department) this.department = response.data.department;
                    else this.department = "No department included";
                    if (response.data.ongoing_degree) this.ongoing_degree = response.data.ongoing_degree;
                    else this.ongoing_degree = "No ongoing degree mentioned";
                    if (response.data.session) this.session = response.data.session;
                    else this.session = "No session mentioned";
                    if (response.data.alloted_hall) this.alloted_hall = response.data.alloted_hall;
                    else this.alloted_hall = "No hall information mentioned";
                });

                axios.get('/api/user').then((response) => {
                    this.self_id = response.data.id;
                });
            },
            getResults(page = 1) {
                axios.get('/api/users/' + this.param + '/posts?page=' + page).then(response => {
                    this.posts = response.data;
                });
            },
            verify() {
                this.$Progress.start();

                axios.put('/api/users/verify/' + this.id, null, {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'User has been verified!',
                        'This user has been successfully verified',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                    this.getResults();
                }).catch(() => {
                    this.$Progress.fail();
                });
            },
            unblock() {
                this.$Progress.start();

                axios.put('/api/users/unblock/' + this.id, null, {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'User has been unblocked!',
                        'This user has been successfully unblocked',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                    this.getResults();
                }).catch(() => {
                    this.$Progress.fail();
                });
            },
            block() {
                this.$Progress.start();

                axios.put('/api/users/block/' + this.id, null, {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'User has been blocked!',
                        'This user has been successfully blocked',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                    this.getResults();
                }).catch(() => {
                    this.$Progress.fail();
                });
            },
            studentFromTeacher() {
                this.$Progress.start();

                axios.put('/api/users/' + this.id + '/sft', null, {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'User has been recognized as a student!',
                        'This user is a student',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                    this.getResults();
                }).catch(() => {
                    this.$Progress.fail();
                });
            },
            teacherFromStudent() {
                this.$Progress.start();

                axios.put('/api/users/' + this.id + '/tfs', null, {
                    onUploadProgress: e => {
                        let num = e.loaded / e.total;
                        this.$Progress.set(num);
                    }
                }).then(() => {
                    swal.fire(
                        'User has been recognized as a professor or lecturer!',
                        'This user is a professor or lecturer',
                        'success'
                    );
                    this.$Progress.finish();
                    this.decorateUser(this.id);
                    this.getResults();
                }).catch(() => {
                    this.$Progress.fail();
                });
            }
        }
    }
</script>

<style>
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
        width: 50%;
        height: auto;
    }
    .profile-head h5{
        color: #333;
    }
    .profile-head h6{
        color: #0062cc;
    }
    .post-title {
        color: #333;
    }
    .post-subtitle {
        color: #0062cc;
    }
    .nav-tabs{
        padding-top: 20px;
        margin-bottom: 5%;
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
