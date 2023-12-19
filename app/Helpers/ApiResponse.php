<?php

namespace App\Helpers;
use App\Exceptions\SingleException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ApiResponse
{
  private static function send($data, $http_status = 200)
    {
        $response = CaseConvert::camel($data);

        return response()->json($response, $http_status);
    }

  public static function success($value = null)
  {
      $response = [];
      $response['message'] = 'Request was successful';
      $response['errors'] = null;
      if (!is_null($value)) {
          if (is_array($value)) {
              $response['data'] = $value;
          } elseif (is_object($value)) {
              $response['data'] = $value;
          } else {
              $response['data'] = $value;
          }
      }

      return self::send($response);
  }

  public static function failed($error = null)
  {
      if (env('APP_ENV', 'local') != 'production') {
          Log::debug($error);
      }
      $response = [];
      $response['data'] = null;
      $response['message'] = null;
      $response['errors'] = [];

      $http_status = 500;

      if ($error instanceof ValidationException) {
          $response['message'] = $error->getMessage();
          $response['errors'] = $error->errors();
          $http_status = 400;
        } elseif ($error instanceof SingleException) {
          $response['message'] = $error->getMessage();
          $http_status = 400;
      } elseif ($error instanceof QueryException) {
          $errors = [];
          if (env('APP_ENV', 'local') != 'production') {
              $errors['code'][] = $error->getCode();
              $errors['sql'][] = $error->getSql();
              $errors['bindings'][] = $error->getBindings();
          }
          $response['message'] = $error->getMessage();
          $response['errors'] = $errors;
      } elseif ($error instanceof Exception) {
          if (env('APP_DEBUG') == true) {
              $response['message'] = $error->getMessage();
              $response['errors'] = json_decode(json_encode($error->getTrace()));
          } else {
              $response['message'] = $error->getMessage();
          }
      } else {
          if (is_object($error) || is_array($error)) {
              $response['message'] = json_encode($error);
          } else {
              $response['message'] = $error;
          }
      }

      return self::send($response, $http_status);
  }

  public static function entity($data_type, $data = null, $permissions = null)
  {
      $response = [];
      $response['message'] = 'Request was successful';
      $response['data']['data_type'] = $data_type;
      $response['data']['entities'] = $data;
      $response['errors'] = null;
      $response = json_decode(json_encode($response));

      return self::send($response);
  }

  public static function onlyEntity($data = null, $permissions = null)
  {
      $response = [];
      $response['message'] = 'Request was successful';
      $response['data'] = $data;
      $response['errors'] = null;
      $response = json_decode(json_encode($response));

      return self::send($response);
  }

  public static function unauthorized($message = null)
  {
      $response['message'] = $message ? $message : 'Unauthorized: Access is denied due to invalid credentials.';
      $response['errors'] = null;
      $response['data'] = null;

      return self::send($response, 401);
  }

  public static function forbidden()
  {
      $response['message'] = 'You don\'t have permission to access';
      $response['errors'] = null;
      $response['data'] = null;

      return self::send($response, 403);
  }
}
