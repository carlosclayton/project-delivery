<?php

namespace Delivery\Http\Controllers;

use Delivery\Repositories\CategoryRepository;
use Illuminate\Http\Request;

use Delivery\Http\Requests;

class CategoriesController extends Controller
{
    public function index(CategoryRepository $repository){
        $categories = $repository->paginate(3);
        return view('admin.categories.index', compact('categories'));
    }
}
