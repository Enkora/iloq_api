# OpenAPI\Client\LockLogsApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**lockLogsGetLockLogDataByGoingDates()**](LockLogsApi.md#lockLogsGetLockLogDataByGoingDates) | **POST** /api/v2/LockLogs/GetLockLogDataByGoingDates | /api/v2/LockLogs/GetLockLogDataByGoingDates |
| [**lockLogsGetLockLogDataByTimestamp()**](LockLogsApi.md#lockLogsGetLockLogDataByTimestamp) | **POST** /api/v2/LockLogs/GetLockLogDataByTimestamp | /api/v2/LockLogs/GetLockLogDataByTimestamp |
| [**lockLogsGetLockLogs()**](LockLogsApi.md#lockLogsGetLockLogs) | **POST** /api/v2/LockLogs | /api/v2/LockLogs |


## `lockLogsGetLockLogDataByGoingDates()`

```php
lockLogsGetLockLogDataByGoingDates($get_lock_log_data_param): \OpenAPI\Client\Model\GetLockLogDataResult
```

/api/v2/LockLogs/GetLockLogDataByGoingDates

Returns lock logs by going dates    <b>Required user rights:</b>    - Right to browse lock log entries

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LockLogsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$get_lock_log_data_param = new \OpenAPI\Client\Model\GetLockLogDataParam(); // \OpenAPI\Client\Model\GetLockLogDataParam | Parameter containing start and end dates

try {
    $result = $apiInstance->lockLogsGetLockLogDataByGoingDates($get_lock_log_data_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LockLogsApi->lockLogsGetLockLogDataByGoingDates: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **get_lock_log_data_param** | [**\OpenAPI\Client\Model\GetLockLogDataParam**](../Model/GetLockLogDataParam.md)| Parameter containing start and end dates | |

### Return type

[**\OpenAPI\Client\Model\GetLockLogDataResult**](../Model/GetLockLogDataResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `lockLogsGetLockLogDataByTimestamp()`

```php
lockLogsGetLockLogDataByTimestamp($get_lock_log_data_param): \OpenAPI\Client\Model\GetLockLogDataResult
```

/api/v2/LockLogs/GetLockLogDataByTimestamp

Returns lock logs by the time they were added to the database    <b>Required user rights:</b>    - Right to browse lock log entries

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LockLogsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$get_lock_log_data_param = new \OpenAPI\Client\Model\GetLockLogDataParam(); // \OpenAPI\Client\Model\GetLockLogDataParam | Parameter containing start and end dates

try {
    $result = $apiInstance->lockLogsGetLockLogDataByTimestamp($get_lock_log_data_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LockLogsApi->lockLogsGetLockLogDataByTimestamp: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **get_lock_log_data_param** | [**\OpenAPI\Client\Model\GetLockLogDataParam**](../Model/GetLockLogDataParam.md)| Parameter containing start and end dates | |

### Return type

[**\OpenAPI\Client\Model\GetLockLogDataResult**](../Model/GetLockLogDataResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `lockLogsGetLockLogs()`

```php
lockLogsGetLockLogs($get_lock_logs_param): \OpenAPI\Client\Model\PublicApiGetLockLogsResult
```

/api/v2/LockLogs

Returns logs for keys/locks.    <b>Required user rights:</b>    - Right to browse lock log entries

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\LockLogsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$get_lock_logs_param = new \OpenAPI\Client\Model\GetLockLogsParam(); // \OpenAPI\Client\Model\GetLockLogsParam

try {
    $result = $apiInstance->lockLogsGetLockLogs($get_lock_logs_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LockLogsApi->lockLogsGetLockLogs: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **get_lock_logs_param** | [**\OpenAPI\Client\Model\GetLockLogsParam**](../Model/GetLockLogsParam.md)|  | |

### Return type

[**\OpenAPI\Client\Model\PublicApiGetLockLogsResult**](../Model/PublicApiGetLockLogsResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
