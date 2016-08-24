<?php

namespace Delivery\Http\Controllers;


use Delivery\Http\Requests\AdminCategoryRequest;
use Delivery\Http\Requests\AdminProductRequest;
use Delivery\Repositories\CategoryRepository;
use Delivery\Repositories\ProductRepository;

class ProductsController extends Controller
{
    private $repository;
    private $catrepository;

    public function __construct(ProductRepository $repository, CategoryRepository $catrepository){
        $this->repository = $repository;
        $this->catrepository = $catrepository;
    }

    public function index(){
        $prods = $this->repository->paginate(10);
        return view('admin.products.index', compact('prods'));
    }

    public function create(){
        $cats    =   $this->catrepository->lists('name', 'id');
        return view('admin.products.create', compact('cats'));
    }

    public function edit($id){
        $prod    =   $this->repository->find($id);
        $cats    =   $this->catrepository->lists('name', 'id');

        return view('admin.products.edit', compact('prod', 'cats'));
    }


    public function store(AdminProductRequest $request){
        //dd($request->all());

        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('index');

    }

    public function update(AdminProductRequest $request, $id){
        //dd($request->all());

        $data = $request->all();
        $this->repository->update($data, $id);
        return redirect()->route('index');

    }

    public function destroy($id){
        $this->repository->delete($id);
        return redirect()->route('index');

    }

}
