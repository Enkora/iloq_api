# OpenAPI\Client\ZonesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**zonesGetAllZones()**](ZonesApi.md#zonesGetAllZones) | **GET** /api/v2/Zones | /api/v2/Zones |


## `zonesGetAllZones()`

```php
zonesGetAllZones(): \OpenAPI\Client\Model\Zone[]
```

/api/v2/Zones

Gets all zones in locking system.    <b>Required user rights:</b>    - Right to log in to iLOQ Manager

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ZonesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->zonesGetAllZones();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ZonesApi->zonesGetAllZones: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\Zone[]**](../Model/Zone.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
