<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarouselRequest;
use App\Http\Requests\UpdateCarouselRequest;
use App\Models\Carousel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CarouselController extends Controller
{
    public function index(): Factory|View|Application
    {
        $carousels = Carousel::orderBy('created_at', 'desc')->paginate(8);
        return view('admin.carousel.index', [
            'carousels' => $carousels
        ]);
    }

    public function store(CarouselRequest $request): RedirectResponse
    {
        if (Auth::check() && $request->hasFile('image')) {
            $newCaro = new Carousel;
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $path = public_path('storage/carousels/' . $imageName);
            Image::make($request->image->getRealPath())->crop(1200, 300)->save($path);
            $newCaro->user_id = Auth::id();
            $newCaro->name = $request->name;
            $newCaro->link_path = $request->link_path;
            $newCaro->image_path = $imageName;
            $newCaro->save();
            return back()->with("success", "Carousel berhasil ditambahkan");
        }
        return back()->with('error', 'Carousel gagal di simpan.');
    }

    public function updateCateProd(UpdateCarouselRequest $request, $id): RedirectResponse
    {
        $carousel = Carousel::find($id);
        if (!$carousel) {
            return redirect()->back()->with('error', 'Carousel tidak ditemukan.');
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('storage/carousel/'.$name);
            Image::make($image->getRealPath())->resize(350, 350)->save($path);
            if ($carousel->image_path) {
                Storage::delete('public/carousel/'.$carousel->image_path);
            }
            $carousel->image_path = $name;
        }
        $carousel->name = $request->name;
        $carousel->save();
        return back()->with("success", "Karousel berhasil diubah.");
    }

    public function destroy($id): RedirectResponse
    {
        $carousel = Carousel::find($id);
        if ($carousel)
        {
            $path = public_path('storage/carousel/'.$carousel->image_path);
            if (file_exists($path)) {
                unlink($path);
            }
            $carousel->delete();
            return back()->with('success', 'Carousel berhasil dihapus.');
        }
        return back()->with('error', 'Carousel tidak ditemukan.');
    }

}
