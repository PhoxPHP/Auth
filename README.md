## PhoxPHP Authentication Component

**Features:**

1. Register
2. Login
3. Logout
4. Activate account
5. Block account
6. Delete account
7. Change password

#### Register

To register a user, you use the register method which requires just three parameters. Namely:

1. email
2. password
3. verifyPassword

When registering a user, you can login automatically after registration by setting **auto_login** to _true_ in the configuration settings.

```php
    // calling it as a registered service
    $auth = app()->load('auth');
    
    // registering a user
    $auth->register(
        'example@email.com',
        'password',
        'password'
    );
    
    // If auto_login is not enabled then you can login manually
    $auth->login(
        'example@email.com',
        'password'
    );
```

#### Login

The **login** method is used to log a user in. To redirect automatically after a user has been logged in, you need to set **auto_redirect** to true in the configuration settings.
```php
        // calling it as a registered service
        $auth = app()->load('auth');
        
        // log user in
        $auth->login(
            'example@email.com',
            'password'
        );
```

#### Logout
```php
    $auth = app()->load('auth');
    $auth->logout();
```

#### Activate account
To activate an account, you need to use the **activateAccount**. This method requires just one parameter which  is the user's confirmation_code. By default, a user's account is not activated when registered but you can allow auto activation by setting **auto_activate** to true in the configuration settings.
```php
        
        // calling as registered service
        $auth = app()->load('auth');
        
        $confirmation_code = '********';
        $auth->activateAccount($confirmation_code);
```
#### Block account
To block an account, you need to use **blockAccount** method. This method requires just one parameter which must either be the user's email or the user's id.
```php
        // calling as registered service
        $auth = app()->load('auth');
        
        // Blocking account using email
        $auth->blockAccount(
            'user@email.com'
        );
        
        // Blocking account using id
        $userId = 5;
        $auth->blockAccount($userId);
```
#### Unblock account
To unblock an account, you need to use **unblockAccount** method. This method requires just one parameter which must either be the user's email or the user's id just like the **blockAccount** method.
```php
        // calling as registered service
        $auth = app()->load('auth');
        
        // Blocking account using email
        $auth->unblockAccount(
            'user@email.com'
        );
        
        // Blocking account using id
        $userId = 5;
        $auth->unblockAccount($userId);
```

#### Delete account
To delete an account, use the **deleteAccount** method. It requires a single parameter which must either be the user's email or the user's id.
This method returns _true_ if the account deleted successfully.
```php
        // calling as registered service
        $auth = app()->load('auth');
        
        // Delete account using email
        $auth->deleteAccount(
            'user@email.com'
        );
        
        // Delete account using id
        $userId = 5;
        $auth->deleteAccount($userId);
```

#### Change password
To update a user's password, you can use the **changePassword** method. The method requires two parameters which namely:

1. oldPassword
2. newPassword


The first parameter (oldPaasword) must be the user's current password and the second parameter (newPassword) must be the new password.
This method returns _true_ if the password changed successfully.

```php
        // calling as registered service
        $auth = app()->load('auth');
        
        $oldPassword = 'old-password';
        $newPassword = 'new-password';
        
        $auth->changePassword(
            $oldPassword,
            $newPassword
        );
```