<?php
namespace App\Services;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;
class ClienteService {
    public function __construct(private ClienteRepository $repository){}
    public function getAll(){return $this->repository->all();}
    public function getById(int $id):Cliente{return $this->repository->findOrFail($id);}
    public function create(array $data):Cliente{return $this->repository->create($data);}
    public function update(Cliente $cliente,array $data):Cliente{return $this->repository->update($cliente,$data);}
    public function delete(Cliente $cliente):bool{return $this->repository->delete($cliente);}
}
