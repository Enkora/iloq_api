# OpenAPI\Client\LocksApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**locksCanOrderLock()**](LocksApi.md#locksCanOrderLock) | **GET** /api/v2/Locks/{id}/CanOrder | /api/v2/Locks/{id}/CanOrder |
| [**locksDelete()**](LocksApi.md#locksDelete) | **DELETE** /api/v2/Locks/{id} | /api/v2/Locks/{id} |
| [**locksGetAllLocks()**](LocksApi.md#locksGetAllLocks) | **GET** /api/v2/Locks | /api/v2/Locks |
| [**locksGetLockById()**](LocksApi.md#locksGetLockById) | **GET** /api/v2/Locks/{id} | /api/v2/Locks/{id} |
| [**locksGetLockOptions()**](LocksApi.md#locksGetLockOptions) | **GET** /api/v2/Locks/{id}/Options | /api/v2/Locks/{id}/Options |
| [**locksGetSecurityAccesses()**](LocksApi.md#locksGetSecurityAccesses) | **GET** /api/v2/Locks/{id}/SecurityAccesses | /api/v2/Locks/{id}/SecurityAccesses |
| [**locksGetTimeLimits()**](LocksApi.md#locksGetTimeLimits) | **GET** /api/v2/Locks/{id}/TimeLimitTitles | /api/v2/Locks/{id}/TimeLimitTitles |
| [**locksInsert()**](LocksApi.md#locksInsert) | **POST** /api/v2/Locks | /api/v2/Locks |
| [**locksOrderLock()**](LocksApi.md#locksOrderLock) | **POST** /api/v2/Locks/{id}/Order | /api/v2/Locks/{id}/Order |
| [**locksUpdate()**](LocksApi.md#locksUpdate) | **PUT** /api/v2/Locks | /api/v2/Locks |
| [**locksUpdateSecurityAccesses()**](LocksApi.md#locksUpdateSecurityAccesses) | **PUT** /api/v2/Locks/{id}/SecurityAccesses | /api/v2/Locks/{id}/SecurityAccesses |


## `locksCanOrderLock()`

```php
locksCanOrderLock($id): \OpenAPI\Client\Model\CanOrderLockResultType
```

/api/v2/Locks/{id}/CanOrder

Checks if given lock can be ordered.    Only Locks compatible with S50 Keys can be ordered using this public API.    <b>Required user rights:</b>    - Right to order locks

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Lock Id

try {
    $result = $apiInstance->locksCanOrderLock($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksCanOrderLock: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Lock Id | |

### Return type

[**\OpenAPI\Client\Model\CanOrderLockResultType**](../Model/CanOrderLockResultType.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksDelete()`

```php
locksDelete($id)
```

/api/v2/Locks/{id}

Deletes given lock or removes it from use if it's programmed to keep history and logs.    <b>Required user rights:</b>    - Right to edit locks

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $apiInstance->locksDelete($id);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksGetAllLocks()`

```php
locksGetAllLocks(): \OpenAPI\Client\Model\Lock[]
```

/api/v2/Locks

Returns lock list    <b>Required user rights:</b>    - Right to browse lock list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->locksGetAllLocks();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksGetAllLocks: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\Lock[]**](../Model/Lock.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksGetLockById()`

```php
locksGetLockById($id): \OpenAPI\Client\Model\Lock
```

/api/v2/Locks/{id}

Returns single lock    <b>Required user rights:</b>    - Right to browse lock list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->locksGetLockById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksGetLockById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\Lock**](../Model/Lock.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksGetLockOptions()`

```php
locksGetLockOptions($id): \OpenAPI\Client\Model\LLockOptionMaskParam
```

/api/v2/Locks/{id}/Options

Gets locks option mask values    <b>Required user rights:</b>    - Right to browse lock list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Lock Id

try {
    $result = $apiInstance->locksGetLockOptions($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksGetLockOptions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Lock Id | |

### Return type

[**\OpenAPI\Client\Model\LLockOptionMaskParam**](../Model/LLockOptionMaskParam.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksGetSecurityAccesses()`

```php
locksGetSecurityAccesses($id, $mode): \OpenAPI\Client\Model\GetLockSecurityAccessesResult
```

/api/v2/Locks/{id}/SecurityAccesses

Gets lock's security accesses    <b>Requires at least one of the following user rights:</b>    - Right to edit locks    - Right to view security access list    - Right to edit security accesses    - Right to edit lock access    - Right to browse lock list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Lock id
$mode = new \OpenAPI\Client\Model\\OpenAPI\Client\Model\GetSecurityAccessesView(); // \OpenAPI\Client\Model\GetSecurityAccessesView

try {
    $result = $apiInstance->locksGetSecurityAccesses($id, $mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksGetSecurityAccesses: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Lock id | |
| **mode** | [**\OpenAPI\Client\Model\GetSecurityAccessesView**](../Model/.md)|  | |

### Return type

[**\OpenAPI\Client\Model\GetLockSecurityAccessesResult**](../Model/GetLockSecurityAccessesResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksGetTimeLimits()`

```php
locksGetTimeLimits($id, $mode): \OpenAPI\Client\Model\GetLockTimeLimitsResult
```

/api/v2/Locks/{id}/TimeLimitTitles

Returns Lock's time limits    <b>Requires at least one of the following user rights:</b>    - Right to edit locks    - Right to view security access list    - Right to edit security accesses    - Right to edit lock access    - Right to browse lock list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Lock Id
$mode = new \OpenAPI\Client\Model\\OpenAPI\Client\Model\GetTimeLimitsView(); // \OpenAPI\Client\Model\GetTimeLimitsView

try {
    $result = $apiInstance->locksGetTimeLimits($id, $mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksGetTimeLimits: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Lock Id | |
| **mode** | [**\OpenAPI\Client\Model\GetTimeLimitsView**](../Model/.md)|  | |

### Return type

[**\OpenAPI\Client\Model\GetLockTimeLimitsResult**](../Model/GetLockTimeLimitsResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksInsert()`

```php
locksInsert($insert_lock_param): \OpenAPI\Client\Model\Lock2
```

/api/v2/Locks

Adds new lock    If lock hasn't been initialized yet, it can't have soft security accesses    <b>Required user rights:</b>    - Right to view lock tools    - Right to edit locks

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$insert_lock_param = new \OpenAPI\Client\Model\InsertLockParam(); // \OpenAPI\Client\Model\InsertLockParam

try {
    $result = $apiInstance->locksInsert($insert_lock_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **insert_lock_param** | [**\OpenAPI\Client\Model\InsertLockParam**](../Model/InsertLockParam.md)|  | |

### Return type

[**\OpenAPI\Client\Model\Lock2**](../Model/Lock2.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksOrderLock()`

```php
locksOrderLock($id)
```

/api/v2/Locks/{id}/Order

Orders Lock.    Only Locks compatible with S50 Keys can be ordered using this public API.    <b>Required user rights:</b>    - Right to order locks

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Lock Id

try {
    $apiInstance->locksOrderLock($id);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksOrderLock: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Lock Id | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksUpdate()`

```php
locksUpdate($update_lock_param)
```

/api/v2/Locks

Updates existing lock    <b>Required user rights:</b>    - Right to edit locks

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$update_lock_param = new \OpenAPI\Client\Model\UpdateLockParam(); // \OpenAPI\Client\Model\UpdateLockParam

try {
    $apiInstance->locksUpdate($update_lock_param);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **update_lock_param** | [**\OpenAPI\Client\Model\UpdateLockParam**](../Model/UpdateLockParam.md)|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `locksUpdateSecurityAccesses()`

```php
locksUpdateSecurityAccesses($id, $update_lock_security_accesses_param)
```

/api/v2/Locks/{id}/SecurityAccesses

Updates locks' access rights.    <b>Required user rights:</b>    - Right to edit lock access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Lock id
$update_lock_security_accesses_param = new \OpenAPI\Client\Model\UpdateLockSecurityAccessesParam(); // \OpenAPI\Client\Model\UpdateLockSecurityAccessesParam | Parameter

try {
    $apiInstance->locksUpdateSecurityAccesses($id, $update_lock_security_accesses_param);
} catch (Exception $e) {
    echo 'Exception when calling LocksApi->locksUpdateSecurityAccesses: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Lock id | |
| **update_lock_security_accesses_param** | [**\OpenAPI\Client\Model\UpdateLockSecurityAccessesParam**](../Model/UpdateLockSecurityAccessesParam.md)| Parameter | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
