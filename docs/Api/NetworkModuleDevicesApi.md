# OpenAPI\Client\NetworkModuleDevicesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**networkModuleDevicesGetAll()**](NetworkModuleDevicesApi.md#networkModuleDevicesGetAll) | **GET** /api/v2/NetworkModuleDevices | /api/v2/NetworkModuleDevices |
| [**networkModuleDevicesGetById()**](NetworkModuleDevicesApi.md#networkModuleDevicesGetById) | **GET** /api/v2/NetworkModuleDevices/{id} | /api/v2/NetworkModuleDevices/{id} |
| [**networkModuleDevicesGetByNetworkModuleId()**](NetworkModuleDevicesApi.md#networkModuleDevicesGetByNetworkModuleId) | **GET** /api/v2/NetworkModules/{id}/NetworkModuleDevices | /api/v2/NetworkModules/{id}/NetworkModuleDevices |


## `networkModuleDevicesGetAll()`

```php
networkModuleDevicesGetAll(): \OpenAPI\Client\Model\NetworkModuleDevice[]
```

/api/v2/NetworkModuleDevices

Returns all network module devices    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\NetworkModuleDevicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->networkModuleDevicesGetAll();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NetworkModuleDevicesApi->networkModuleDevicesGetAll: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\NetworkModuleDevice[]**](../Model/NetworkModuleDevice.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `networkModuleDevicesGetById()`

```php
networkModuleDevicesGetById($id): \OpenAPI\Client\Model\NetworkModuleDevice
```

/api/v2/NetworkModuleDevices/{id}

Returns network module device by ID    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\NetworkModuleDevicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Network module device ID

try {
    $result = $apiInstance->networkModuleDevicesGetById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NetworkModuleDevicesApi->networkModuleDevicesGetById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Network module device ID | |

### Return type

[**\OpenAPI\Client\Model\NetworkModuleDevice**](../Model/NetworkModuleDevice.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `networkModuleDevicesGetByNetworkModuleId()`

```php
networkModuleDevicesGetByNetworkModuleId($id): \OpenAPI\Client\Model\NetworkModuleDevice[]
```

/api/v2/NetworkModules/{id}/NetworkModuleDevices

Returns network module devices which belong to given Network Module    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\NetworkModuleDevicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Network module ID

try {
    $result = $apiInstance->networkModuleDevicesGetByNetworkModuleId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NetworkModuleDevicesApi->networkModuleDevicesGetByNetworkModuleId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Network module ID | |

### Return type

[**\OpenAPI\Client\Model\NetworkModuleDevice[]**](../Model/NetworkModuleDevice.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
