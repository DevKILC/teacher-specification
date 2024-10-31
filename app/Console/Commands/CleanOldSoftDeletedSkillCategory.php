<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CleanOldSoftDeletedSkillCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-old-soft-deleted-skill-category';

    /**
     * The console command description.
     *
     * @var string
     */
  protected $description = 'Permanently delete soft-deleted records in skills and categories older than 7 days';

  public function __construct()
  {
      parent::__construct();
  }

  public function handle()
  {
      // Set the number of days before deleting the soft-deleted records
      $daysBeforeDeletion = 7;
      
      // Get the date threshold
      $thresholdDate = Carbon::now()->subDays($daysBeforeDeletion);

      // Delete old soft-deleted records in the skills table
      $skillsDeleted = Skill::onlyTrashed()
          ->where('deleted_at', '<=', $thresholdDate)
          ->forceDelete();

      // Delete old soft-deleted records in the categories table
      $categoriesDeleted = Category::onlyTrashed()
          ->where('deleted_at', '<=', $thresholdDate)
          ->forceDelete();

      // Output success message
      $this->info("Old soft-deleted records cleaned: {$skillsDeleted} skills and {$categoriesDeleted} categories.");
  }
}
