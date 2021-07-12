<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class LikeController extends BaseController
{
    public function toggle(Blog $blog)
    {
        $user = auth()->user();
        $que = $blog->likes()->where('user_id', $user->id);

        if ($que->count()) {
            $que->delete();
        } else {
            $blog->likes()->create([
                'user_id' => $user->id
            ]);
        }

        return redirect()->back();
    }
}