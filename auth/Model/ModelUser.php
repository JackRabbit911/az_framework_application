<?php

namespace Auth\Model;

use Auth\User;
use Sys\Model\ModelEntity;
use Sys\Entity\Entity;

final class ModelUser extends ModelEntity
{
    protected string $table = 'users';
    protected string $entityClass = User::class;
    private User $user;

    public function get(?string $column = null, mixed $value = null)
    {
        $table = $this->qb->table($this->table);
        
        if ($column && $value) {
            $table->where($column, $value);
        }

        return $table->get();
    }

    public function isUniqueEmail(string $email): bool
    {
        return ($this->get('email', $email)) ? false : true;
    }

    public function isPairEmailPswd(string $password, string $email): bool
    {
        $user = $this->find($email, 'email');

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $this->user = $user;
            return true;
        } else {
            return false;
        }
    }

    public function isRegisteredEmail(string $email): bool
    {
        $this->user = $this->find($email, 'email');
        return ($this->user) ? true : false;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function create(array $data)
    {
        unset($data['_csrf']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->qb->table($this->table)->insert($data);
    }

    protected function save(Entity|array $user): mixed
    {
        return parent::save($user);
    }
}
