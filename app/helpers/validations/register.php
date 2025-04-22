<?php

function validateRegistration($data, $userModel)
{
    $errors = [];

    // Username validation
    if (empty($data['username'])) {
        $errors['username'] = 'Username is required.';
    }

    // Email validation
    if (empty($data['email'])) {
        $errors['email'] = 'Email is required.';
    } elseif ($userModel->findUserByEmail($data['email'])) {
        $errors['email'] = 'Email is already registered.';
    }

    // Password validation
    if (empty($data['password'])) {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($data['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    } elseif (!preg_match('/[a-z]/', $data['password'])) {
        $errors['password'] = 'Password must include at least one lowercase letter.';
    } elseif (!preg_match('/[A-Z]/', $data['password'])) {
        $errors['password'] = 'Password must include at least one uppercase letter.';
    } elseif (!preg_match('/\d/', $data['password'])) {
        $errors['password'] = 'Password must include at least one number.';
    }

    // Confirm password
    if ($data['confirm_password'] !== $data['password']) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    return $errors;
}