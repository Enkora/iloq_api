# OpenAPI\Client\CalendarDatasApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**calendarDatasDelete()**](CalendarDatasApi.md#calendarDatasDelete) | **DELETE** /api/v2/CalendarDatas/{id} | /api/v2/CalendarDatas/{id} |
| [**calendarDatasGetByCalendarDataId()**](CalendarDatasApi.md#calendarDatasGetByCalendarDataId) | **GET** /api/v2/CalendarDatas/{id} | /api/v2/CalendarDatas/{id} |
| [**calendarDatasGetByCalendarId()**](CalendarDatasApi.md#calendarDatasGetByCalendarId) | **GET** /api/v2/CalendarDataTitles/{id}/CalendarDatas | /api/v2/CalendarDataTitles/{id}/CalendarDatas |
| [**calendarDatasInsert()**](CalendarDatasApi.md#calendarDatasInsert) | **POST** /api/v2/CalendarDatas | /api/v2/CalendarDatas |
| [**calendarDatasUpdate()**](CalendarDatasApi.md#calendarDatasUpdate) | **PUT** /api/v2/CalendarDatas | /api/v2/CalendarDatas |


## `calendarDatasDelete()`

```php
calendarDatasDelete($id)
```

/api/v2/CalendarDatas/{id}

Deletes calendar data    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDatasApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar data id

try {
    $apiInstance->calendarDatasDelete($id);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDatasApi->calendarDatasDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar data id | |

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

## `calendarDatasGetByCalendarDataId()`

```php
calendarDatasGetByCalendarDataId($id): \OpenAPI\Client\Model\CalendarDataGetByCalendarDataIdResult
```

/api/v2/CalendarDatas/{id}

Returns calendar data information by calendar data id    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDatasApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar data id

try {
    $result = $apiInstance->calendarDatasGetByCalendarDataId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDatasApi->calendarDatasGetByCalendarDataId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar data id | |

### Return type

[**\OpenAPI\Client\Model\CalendarDataGetByCalendarDataIdResult**](../Model/CalendarDataGetByCalendarDataIdResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calendarDatasGetByCalendarId()`

```php
calendarDatasGetByCalendarId($id, $start_date, $end_date): \OpenAPI\Client\Model\CalendarDataGetByCalendarIdResult
```

/api/v2/CalendarDataTitles/{id}/CalendarDatas

Returns calendar data for given calendar    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDatasApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar id
$start_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Start date to filter result set
$end_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | End date to filter result set

try {
    $result = $apiInstance->calendarDatasGetByCalendarId($id, $start_date, $end_date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDatasApi->calendarDatasGetByCalendarId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar id | |
| **start_date** | **\DateTime**| Start date to filter result set | [optional] |
| **end_date** | **\DateTime**| End date to filter result set | [optional] |

### Return type

[**\OpenAPI\Client\Model\CalendarDataGetByCalendarIdResult**](../Model/CalendarDataGetByCalendarIdResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calendarDatasInsert()`

```php
calendarDatasInsert($calendar_data_insert_param)
```

/api/v2/CalendarDatas

Adds calendar data    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDatasApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$calendar_data_insert_param = new \OpenAPI\Client\Model\CalendarDataInsertParam(); // \OpenAPI\Client\Model\CalendarDataInsertParam | Insert data

try {
    $apiInstance->calendarDatasInsert($calendar_data_insert_param);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDatasApi->calendarDatasInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **calendar_data_insert_param** | [**\OpenAPI\Client\Model\CalendarDataInsertParam**](../Model/CalendarDataInsertParam.md)| Insert data | |

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

## `calendarDatasUpdate()`

```php
calendarDatasUpdate($calendar_data_update_param)
```

/api/v2/CalendarDatas

Updates calendar data    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDatasApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$calendar_data_update_param = new \OpenAPI\Client\Model\CalendarDataUpdateParam(); // \OpenAPI\Client\Model\CalendarDataUpdateParam | Update data

try {
    $apiInstance->calendarDatasUpdate($calendar_data_update_param);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDatasApi->calendarDatasUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **calendar_data_update_param** | [**\OpenAPI\Client\Model\CalendarDataUpdateParam**](../Model/CalendarDataUpdateParam.md)| Update data | |

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
