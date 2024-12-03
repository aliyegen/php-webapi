<?php

namespace Webapi\Services;

class UserService {
    public function getAll(): array {
        $users = $GLOBALS["users"];
        return $users;
    }

    public function createUser(array $body): array {
        $name = $body["name"];
        $newUser = [
            "id" => rand(),
            "name" => $name
        ];

        $users = $GLOBALS["users"];
        $users[] = $newUser;


        return $newUser;
    }

    public function getUserById(int $id): array {
        $users = $GLOBALS["users"];
        $user = array();
        foreach ($users as $key => $val) {
        
            if ($val['id'] == $id) {
                $user = $val;
                break;
            }
        }
        
        return $user;

    }
}

?>