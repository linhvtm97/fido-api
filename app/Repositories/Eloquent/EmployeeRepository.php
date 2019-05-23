<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Models\Employee;
use App\Http\Resources\EmployeeCollection;
use App\User;
use Validator;
use App\Library\MyFunctions;
use App\Http\Resources\EmployeeResource;
use \Exception;

class EmployeeRepository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Get all instances of model
    public function all()
    {
        return new EmployeeCollection($this->model->with('address')->orderBy('id', 'asc')->get());
    }

    // Get all instances of model with pagination
    public function paginate($perPage = 10)
    {
        return new EmployeeCollection($this->model->with('address')->orderBy('id', 'asc')->paginate($perPage));
    }

    // create a new record in the database
    public function create(array $data)
    {
        $validator = Validator::make($data, Employee::$ruleEmployee, Employee::$messageEmployee);
        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            throw new \Exception(json_encode($message), 422);
        }
        $employee = $this->model->create($data);

        if ($employee) {
            User::create([
                'user_status' => 'actived',
                'name' => $employee->name,
                'email' => $employee->email,
                'usable_id' => $employee->id,
                'usable_type' => 'App\\Employee',
                'password' => 'default123'
            ]);
            if (array_key_exists('avatar', $data)) {
                $imageURL = MyFunctions::upload_img($data['avatar']);
                $employee->avatar = $imageURL;
            }
            $employee->employee_no = 'NV' . $employee->id;
            $employee->save();
        }

        return true;
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $employee = $this->model->findOrFail($id);
        if ($employee) {
            $employee->update($data);
            if (array_key_exists('avatar', $data)) {
                $imageURL = MyFunctions::upload_img($data['avatar']);
                $employee->avatar = $imageURL;
                $employee->save();
            }
        }
        return true;
    }

    // remove record from the database
    public function delete($id)
    {
        $employee = $this->model::findOrFail($id);
        $user = User::where([
            ['usable_id', '=', $id],
            ['usable_type', '=', 'App\\Employee']
        ])->firstOrFail();
        $employee->delete();
        $user->delete();
        return true;
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Find in model instance with val
    public function findBy($field, $value)
    {
        return $this->model->where($field, '=', $value)->get();
    }

    // Eager load database relationships
    public function with(array $relations)
    {
        return $this->model->with($relations);
    }
}
