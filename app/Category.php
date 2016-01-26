<?php

namespace App;

use Config;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $guarded = [];

    protected $fillable = ['name', 'image', 'description'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function words()
    {
        return $this->hasMany(Word::class, 'category_id');
    }

    public function getImageAttribute($values)
    {
        return (!empty($values)) ? $values : 'noimage.png';
    }

    public function assign($values)
    {
        if (!is_null($values->input('category_id'))) {
            $this->id = $values->input('category_id');
        }

        $path = config()->get('paths.category_path');
        $this->name = $values->input('category_name');
        $this->description = $values->input('category_desc');
        if (!empty($values->file('category_image'))) {
            $imageName = uniqid() . '.' . $values->file('category_image')->getClientOriginalExtension();
            $this->image = $imageName;
            $values->file('category_image')->move($path, $imageName);
        }
        $this->save();
    }

    public function getCountWords()
    {
        return $this->words()->count();
    }
}
