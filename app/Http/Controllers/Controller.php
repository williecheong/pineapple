<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {
    use DispatchesJobs, ValidatesRequests;

    public function makeError($content="", $status=400) {
		if ( is_string($content) ) {
			$content = array(
				"message" => $content
			);
		} 

		$response = new Response($content, $status);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public function makeSuccess($content="", $status=200) {
		if ( is_string($content) ) {
			$content = array(
				"message" => $content
			);
		}

		$response = new Response($content, $status);
		$response->header('Content-Type', 'application/json');
		return $response;
	}
}
