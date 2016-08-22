<?php

namespace Delivery\Http\Controllers;

use Delivery\Repositories\CategoryRepository;
use Delivery\Http\Requests\AdminCategoryRequest;

class CategoriesController extends Controller
{
    private $repository;

    public function __construct(CategoryRepository $repository){
        $this->repository = $repository;
    }

    public function index(){
        $categories = $this->repository->paginate(3);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function edit($id){
        
        return view('admin.categories.create');
    }

    public function store(AdminCategoryRequest $request){
        //dd($request->all());

        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('index');

    }

}
