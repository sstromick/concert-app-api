<?php 

namespace App\Repositories\Photos;

use Intervention\Image\Facades\Image;
use App\Repositories\Utility\PhotoUrl;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PhotoAWS {
	protected $model;
	protected $location;
	protected $model_name;
	protected $attributes;

	public function __construct($model, $attributes) {
		$model_class_name = get_class($model);
		$this->model = $model;
		$this->location = strtolower(class_basename($model_class_name)) . 's';
		$this->model_name = $model_class_name;
		$this->attributes = $attributes;
	}

    public function uploadPhoto($attributes) {
        if ( empty($this->model->photo_url) ) {
            $this->storePhotoToS3();
        } else {
            $photo_deleted = $this->deletePhotoFromS3();
            if ($photo_deleted) $this->storePhotoToS3();
        }
    }

	public function storePhotoToS3() {
		$image = Image::make($this->attributes['photo_url']);
		
        $photo_name = $this->attributes['photo_url']->getClientOriginalName();
        
        $url = new PhotoUrl();

        $photo_name = $url->createPhotoUrl($this->model_name, $photo_name);

        $this->model->photo_url = $photo_name;

        $this->model->save();

        $photo_width = config('image.width'); 
        $photo_height = config('image.height'); 
        $photo_location = $this->location; 
        
        $resource = $image->resize($photo_width, $photo_height)->stream();

        $relative_path = $photo_location . '/' . $photo_name;

        $successful = Storage::disk('s3')->put($relative_path, $resource, 'public');

        if ( ! $successful ) {
        	$this->model->photo_url = null;
        	$this->model->save();
        	throw new HttpException(422, class_basename($this->model_name) . ' photo could not be deleted.');
        }
	}

	public function deletePhotoFromS3() {
		$photo_name = $this->model->photo_url;
        $photo_location = $this->location;  

        $relative_path = $photo_location . '/' . $photo_name;

        $successful = Storage::disk('s3')->delete($relative_path);

        if ( ! $successful ) {
      		throw new HttpException(422, class_basename($this->model_name) . ' photo could not be deleted.');
        } else {
        	$this->model->photo_url = null;
        	$this->model->save();
        }

        return $successful;
	}
}
