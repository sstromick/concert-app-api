<?php 

namespace App\Repositories\Utility;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PhotoUrl {
	public function createPhotoUrl($model_name, $url, $id = 0) {
    	$base_url = pathinfo($url, PATHINFO_FILENAME);

        $all_urls = $this->getRelatedPhotoUrls($model_name, $base_url, $id);

        if (!$all_urls->contains('photo_url', $url)){
            return $url;
        }

        for ($i = 1; $i <= 50; $i++) {
			$photo_extension = pathinfo($url, PATHINFO_EXTENSION);
			$new_url = $base_url . '-' . $i . '.' . $photo_extension;

            if (!$all_urls->contains('photo_url', $new_url)) {
                return $new_url;
            }
        }

        throw new HttpException(422, __('apiResponser.create_error', ['object' => 'A unique url']));
    }

    protected function getRelatedPhotoUrls($model_name, $url, $id = 0) {
        return $model_name::where('photo_url', 'like', $url . '%')->select('photo_url')
            ->where('id', '<>', $id)
            ->get();
    }
}
