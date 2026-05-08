<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->with('product')->get();
        return view('pages.wishlist', compact('wishlist'));
    }

    public function toggle($id)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->where('product_id', $id)->first();
        
        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist']);
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $id
            ]);
            return response()->json(['status' => 'added', 'message' => 'Added to wishlist']);
        }
    }
}
