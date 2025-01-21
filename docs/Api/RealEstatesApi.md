# OpenAPI\Client\RealEstatesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**realEstatesGetValues()**](RealEstatesApi.md#realEstatesGetValues) | **GET** /api/v2/RealEstates | /api/v2/RealEstates |


## `realEstatesGetValues()`

```php
realEstatesGetValues(): \OpenAPI\Client\Model\RealEstate[]
```

/api/v2/RealEstates

Returns list of locking system's real estates    <b>Required user rights:</b>    - Right to log in to iLOQ Manager

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\RealEstatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->realEstatesGetValues();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RealEstatesApi->realEstatesGetValues: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\RealEstate[]**](../Model/RealEstate.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
