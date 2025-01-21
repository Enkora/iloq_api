# OpenAPI\Client\NetworkModulesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**networkModulesGetAll()**](NetworkModulesApi.md#networkModulesGetAll) | **GET** /api/v2/NetworkModules | /api/v2/NetworkModules |
| [**networkModulesGetById()**](NetworkModulesApi.md#networkModulesGetById) | **GET** /api/v2/NetworkModules/{id} | /api/v2/NetworkModules/{id} |


## `networkModulesGetAll()`

```php
networkModulesGetAll(): \OpenAPI\Client\Model\NetworkModule[]
```

/api/v2/NetworkModules

Returns list of network modules    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\NetworkModulesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->networkModulesGetAll();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NetworkModulesApi->networkModulesGetAll: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\NetworkModule[]**](../Model/NetworkModule.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `networkModulesGetById()`

```php
networkModulesGetById($id): \OpenAPI\Client\Model\NetworkModule
```

/api/v2/NetworkModules/{id}

Returns information for given network module    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\NetworkModulesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Network module id

try {
    $result = $apiInstance->networkModulesGetById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NetworkModulesApi->networkModulesGetById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Network module id | |

### Return type

[**\OpenAPI\Client\Model\NetworkModule**](../Model/NetworkModule.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
