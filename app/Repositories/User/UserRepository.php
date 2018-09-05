<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\Taste;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function findAll(): Collection
    {
        return User::all();
    }

    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function getByEmail(string $email): ?User
    {
        return User::where(["email" => $email])->first();
    }

    public function deleteById(int $id): void
    {
        User::destroy($id);
    }

    public function model()
    {
        return User::class;
    }

    public function addTaste(User $user, Taste $taste): void
    {
        $user->tastes()->attach($taste);
    }

    public function deleteTaste(User $user, Taste $taste): void
    {
        $user->tastes()->detach($taste);
    }

    public function setTastes(User $user, Collection $tastes): void
    {
        $user->tastes()->sync($tastes);
    }

    public function getUserBySocialAuthCredentials(string $provider, string $token): ?User
    {
        return User::whereHas(
            'socialAccounts',
            function (Builder $query) use ($provider, $token) {
                $query->where([
                    'provider' => $provider,
                    'provider_user_id' => $token
                ]);
            }
        )->first();
    }

    public function isEmailUnique(string $email): bool
    {
        $user = User::where(["email" => $email])->first();
        return $user ? false : true;
    }

    public function getFollowers(User $user): Collection
    {
        return $user->followers;
    }

    public function getFollowedUsers(User $user): Collection
    {
        return $user->followedUsers;
    }

    public function followUser(User $followed, User $follower): void
    {
        $followed->followers()->attach($follower);
    }

    public function unfollowUser(User $followed, User $follower): void
    {
        $followed->followers()->detach($follower);
    }

    public function findByCriterias(CriteriaInterface ...$criterias): Collection
    {
        foreach ($criterias as $criteria){
            $this->pushCriteria($criteria);
        }
        $result = $this->all();
        $this->resetCriteria();

        return $result;
    }
}