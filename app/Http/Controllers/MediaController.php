<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Repositories\ElementRepository;
use App\Jobs\Media\CreateMedia;

use App\Http\Controllers\Controller;
use App\Models\Element;
use Illuminate\Validation\Rules;

class MediaController extends Controller
{

    public function upload( Request $request)
    {
        $data = dispatch_sync(CreateMedia::fromRequest($request));

        return $data ? response()->json([
            'success' => true,
            'url' => $data['url'],
            'filename' =>  $data['filename']
        ]) : response()->json([
            'success' => false,
        ], 500);

    }

  
}
