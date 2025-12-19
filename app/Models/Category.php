<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    use HasFactory;
    protected $table = 'tb_category';
    protected $primaryKey = 'id_category';
    public $timestamps = true;

    protected $fillable = [
        'code_category',
        'name_category',
        'slug_category',
        'status_category',
        'parent_id',
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id_category');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id_category');
    }
}
