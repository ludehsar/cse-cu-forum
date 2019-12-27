<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontendPostDataset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
                CREATE VIEW frontend_post_dataset AS
                (
                        SELECT p.id, p.category_id, p.title, p.subtitle, p.slug, p.is_published,
                        p.total_contribution, p.total_love, p.total_wow, p.total_haha, p.total_angry, COUNT(c.id) as total_comments, ca.name as category_name, ca.slug as category_slug,
                        u.name as user_full_name, u.username, u.is_verified as is_verified_user, u.is_blocked as is_blocked_user, u.profile_picture_url as user_profile_picture_url, p.created_at, p.updated_at
                        
                        FROM posts p
                        LEFT JOIN users u ON u.id = p.user_id
                        LEFT JOIN comments c ON p.id = c.post_id
                        LEFT JOIN categories ca ON p.category_id = ca.id
                        
                        WHERE (p.is_published = true AND u.is_verified = true AND u.is_blocked = false)

                        GROUP BY p.id, p.category_id, p.title, p.subtitle, p.slug, p.is_published,
                        p.total_contribution, p.total_love, p.total_wow, p.total_haha, p.total_angry, ca.name, ca.slug,
                        u.name, u.username, u.is_verified, u.is_blocked, u.profile_picture_url, p.created_at, p.updated_at

                        ORDER BY p.id ASC
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
        DB::statement('DROP VIEW `frontend_post_dataset`');
    }
}
