# Laravel Easy validation
The one step easy validation for laravel will help you to get rid of defining same validation rules for particular modal again and again.

### USE
use below command to get library into your project.
```
composer require ashish/easyvalidation
```

now all you have to do is define your validation rules inside your modal. and inject this package into the modal like this.
```php
<?php
namespace App;
use Ashish\Easyvalidation\Easyvalidate

class User extends Authenticatable
{
    use Easyvalidate;

    /**
     * Rules to be validated.
     *
     * @var array
     */
    protected rules = [
        'email'   => 'required|email|unique:users,email',
        'password'=> 'required',
        'name'    =>'required'
    ];
}
```

now whenever user wants to validate request with user modal. the basic validation call is:
```php
$validator = User::makeValidate($requestData); //this will validate the request with user modal.

if($validator->fails()){
    // unable to validate, perform operations you want.
}
```
there are two more validation parameters:
```php
$validator = Modal::makeValidate(RequestData, Excepts, Patches);
// RequestData: data to be validated.
// Excepts: In case if you have to except 
```
### Explaination:
| Keys  | Use |
| ------------- | ------------- |
| **RequestData**  |  Data to be validated.  |
| **Excepts**  | Rules to except before validation. ie. if we want to except rule `name` from user modal validation we will define them in `Excepts` as an array `['name']`. this will validate request with all other user except `name` rule from our modal.  |
| **Patches**  | In case if you have to modify rule or want to add new rule, you can define Patches. ie. if i want to add another rule for user modal with one more key, `['secred_key'=>'required\|max:25']`. or if i want to modify existing rule `name: ['name'=>'required\|max:250']`.  |

