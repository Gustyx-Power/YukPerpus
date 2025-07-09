<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filament\Tables\QueryBuilders\GitHubContributorsEloquentBuilder;

class GitHubContributor extends Model
{
    protected $guarded = [];

    public function newEloquentBuilder($query)
    {
        return new GitHubContributorsEloquentBuilder($query);
    }

    public function getTable()
    {
        return ''; // No actual table
    }
}
