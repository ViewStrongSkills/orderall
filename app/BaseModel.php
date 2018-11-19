<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class BaseModel extends Model
{
  public function fileAttach($name, $attributes, $default=null)
  {

    if (!isset($attributes[$name]) || !is_uploaded_file($attributes[$name]))
      return false;

    // Check if old file exists
    $old = $this->{$name};
    // If exists - delete old file
    if ($old !=) {

    }
    if(Storage::exists($this->filesPath . '/' . $old)){
      Storage::delete($this->filesPath . '/' . $old);
    }

    $file = $attributes[$name];
    $file->store($this->filesPath);

    $this->{$name} = $file->hashName();
    $this->save();

  }
}
