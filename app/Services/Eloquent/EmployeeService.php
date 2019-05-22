<?php

namespace App\Services\Eloquent;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Services\Interfaces\EmployeeServiceInterface;

class EmployeeService implements EmployeeServiceInterface
{
    protected $employeeRepository;
    /**
     * EmployeeService constructor.
     *
     * @param RepositoryInterface $repositoryInterface
     */
    function __construct(RepositoryInterface $repositoryInterface)
    {
        $this->employeeRepository = $repositoryInterface;
    }

    public function all()
    {
        return $this->employeeRepository->all();
    }


    public function paginate($perPage = 10)
    {
        $employees = $this->employeeRepository->paginate($perPage);
        if (!$employees) {
            return response()->json(['Message' => 'No content'], 202);
        }
        return response()->json(['Message' => 'Success', 'Data' => $employees], 200);
    }

    public function create(array $data)
    {
        return $this->employeeRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->employeeRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->employeeRepository->delete($id);
    }

    public function find($id)
    {
        return $this->employeeRepository->show($id);
    }

    public function findBy($field, $value)
    {
        $employees = $this->employeeRepository->findBy($field, $value);
        if (!$employees) {
            return response()->json(['Message' => 'Not found'], 404);
        }
        return response()->json(['Message' => 'Success', 'Data' => $employees], 200);
    }
}
