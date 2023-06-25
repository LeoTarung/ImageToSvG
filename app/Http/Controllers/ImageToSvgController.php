<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class ImageToSvgController extends Controller
{
    public function convertToSvg()
    {
        // Load the image file
        // $image = Image::make(public_path('Cover L K1AA_a.png'));
        // $image =  Image::make(public_path('Cover L K1AA_a.png'));
        $image = public_path('Cover L K1AA_a.png');

        // Resize the image to the desired dimensions
        // $image->resize(300, 200);

        // // Divide the image into six parts of 100x100 size
        // $paths = [];
        // for ($i = 0; $i < 6; $i++) {
        //     $x = ($i % 3) * 100;
        //     $y = floor($i / 3) * 100;
        //     $crop = $image->crop(100, 100, $x, $y);
        //     $paths[] = $crop->getEncoded('svg');
        // }

        // Return the view with the SVG paths
        return view('svg', ['paths' => $image]);
    }

    public function generateSvg()
    {
        // Define the colors for each path
        $colors = [
            '#ff0000',
            '#00ff00',
            '#0000ff',
            '#ffff00',
            '#00ffff',
            '#ff00ff',
        ];

        // Create a new SVG image
        $svg = Image::canvas(300, 200, '#ffffff');

        // Generate the paths and add them to the SVG image
        for ($i = 0; $i < 6; $i++) {
            $path = Image::canvas(100, 100, $colors[$i]);
            $svg->insert($path, 'top-left', 100 * ($i % 3), 100 * floor($i / 3));
        }

        // Set the content type header to "image/svg+xml" and return the SVG image
        return response($svg->encode('svg'), 200)->header('Content-Type', 'image/svg+xml');
    }
}
