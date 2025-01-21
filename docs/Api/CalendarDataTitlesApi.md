# OpenAPI\Client\CalendarDataTitlesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**calendarDataTitlesDelete()**](CalendarDataTitlesApi.md#calendarDataTitlesDelete) | **DELETE** /api/v2/CalendarDataTitles/{id} | /api/v2/CalendarDataTitles/{id} |
| [**calendarDataTitlesGetAll()**](CalendarDataTitlesApi.md#calendarDataTitlesGetAll) | **GET** /api/v2/CalendarDataTitles | /api/v2/CalendarDataTitles |
| [**calendarDataTitlesGetById()**](CalendarDataTitlesApi.md#calendarDataTitlesGetById) | **GET** /api/v2/CalendarDataTitles/{id} | /api/v2/CalendarDataTitles/{id} |
| [**calendarDataTitlesInsert()**](CalendarDataTitlesApi.md#calendarDataTitlesInsert) | **POST** /api/v2/CalendarDataTitles | /api/v2/CalendarDataTitles |
| [**calendarDataTitlesUpdate()**](CalendarDataTitlesApi.md#calendarDataTitlesUpdate) | **PUT** /api/v2/CalendarDataTitles | /api/v2/CalendarDataTitles |


## `calendarDataTitlesDelete()`

```php
calendarDataTitlesDelete($id)
```

/api/v2/CalendarDataTitles/{id}

Deletes calendar by id    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar id

try {
    $apiInstance->calendarDataTitlesDelete($id);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataTitlesApi->calendarDataTitlesDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar id | |

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

## `calendarDataTitlesGetAll()`

```php
calendarDataTitlesGetAll(): \OpenAPI\Client\Model\CalendarDataTitle[]
```

/api/v2/CalendarDataTitles

Returns all calendars user has access to    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->calendarDataTitlesGetAll();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataTitlesApi->calendarDataTitlesGetAll: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\CalendarDataTitle[]**](../Model/CalendarDataTitle.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calendarDataTitlesGetById()`

```php
calendarDataTitlesGetById($id): \OpenAPI\Client\Model\CalendarDataTitle
```

/api/v2/CalendarDataTitles/{id}

Gets given calendar's information    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar data title id

try {
    $result = $apiInstance->calendarDataTitlesGetById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataTitlesApi->calendarDataTitlesGetById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar data title id | |

### Return type

[**\OpenAPI\Client\Model\CalendarDataTitle**](../Model/CalendarDataTitle.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calendarDataTitlesInsert()`

```php
calendarDataTitlesInsert($calendar_data_title_insert)
```

/api/v2/CalendarDataTitles

Adds new calendar    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$calendar_data_title_insert = new \OpenAPI\Client\Model\CalendarDataTitleInsert(); // \OpenAPI\Client\Model\CalendarDataTitleInsert | Calendar to insert

try {
    $apiInstance->calendarDataTitlesInsert($calendar_data_title_insert);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataTitlesApi->calendarDataTitlesInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **calendar_data_title_insert** | [**\OpenAPI\Client\Model\CalendarDataTitleInsert**](../Model/CalendarDataTitleInsert.md)| Calendar to insert | |

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

## `calendarDataTitlesUpdate()`

```php
calendarDataTitlesUpdate($calendar_data_title_update)
```

/api/v2/CalendarDataTitles

Updates existing calendar    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$calendar_data_title_update = new \OpenAPI\Client\Model\CalendarDataTitleUpdate(); // \OpenAPI\Client\Model\CalendarDataTitleUpdate | Calendar to update

try {
    $apiInstance->calendarDataTitlesUpdate($calendar_data_title_update);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataTitlesApi->calendarDataTitlesUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **calendar_data_title_update** | [**\OpenAPI\Client\Model\CalendarDataTitleUpdate**](../Model/CalendarDataTitleUpdate.md)| Calendar to update | |

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
