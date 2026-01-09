<?php
// Un producto PERTENECE A una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }