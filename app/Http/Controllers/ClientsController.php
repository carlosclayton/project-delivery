<?php

namespace Delivery\Http\Controllers;


use Delivery\Http\Requests\AdminClientRequest;
use Delivery\Repositories\ClientRepository;
use Delivery\Services\ClientService;

class ClientsController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ClientRepository $repository, ClientService $service){
        $this->repository = $repository;
        $this->service = $service;
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
        $this->service->create($data);
        return redirect()->route('index');

    }

    public function update(AdminClientRequest $request, $id){
        //dd($request->all());

        $data = $request->all();
        $this->service->update($data, $id);
        return redirect()->route('index');

    }

    public function destroy($id){
        $this->repository->delete($id);
        return redirect()->route('index');

    }

}
