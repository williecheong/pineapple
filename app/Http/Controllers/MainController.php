<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MainController extends Controller {
    
    public function main() {
    	$menu = $this->extractLatestMenu();
        return view('landing', 
        	array(
                'menuItem' => $menu['menuItem'],
                'images' => $menu['images'],
                'price' => $menu['price'],
                'title' => $menu['title'],
                'subtitle' => $menu['subtitle'],
                'theme' => $menu['theme'],
        	)
        );
    }

    public function order() {
    	$menu = $this->extractLatestMenu();
        return view('ordering', 
        	array(
        		'menuItem' => $menu['menuItem'],
        		'images' => $menu['images'],
        		'price' => $menu['price'],
        		'title' => $menu['title'],
        		'subtitle' => $menu['subtitle'],
                'theme' => $menu['theme'],
        	)
        );
    }

    private function extractLatestMenu() {
    	$date = intval(date('Ymd', time()));
    	$thisDirectory = '/assets/eat/' . $date;

    	while(file_exists(public_path() . $thisDirectory) == false) {
    		$date = $date - 1;
    		$thisDirectory = '/assets/eat/' . $date;
    	}

		$scanFolder = scandir(public_path() . $thisDirectory . '/img');
		$images = array();
		foreach ($scanFolder as $key => $fileName) {
			if (preg_match('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i', $fileName, $matches)) {
				$images[] = $thisDirectory . '/img/' . $fileName;
			}
		}

		$title = "A food item";
		if (file_exists(public_path() . $thisDirectory . '/title.txt')) {
			$title = file_get_contents(public_path() . $thisDirectory . '/title.txt');
		}

		$subtitle = "Some description for the food";
		if (file_exists(public_path() . $thisDirectory . '/subtitle.txt')) {
			$subtitle = file_get_contents(public_path() . $thisDirectory . '/subtitle.txt');
		}
		
		$price = "10";
		if (file_exists(public_path() . $thisDirectory . '/price.txt')) {
			$price = file_get_contents(public_path() . $thisDirectory . '/price.txt');
		}

        $theme = "white";
        if (file_exists(public_path() . $thisDirectory . '/theme.txt')) {
            $theme = file_get_contents(public_path() . $thisDirectory . '/theme.txt');
        }

		return array(
			'menuItem' => $date,
			'images' => $images,
			'price' => $price,
			'title' => $title,
			'subtitle' => $subtitle,
            'theme' => $theme	
		);
    }

}