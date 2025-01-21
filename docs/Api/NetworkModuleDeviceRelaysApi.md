# OpenAPI\Client\NetworkModuleDeviceRelaysApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**networkModuleDeviceRelaysGetById()**](NetworkModuleDeviceRelaysApi.md#networkModuleDeviceRelaysGetById) | **GET** /api/v2/NetworkModuleDeviceRelays/{id} | /api/v2/NetworkModuleDeviceRelays/{id} |
| [**networkModuleDeviceRelaysGetByNetworkModuleDeviceId()**](NetworkModuleDeviceRelaysApi.md#networkModuleDeviceRelaysGetByNetworkModuleDeviceId) | **GET** /api/v2/NetworkModuleDevices/{id}/NetworkModuleDeviceRelays | /api/v2/NetworkModuleDevices/{id}/NetworkModuleDeviceRelays |
| [**networkModuleDeviceRelaysGetByNetworkModuleId()**](NetworkModuleDeviceRelaysApi.md#networkModuleDeviceRelaysGetByNetworkModuleId) | **GET** /api/v2/NetworkModules/{id}/NetworkModuleDeviceRelays | /api/v2/NetworkModules/{id}/NetworkModuleDeviceRelays |


## `networkModuleDeviceRelaysGetById()`

```php
networkModuleDeviceRelaysGetById($id): \OpenAPI\Client\Model\NetworkModuleDeviceRelay
```

/api/v2/NetworkModuleDeviceRelays/{id}

Returns information about specific network module device relay    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\NetworkModuleDeviceRelaysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | network module device relay id

try {
    $result = $apiInstance->networkModuleDeviceRelaysGetById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NetworkModuleDeviceRelaysApi->networkModuleDeviceRelaysGetById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| network module device relay id | |

### Return type

[**\OpenAPI\Client\Model\NetworkModuleDeviceRelay**](../Model/NetworkModuleDeviceRelay.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `networkModuleDeviceRelaysGetByNetworkModuleDeviceId()`

```php
networkModuleDeviceRelaysGetByNetworkModuleDeviceId($id): \OpenAPI\Client\Model\NetworkModuleDeviceRelay[]
```

/api/v2/NetworkModuleDevices/{id}/NetworkModuleDeviceRelays

Returns relays which belong to given network module device    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\NetworkModuleDeviceRelaysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Network module device id

try {
    $result = $apiInstance->networkModuleDeviceRelaysGetByNetworkModuleDeviceId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NetworkModuleDeviceRelaysApi->networkModuleDeviceRelaysGetByNetworkModuleDeviceId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Network module device id | |

### Return type

[**\OpenAPI\Client\Model\NetworkModuleDeviceRelay[]**](../Model/NetworkModuleDeviceRelay.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `networkModuleDeviceRelaysGetByNetworkModuleId()`

```php
networkModuleDeviceRelaysGetByNetworkModuleId($id): \OpenAPI\Client\Model\NetworkModuleDeviceRelay[]
```

/api/v2/NetworkModules/{id}/NetworkModuleDeviceRelays

Returns relays which belong to given network module    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\NetworkModuleDeviceRelaysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Network module id

try {
    $result = $apiInstance->networkModuleDeviceRelaysGetByNetworkModuleId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NetworkModuleDeviceRelaysApi->networkModuleDeviceRelaysGetByNetworkModuleId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Network module id | |

### Return type

[**\OpenAPI\Client\Model\NetworkModuleDeviceRelay[]**](../Model/NetworkModuleDeviceRelay.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
