<?php


function validateLogin($data)
{
    $errors = [];

    // Email validation
    if (empty($data['email'])) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Password validation
    if (empty($data['password'])) {
        $errors['password'] = 'Password is required.';
    }

    return $errors;
}