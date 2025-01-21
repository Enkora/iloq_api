# OpenAPI\Client\SecurityAccessApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**securityAccessDelete()**](SecurityAccessApi.md#securityAccessDelete) | **DELETE** /api/v2/SecurityAccesses/{id} | /api/v2/SecurityAccesses/{id} |
| [**securityAccessGetAllSecurityAccesses()**](SecurityAccessApi.md#securityAccessGetAllSecurityAccesses) | **GET** /api/v2/SecurityAccesses | /api/v2/SecurityAccesses |
| [**securityAccessInsert()**](SecurityAccessApi.md#securityAccessInsert) | **POST** /api/v2/SecurityAccesses | /api/v2/SecurityAccesses |
| [**securityAccessUpdate()**](SecurityAccessApi.md#securityAccessUpdate) | **PUT** /api/v2/SecurityAccesses | /api/v2/SecurityAccesses |


## `securityAccessDelete()`

```php
securityAccessDelete($id)
```

/api/v2/SecurityAccesses/{id}

Deletes given security access    <b>Required user rights:</b>    - Right to edit security accesses

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityAccessApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Security access ID

try {
    $apiInstance->securityAccessDelete($id);
} catch (Exception $e) {
    echo 'Exception when calling SecurityAccessApi->securityAccessDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Security access ID | |

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

## `securityAccessGetAllSecurityAccesses()`

```php
securityAccessGetAllSecurityAccesses(): \OpenAPI\Client\Model\SecurityAccess[]
```

/api/v2/SecurityAccesses

Returns list of locking system's security accesses    <b>Required user rights:</b>    - Right to view security access list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityAccessApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->securityAccessGetAllSecurityAccesses();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SecurityAccessApi->securityAccessGetAllSecurityAccesses: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\SecurityAccess[]**](../Model/SecurityAccess.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `securityAccessInsert()`

```php
securityAccessInsert($insert_security_access_param): \OpenAPI\Client\Model\InsertSecurityAccessResult
```

/api/v2/SecurityAccesses

Adds new security access    <b>Required user rights:</b>    - Right to edit security accesses

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityAccessApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$insert_security_access_param = new \OpenAPI\Client\Model\InsertSecurityAccessParam(); // \OpenAPI\Client\Model\InsertSecurityAccessParam | Parameter

try {
    $result = $apiInstance->securityAccessInsert($insert_security_access_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SecurityAccessApi->securityAccessInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **insert_security_access_param** | [**\OpenAPI\Client\Model\InsertSecurityAccessParam**](../Model/InsertSecurityAccessParam.md)| Parameter | |

### Return type

[**\OpenAPI\Client\Model\InsertSecurityAccessResult**](../Model/InsertSecurityAccessResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `securityAccessUpdate()`

```php
securityAccessUpdate($update_security_access_param)
```

/api/v2/SecurityAccesses

Updates existing security access    <b>Required user rights:</b>    - Right to edit security accesses

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityAccessApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$update_security_access_param = new \OpenAPI\Client\Model\UpdateSecurityAccessParam(); // \OpenAPI\Client\Model\UpdateSecurityAccessParam | Parameter

try {
    $apiInstance->securityAccessUpdate($update_security_access_param);
} catch (Exception $e) {
    echo 'Exception when calling SecurityAccessApi->securityAccessUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **update_security_access_param** | [**\OpenAPI\Client\Model\UpdateSecurityAccessParam**](../Model/UpdateSecurityAccessParam.md)| Parameter | |

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
