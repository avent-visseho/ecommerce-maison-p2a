<?php

return [
    // Login
    'login' => [
        'title' => 'Welcome Back!',
        'subtitle' => 'Sign in to your account to continue',
        'email' => 'Email Address',
        'email_placeholder' => 'example@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'remember_me' => 'Remember me',
        'forgot_password' => 'Forgot password?',
        'login_button' => 'Sign in',
        'no_account' => 'Don\'t have an account?',
        'create_account' => 'Create account',
        'back_to_home' => 'Back to home',
    ],

    // Register
    'register' => [
        'title' => 'Create an Account',
        'subtitle' => 'Join La Maison P2A and start decorating',
        'name' => 'Full Name',
        'name_placeholder' => 'John Doe',
        'email' => 'Email Address',
        'email_placeholder' => 'example@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'password_min' => 'Minimum 8 characters',
        'password_confirmation' => 'Confirm Password',
        'terms_prefix' => 'I accept the',
        'terms_link' => 'terms of service',
        'terms_and' => 'and',
        'privacy_link' => 'privacy policy',
        'register_button' => 'Create my account',
        'have_account' => 'Already have an account?',
        'login_link' => 'Sign in',
        'back_to_home' => 'Back to home',
    ],

    // Forgot Password
    'forgot_password' => [
        'description' => 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
        'email' => 'Email',
        'send_link' => 'Email Password Reset Link',
    ],

    // Reset Password
    'reset_password' => [
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'reset_button' => 'Reset Password',
    ],

    // Confirm Password
    'confirm_password' => [
        'description' => 'This is a secure area of the application. Please confirm your password before continuing.',
        'password' => 'Password',
        'confirm_button' => 'Confirm',
    ],

    // Verify Email
    'verify_email' => [
        'description' => 'Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.',
        'link_sent' => 'A new verification link has been sent to the email address you provided during registration.',
        'resend_button' => 'Resend Verification Email',
        'logout_button' => 'Log Out',
    ],

    // Common
    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
];
