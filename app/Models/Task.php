<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
 use HasFactory;     
 protected $fillable = [
  'title',
  'description',
  'long_description',
  'user_id',
  'image',
  'video', 
 ];

 public function CompletedTask(){
   $this->completed  = !$this->completed;
   $this->save();
 }

 public function user()
 {
     return $this->belongsTo(User::class);
 }

 public function saveImage($imagePath, $videoPath)
{
    if ($imagePath) {
        $this->image = $imagePath;
    }
    if ($videoPath) {
        $this->video = $videoPath; 
    }
    $this->save();
}
public function comments()
{
    return $this->hasMany(Comment::class);
}

}