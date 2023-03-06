<?php


namespace App\View\Composers;

use App\Models\ProductCategory;
use Illuminate\View\View;

class NavbarComposer
{
    public function compose(View $view)
    {
        $productCategories = ProductCategory::all();
        $view->with('productCategories', $productCategories);
    }
}
