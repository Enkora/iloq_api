# OpenAPI\Client\UrlApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**urlGetUrl()**](UrlApi.md#urlGetUrl) | **POST** /api/v2/Url/GetUrl | /api/v2/Url/GetUrl |


## `urlGetUrl()`

```php
urlGetUrl($public_api_get_url_param): string
```

/api/v2/Url/GetUrl

Returns url for public API endpoint

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\UrlApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$public_api_get_url_param = new \OpenAPI\Client\Model\PublicApiGetUrlParam(); // \OpenAPI\Client\Model\PublicApiGetUrlParam

try {
    $result = $apiInstance->urlGetUrl($public_api_get_url_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UrlApi->urlGetUrl: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **public_api_get_url_param** | [**\OpenAPI\Client\Model\PublicApiGetUrlParam**](../Model/PublicApiGetUrlParam.md)|  | |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
