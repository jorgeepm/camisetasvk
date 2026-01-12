<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Product extends Model {

        use HasFactory;
// Un producto PERTENECE A una categoría
        public function category()
        {
            return $this->belongsTo(Category::class);
        }

        public function scopeLeague($query, $league)
        {
            if ($league) {
                return $query->where('league', $league);
            }
        }

        public function scopeTeam($query, $team)
        {
            if ($team) {
                return $query->where('name', 'LIKE', "%$team%");
            }
        }
}
