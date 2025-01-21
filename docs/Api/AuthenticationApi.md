# OpenAPI\Client\AuthenticationApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**authenticationCreateSession()**](AuthenticationApi.md#authenticationCreateSession) | **POST** /api/v2/CreateSession | /api/v2/CreateSession |
| [**authenticationKillSession()**](AuthenticationApi.md#authenticationKillSession) | **GET** /api/v2/KillSession | /api/v2/KillSession |
| [**authenticationSetLockgroup()**](AuthenticationApi.md#authenticationSetLockgroup) | **POST** /api/v2/SetLockgroup | /api/v2/SetLockgroup |
| [**authenticationTest()**](AuthenticationApi.md#authenticationTest) | **GET** /api/v2/Test | /api/v2/Test |
| [**authenticationVersion()**](AuthenticationApi.md#authenticationVersion) | **GET** /api/v2/Version | /api/v2/Version |


## `authenticationCreateSession()`

```php
authenticationCreateSession($create_session_param): \OpenAPI\Client\Model\CreateSessionResult
```

/api/v2/CreateSession

Creates session. Returns session id which must then be passed in http headers. After session is created, call SetUserRights (and get locking systems before that if necessary to get a lockgroup_id)

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$create_session_param = new \OpenAPI\Client\Model\CreateSessionParam(); // \OpenAPI\Client\Model\CreateSessionParam

try {
    $result = $apiInstance->authenticationCreateSession($create_session_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->authenticationCreateSession: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_session_param** | [**\OpenAPI\Client\Model\CreateSessionParam**](../Model/CreateSessionParam.md)|  | |

### Return type

[**\OpenAPI\Client\Model\CreateSessionResult**](../Model/CreateSessionResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `authenticationKillSession()`

```php
authenticationKillSession(): \SplFileObject
```

/api/v2/KillSession

Ends session

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->authenticationKillSession();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->authenticationKillSession: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/octet-stream`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `authenticationSetLockgroup()`

```php
authenticationSetLockgroup($set_lockgroup_param): \OpenAPI\Client\Model\SetLockgroupResult
```

/api/v2/SetLockgroup

Sets user's session's locking system information. Call after CreateSession and GetLockGroups is called.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$set_lockgroup_param = new \OpenAPI\Client\Model\SetLockgroupParam(); // \OpenAPI\Client\Model\SetLockgroupParam

try {
    $result = $apiInstance->authenticationSetLockgroup($set_lockgroup_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->authenticationSetLockgroup: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **set_lockgroup_param** | [**\OpenAPI\Client\Model\SetLockgroupParam**](../Model/SetLockgroupParam.md)|  | |

### Return type

[**\OpenAPI\Client\Model\SetLockgroupResult**](../Model/SetLockgroupResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `authenticationTest()`

```php
authenticationTest(): string
```

/api/v2/Test

Connection test. Returns \"Test OK\".

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->authenticationTest();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->authenticationTest: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `authenticationVersion()`

```php
authenticationVersion(): string
```

/api/v2/Version

Returns assembly version

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->authenticationVersion();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->authenticationVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
