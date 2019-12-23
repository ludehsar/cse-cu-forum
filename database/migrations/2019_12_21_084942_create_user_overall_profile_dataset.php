<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOverallProfileDataset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
                CREATE VIEW user_overall_profile_dataset AS
                (
                        SELECT u.id, u.name, u.username, u.is_verified, u.is_admin, u.is_blocked, u.email,
                                p.birth_date, p.gender, p.mobile_number, p.blood_group, p.bio, p.profile_picture_url, p.contribution_point,
                                up.is_teacher, up.student_id, up.department, up.ongoing_degree, up.session, up.alloted_hall
                        
                        FROM users u
                        LEFT JOIN profiles p ON u.id = p.user_id
                        LEFT JOIN university_profiles up ON u.id = up.user_id

                        ORDER BY u.id ASC
                )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW `user_overall_profile_dataset`');
    }
}
