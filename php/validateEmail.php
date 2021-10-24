<?php
function validate($email)
{
    if (empty($email)) {
        Databases::$errors = "Email address is required";
        return null;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Databases::$errors = "Please provide a valid e-mail address";
        return null;
    } elseif (preg_match('/.co$/', $email)) {
        Databases::$errors = "We are not accepting subscriptions from Colombia emails";
        return null;
    }
    return true;
}
