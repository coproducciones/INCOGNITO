<?php
namespace App\Services;
use App\Models\Reseña;
use App\Repositories\ReseñaRepository;
class ReseñaService {
    public function __construct(private ReseñaRepository $repository){}
    public function getAll(){return $this->repository->all();}
    public function getById(int $id):Reseña{return $this->repository->findOrFail($id);}
    public function create(array $data):Reseña{$data['fecha']=$data['fecha']??now();return $this->repository->create($data);}
    public function update(Reseña $reseña,array $data):Reseña{return $this->repository->update($reseña,$data);}
    public function delete(Reseña $reseña):bool{return $this->repository->delete($reseña);}
    public function getByProducto(int $id){return $this->repository->forProducto($id);}
}
