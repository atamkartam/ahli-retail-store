<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Product;
use App\Models\Cms\Banner;
use App\Models\Cms\Testimonial;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $bestSellerProducts = Product::where('is_displayed', true)
                                     ->where('promo_label', 'Bestseller')
                                     ->latest()
                                     ->take(4)
                                     ->get();

        $flashSaleProducts = Product::where('is_displayed', true)
                                    ->where('promo_label', 'Flash Sale')
                                    ->take(2)
                                    ->get();

        $banner = Banner::where('is_active', true)
                        ->latest('updated_at')
                        ->first();

        // Ambil data testimoni dari database
        $testimonials = Testimonial::latest()
                           ->paginate(4); // Menggunakan paginate untuk menampilkan 4 per halaman

        // Menghitung rata-rata rating dan total ulasan
        $totalReviews = Testimonial::count();
        $averageRating = Testimonial::avg('rating');

        return view('front.home.index', compact(
            'bestSellerProducts',
            'flashSaleProducts',
            'banner',
            'testimonials',
            'totalReviews',
            'averageRating'
        ));
    }
}
