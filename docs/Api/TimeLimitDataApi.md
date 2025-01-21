# OpenAPI\Client\TimeLimitDataApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**timeLimitDataGetByTimeLimitTitleId()**](TimeLimitDataApi.md#timeLimitDataGetByTimeLimitTitleId) | **GET** /api/v2/TimeLimitTitles/{id}/TimeLimitData | /api/v2/TimeLimitTitles/{id}/TimeLimitData |


## `timeLimitDataGetByTimeLimitTitleId()`

```php
timeLimitDataGetByTimeLimitTitleId($id): \OpenAPI\Client\Model\TimeLimitData[]
```

/api/v2/TimeLimitTitles/{id}/TimeLimitData

Returns TimeLimitData for given TimeLimitTitle    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TimeLimitDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | TimeLimitTitle Id

try {
    $result = $apiInstance->timeLimitDataGetByTimeLimitTitleId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TimeLimitDataApi->timeLimitDataGetByTimeLimitTitleId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| TimeLimitTitle Id | |

### Return type

[**\OpenAPI\Client\Model\TimeLimitData[]**](../Model/TimeLimitData.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
