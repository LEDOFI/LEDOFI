<?php

function validateUser($user){

    $errors = array();

    if(empty($user['username'])){
        array_push($errors, 'Zadejte vaše uživatelské jméno!');
    }

    if(empty($user['email'])){
        array_push($errors, 'Zadejte váš email!');
    }

    if(empty($user['password'])){
        array_push($errors, 'Zadejte vaše heslo!');
    }

    if($user['passwordConf'] !== $user['password']){
        array_push($errors, 'Hesla se neshodují!');
    }

    $existingUser = selectOne('users', ['email' => $_POST['email']]);
    if(isset($existingUser)){
        array_push($errors, "Uživatel s tímto emailem je již registrován!");
    }

    return $errors;
}

function validateLogin($user){

    $errors = array();

    if(empty($user['username'])){
        array_push($errors, 'Zadejte vaše uživatelské jméno!');
    }

    if(empty($user['password'])){
        array_push($errors, 'Zadejte vaše heslo!');
    }

    return $errors;
}