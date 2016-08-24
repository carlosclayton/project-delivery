<?php

namespace Delivery\Http\Controllers;


use Delivery\Http\Requests\AdminCategoryRequest;
use Delivery\Http\Requests\AdminClientRequest;
use Delivery\Http\Requests\AdminProductRequest;
use Delivery\Repositories\CategoryRepository;
use Delivery\Repositories\ClientRepository;
use Delivery\Repositories\ProductRepository;

class ClientsController extends Controller
{
    private $repository;

    public function __construct(ClientRepository $repository){
        $this->repository = $repository;
    }

    public function index(){
        $clients = $this->repository->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    public function create(){
        return view('admin.clients.create');
    }

    public function edit($id){
        $client    =   $this->repository->find($id);

        return view('admin.clients.edit', compact('client'));
    }


    public function store(AdminClientRequest $request){
        //dd($request->all());

        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('index');

    }

    public function update(AdminClientRequest $request, $id){
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
