# OpenAPI\Client\LockGroupsApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**lockGroupsGenerateAccessToken()**](LockGroupsApi.md#lockGroupsGenerateAccessToken) | **POST** /api/v2/LockGroups/GenerateAccessToken | /api/v2/LockGroups/GenerateAccessToken |
| [**lockGroupsGetAllLockGroups()**](LockGroupsApi.md#lockGroupsGetAllLockGroups) | **GET** /api/v2/LockGroups | /api/v2/LockGroups |
| [**lockGroupsGetConnectionSettings()**](LockGroupsApi.md#lockGroupsGetConnectionSettings) | **GET** /api/v2/LockGroups/ConnectionSettings | /api/v2/LockGroups/ConnectionSettings |


## `lockGroupsGenerateAccessToken()`

```php
lockGroupsGenerateAccessToken($generate_access_token_param): \OpenAPI\Client\Model\GenerateAccessTokenResult
```

/api/v2/LockGroups/GenerateAccessToken

Generates new access token. Access tokens are used to access certain external services.    <b>Required user rights:</b>    - Right to log in to iLOQ Manager

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LockGroupsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$generate_access_token_param = new \OpenAPI\Client\Model\GenerateAccessTokenParam(); // \OpenAPI\Client\Model\GenerateAccessTokenParam | Access token generation parameter

try {
    $result = $apiInstance->lockGroupsGenerateAccessToken($generate_access_token_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LockGroupsApi->lockGroupsGenerateAccessToken: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **generate_access_token_param** | [**\OpenAPI\Client\Model\GenerateAccessTokenParam**](../Model/GenerateAccessTokenParam.md)| Access token generation parameter | |

### Return type

[**\OpenAPI\Client\Model\GenerateAccessTokenResult**](../Model/GenerateAccessTokenResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `lockGroupsGetAllLockGroups()`

```php
lockGroupsGetAllLockGroups(): \OpenAPI\Client\Model\LockGroup[]
```

/api/v2/LockGroups

Gets all locking systems available for user

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LockGroupsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->lockGroupsGetAllLockGroups();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LockGroupsApi->lockGroupsGetAllLockGroups: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\LockGroup[]**](../Model/LockGroup.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `lockGroupsGetConnectionSettings()`

```php
lockGroupsGetConnectionSettings(): \OpenAPI\Client\Model\GetConnectionSettingsResult
```

/api/v2/LockGroups/ConnectionSettings

Returns locking system's connection settings    <b>Required user rights:</b>    - Right to log in to iLOQ Manager

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LockGroupsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->lockGroupsGetConnectionSettings();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LockGroupsApi->lockGroupsGetConnectionSettings: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetConnectionSettingsResult**](../Model/GetConnectionSettingsResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
