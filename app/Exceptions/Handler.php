<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponser;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException)
        {
            $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe ninguna instancia de {$model} con el id expecificado", 404);
        }

        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request, $exception);
        }

        if($exception instanceof AuthorizationException){
            return $this->errorResponse("No posee permisos para ejecutar esta acción", 403);
        }

        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse("No se encontró la URL especificada", 404);
        }

        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse("El método especificado en la petición no es válido", 405);
        }

        if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if($exception instanceof QueryException){
            $code = $exception->errorInfo[1];

            if($code){
                return $this->errorResponse("No se puede eliminar de forma permanente el recurso porque está relacionado con algún otro.", 409);
            }
        }

        if(config("app.debug")){
            return parent::render($request, $exception);
        }

        return $this->errorResponse("Falla inseperada. Intente luego", 500);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        /*$errors = $e->validator->errors()->getMessages();

        return $this->errorResponse("Ups! algo salio mal", 422, $errors);*/
        return $this->invalidJson($request, $e);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse($exception->getMessage(), 401);
    }
}
