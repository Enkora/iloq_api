# OpenAPI\Client\TimeLimitTitlesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**timeLimitTitlesCanDelete()**](TimeLimitTitlesApi.md#timeLimitTitlesCanDelete) | **GET** /api/v2/TimeLimitTitles/{id}/CanDelete | /api/v2/TimeLimitTitles/{id}/CanDelete |
| [**timeLimitTitlesDelete()**](TimeLimitTitlesApi.md#timeLimitTitlesDelete) | **DELETE** /api/v2/TimeLimitTitles/{id} | /api/v2/TimeLimitTitles/{id} |
| [**timeLimitTitlesGetAll()**](TimeLimitTitlesApi.md#timeLimitTitlesGetAll) | **GET** /api/v2/TimeLimitTitles | /api/v2/TimeLimitTitles |
| [**timeLimitTitlesGetById()**](TimeLimitTitlesApi.md#timeLimitTitlesGetById) | **GET** /api/v2/TimeLimitTitles/{id} | /api/v2/TimeLimitTitles/{id} |
| [**timeLimitTitlesInsert()**](TimeLimitTitlesApi.md#timeLimitTitlesInsert) | **POST** /api/v2/TimeLimitTitles | /api/v2/TimeLimitTitles |
| [**timeLimitTitlesUpdate()**](TimeLimitTitlesApi.md#timeLimitTitlesUpdate) | **PUT** /api/v2/TimeLimitTitles | /api/v2/TimeLimitTitles |


## `timeLimitTitlesCanDelete()`

```php
timeLimitTitlesCanDelete($id): \OpenAPI\Client\Model\CanDeleteTimeLimitTitleResult
```

/api/v2/TimeLimitTitles/{id}/CanDelete

Checks if given TimeLimitTitle can be deleted    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TimeLimitTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | TimeLimitTitle Id

try {
    $result = $apiInstance->timeLimitTitlesCanDelete($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TimeLimitTitlesApi->timeLimitTitlesCanDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| TimeLimitTitle Id | |

### Return type

[**\OpenAPI\Client\Model\CanDeleteTimeLimitTitleResult**](../Model/CanDeleteTimeLimitTitleResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `timeLimitTitlesDelete()`

```php
timeLimitTitlesDelete($id)
```

/api/v2/TimeLimitTitles/{id}

Deletes Time limit title by id    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TimeLimitTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Time limit title id

try {
    $apiInstance->timeLimitTitlesDelete($id);
} catch (Exception $e) {
    echo 'Exception when calling TimeLimitTitlesApi->timeLimitTitlesDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Time limit title id | |

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

## `timeLimitTitlesGetAll()`

```php
timeLimitTitlesGetAll(): \OpenAPI\Client\Model\TimeLimitTitle[]
```

/api/v2/TimeLimitTitles

Returns all time limit titles user has access to    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TimeLimitTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->timeLimitTitlesGetAll();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TimeLimitTitlesApi->timeLimitTitlesGetAll: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\TimeLimitTitle[]**](../Model/TimeLimitTitle.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `timeLimitTitlesGetById()`

```php
timeLimitTitlesGetById($id): \OpenAPI\Client\Model\TimeLimitTitle
```

/api/v2/TimeLimitTitles/{id}

Gets given time limit title's information    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TimeLimitTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Time limit title id

try {
    $result = $apiInstance->timeLimitTitlesGetById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TimeLimitTitlesApi->timeLimitTitlesGetById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Time limit title id | |

### Return type

[**\OpenAPI\Client\Model\TimeLimitTitle**](../Model/TimeLimitTitle.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `timeLimitTitlesInsert()`

```php
timeLimitTitlesInsert($insert_time_limit_titles_param)
```

/api/v2/TimeLimitTitles

Adds new Time limit title and data    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TimeLimitTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$insert_time_limit_titles_param = new \OpenAPI\Client\Model\InsertTimeLimitTitlesParam(); // \OpenAPI\Client\Model\InsertTimeLimitTitlesParam | Time limit title and data to insert

try {
    $apiInstance->timeLimitTitlesInsert($insert_time_limit_titles_param);
} catch (Exception $e) {
    echo 'Exception when calling TimeLimitTitlesApi->timeLimitTitlesInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **insert_time_limit_titles_param** | [**\OpenAPI\Client\Model\InsertTimeLimitTitlesParam**](../Model/InsertTimeLimitTitlesParam.md)| Time limit title and data to insert | |

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

## `timeLimitTitlesUpdate()`

```php
timeLimitTitlesUpdate($update_time_limit_titles_param)
```

/api/v2/TimeLimitTitles

Updates existing Time limit title and its data.    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TimeLimitTitlesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$update_time_limit_titles_param = new \OpenAPI\Client\Model\UpdateTimeLimitTitlesParam(); // \OpenAPI\Client\Model\UpdateTimeLimitTitlesParam | Time limit title to update

try {
    $apiInstance->timeLimitTitlesUpdate($update_time_limit_titles_param);
} catch (Exception $e) {
    echo 'Exception when calling TimeLimitTitlesApi->timeLimitTitlesUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **update_time_limit_titles_param** | [**\OpenAPI\Client\Model\UpdateTimeLimitTitlesParam**](../Model/UpdateTimeLimitTitlesParam.md)| Time limit title to update | |

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
