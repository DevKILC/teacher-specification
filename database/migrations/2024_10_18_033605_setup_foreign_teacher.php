<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Drop server if exists
        DB::statement("DROP SERVER IF EXISTS kimo CASCADE;");
        DB::statement("CREATE EXTENSION IF NOT EXISTS mysql_fdw;
");
        // Create a new foreign server
        DB::statement("
            CREATE SERVER kimo
            FOREIGN DATA WRAPPER mysql_fdw
            OPTIONS (host '109.123.234.160', port '2080');
        ");

        // Create user mapping for the current user
        DB::statement("
            CREATE USER MAPPING FOR CURRENT_USER
            SERVER kimo
            OPTIONS (username 'root', password 'lcbisa88');
        ");

        // Drop the foreign table if it exists
        DB::statement("DROP FOREIGN TABLE IF EXISTS teachers;");

        // Create the foreign table 'teachers' linked to MySQL table 'officers_view'
        DB::statement("
            CREATE FOREIGN TABLE IF NOT EXISTS teachers (
                id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                officer_id INTEGER NOT NULL,
                user_uid VARCHAR NOT NULL,
                name VARCHAR,
                email VARCHAR,
                username VARCHAR,
                img_url TEXT,
                phone VARCHAR,
                address VARCHAR,
                nip CHAR(25)
            )
            SERVER kimo
            OPTIONS (dbname 'UserDB_KIMO', table_name 'officers_view');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Drop the foreign table if exists
        DB::statement("DROP FOREIGN TABLE IF EXISTS teachers;");
        
        // Drop the foreign server if exists
        DB::statement("DROP SERVER IF EXISTS kimo CASCADE;");
    }
};
// php artisan migrate --path=/database/migrations/setup_foreign_teacher

