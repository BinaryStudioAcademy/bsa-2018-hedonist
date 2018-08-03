<?php

namespace Hedonist\Repositories\User;


use Hedonist\Entities\User;
use Hedonist\Exceptions\Auth\EmailAlreadyExistsException;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    private $prettusRepository;

    public function __construct(BaseUserRepository $repository)
    {
        $this->prettusRepository = $repository;
    }

    public function getById(int $id): User
    {
        return $this->prettusRepository->find($id);
    }

    public function findAll(): Collection
    {
        return $this->prettusRepository->all();
    }


    public function save(User $user): User
    {
        if($user->id === null){
            if($this->getByEmail($user->email) !== null) {
                throw new EmailAlreadyExistsException();
            }
            return $this->prettusRepository->create($user->toArray());
        } else {
            return $this->prettusRepository->update($user->toArray(),$user->id);
        }
    }


    public function getByEmail(string $email): User
    {
       return $this->prettusRepository->findWhere(["email"=>$email]);
    }
}