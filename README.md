<p align="center">
  <img src="https://repository-images.githubusercontent.com/367858748/2dafa900-cf67-11eb-8ff5-e6f4882cef15" width="400">
</p>

## About
PHP-M is an API based micro-framework powered by PHP.

## Serving application
You can serve the application with following command, just head to the root of the project with command line and type:

    php command serve
    
You can provide a custom port to serve on like the following

    php command serve --port=8080
    
## Documentation
### Routing
#### Defining routes
You can chose between three options for defining a route for your application.
#### Via closure

    $route->get('/projects', function () {
      return 'Hello, World !';
    });
    
#### Via string

    $route->get('/projects', 'ProjectController@index');
    
#### Via array

    use App\Controllers\ProjectController;
    
    $route->get('/projects', [ProjectController::class, 'index']);
    
### Middleware
You can implement a middleware to a route like the following.

    $route->get('/project/:projectId', 'ProjectController@show', [
      'checkAvailability'
    ]);

Keep in mind that you need to provide method name that is responsible for your middleware.

### Protecting routes
As I mentioned before, you can provide middleware within an array as the third parameter to the route.

    $route->get('/project/:projectId', 'ProjectController@show', [
      'auth'
    ]);
    
The middleware auth is responsible for protecting routes from unauthenticated requests.
This middleware is powered by JWT, you may checkout Token class under path \Core\Classes\Token for more information about how the middleware works.

### Route params
You may wish to pass your route parameters to your application. You may do so like the following.

    $route->get('/projects/:projectId/logs/:logId', 'ProjectController@index');

Keep in mind that in your controller or closure you'll recieve Request object as your first parameter:

    <?php
    
    namespace App\Controllers;
    
    use Core\Classes\{BaseController, Request};
    
    class ProjectController extends BaseController
    {
      /**
       * Showing project's index page.
       *
       * @param Request $request
       * @param int $projectId
       * @param int $logId
       *
       * @return string
       */
      public function index(Request $request, int $projectId, int $logId): string
      {
        //
      }
    }
    
### Request
Request object contains every parameter passed to application, weather it's from request body or query string, you can access request params like following:

    $request->projectName;
    
### Request validation
You can validate your request and in case of any errors show a proper error message.

    $request->validate([
        'name' => ['required', 'string'],
        'age' => ['required', 'numeric', ['min' => 18]],
        'height' => ['required', 'numeric', ['max' => 190]],
        'email' => ['required', 'email', ['unique' => 'users']],
    ]);

#### Available validation rules
##### Required
The field under this rule is required and must be provided to application.

##### String
The field under this rule must be a valid string.

##### Numeric
The field under this rule must be a valid numeric string.

##### Email
The field under this rule must be a valid email.

##### Maximum
The field under this rule must be less than given parameter.

    $request->validate([
        'height' => ['required', 'numeric', ['max' => 190]],
    ]);

##### Minimum

    $request->validate([
        'age' => ['required', 'numeric', ['min' => 18]],
    ]);
    
##### Unique
The field under this rule must be unique in database.

    $request->validate([
        'email' => ['required', 'email', ['unique' => 'users']],
    ]);
    
In this case application will look throgh users table on database, and checks if column email exists with the same value or not.

### Response
The only available response type is JSON, for the sake of consistent of response properties you may use BaseController's response() method.
This method accepts 3 parameters: Response word, Response data, Response http-code.

    <?php
    
    namespace App\Controllers;
    
    use Core\Classes\{BaseController, Request, Response};
    
    class ProjectController extends BaseController
    {
      /**
       * Showing project's index page.
       *
       * @param Request $request
       * @param int $projectId
       * @param int $logId
       *
       * @return string
       */
      public function index(Request $request, int $projectId, int $logId): string
      {
        $data = "{$projectId} - {$logId}";
        
        return $this->response(
          'Success',
          $data,
          200
        );
      }
    }
    
You may want to checkout Response class, there's plenty of response words and codes there that you can use.

#### Error
In case of possible errors you can also use BaseController's error() method:

    <?php
    
    namespace App\Controllers;
    
    use Exception;
    use Core\Classes\{BaseController, Request, Response};
    
    class ProjectController extends BaseController
    {
      /**
       * Showing project's index page.
       *
       * @param Request $request
       * @param int $projectId
       * @param int $logId
       *
       * @return string
       */
      public function index(Request $request, int $projectId, int $logId): string
      {
        $data = "{$projectId} - {$logId}";
        
        try {
          return $this->response(
            'Success',
            $data,
            200
          );
        } catch (Exception $exception) {
          return $this->error(
            'Error',
            $exception->getMessage(),
            500
          );
        }
      }
    }
    
### ORM
PHP-M Provides some functionalities to interact with database and perform simple CRUD operations.

#### Creating

    Project::create([
      'author' => $request->author,
      'name' => $request->name,
      'type' => $request->type
    ]);
    
#### Finding
You have 2 choices, whether you can find a record with where clause, or you can find the record by their unique id.

##### Where clause

    Project::where([
      'name' => $request->name,
    ])->get();
    
##### Find method
    
    Project::find($id);
    
#### Updating

    $project = Project::find($id);
    
    $project->update([
      'name' => $request->name,
      'type' => $request->type
    ]);
    
#### Deleting

    $project = Project::find($id);
    
    $project->delete();
  
### Command
PHP-M also provides a way to interact with application via command line.

#### Available commands
##### Migrate
This command handles migration operations

For running migrations:

    php command migrate
    
For rolling back migration:

    php command migrate:rollback
    
For reseting all migrations:

    php command migrate:reset
    
For reseting and then running all migrations again:

    php command migrate:fresh
    
##### Make
This command is responsible for creating classes within application to save time.

For creating new controller:

    php command make:controller UserController
    
For creating new model:

    php command make:model User
    
For creating new repository:

    php command make:repository UserRepository
    
For creating new service:

    php command make:service UserCreatingService
    
For creating new migration:

    php command make:migration create_users_table
    
For creating new command:

    php command make:command UserCreatindCommand
    
## License
The PHP-M micro-framework is open-sourced software licensed under the [MIT license](LICENSE).