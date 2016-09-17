<?php

namespace Delivery\Http\Controllers;


use Delivery\Http\Requests\AdminCupomRequest;
use Delivery\Repositories\CupomRepository;

class CupomsController extends Controller
{
    private $repository;

    public function __construct(CupomRepository $repository){
        $this->repository = $repository;
    }

    public function index(){
        $cupoms = $this->repository->paginate(3);
        return view('admin.cupoms.index', compact('cupoms'));
    }

    public function create(){
        return view('admin.cupoms.create');
    }

    public function edit($id){
        $cat    =   $this->repository->find($id);

        return view('admin.cupoms.edit', compact('cat'));
    }


    public function store(AdminCupomRequest $request){
        //dd($request->all());

        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('cupoms.index');

    }

    public function update(AdminCupomRequest $request, $id){
        //dd($request->all());

        $data = $request->all();
        $this->repository->update($data, $id);
        return redirect()->route('index');

    }

}
