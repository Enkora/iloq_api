# OpenAPI\Client\KeyTagsApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**keyTagsDelete()**](KeyTagsApi.md#keyTagsDelete) | **DELETE** /api/v2/KeyTags/{id} | /api/v2/KeyTags/{id} |
| [**keyTagsGetAll()**](KeyTagsApi.md#keyTagsGetAll) | **GET** /api/v2/KeyTags | /api/v2/KeyTags |
| [**keyTagsGetById()**](KeyTagsApi.md#keyTagsGetById) | **GET** /api/v2/KeyTags/{id} | /api/v2/KeyTags/{id} |
| [**keyTagsGetTagsByFNKey()**](KeyTagsApi.md#keyTagsGetTagsByFNKey) | **GET** /api/v2/Keys/{id}/KeyTags | /api/v2/Keys/{id}/KeyTags |
| [**keyTagsInsert()**](KeyTagsApi.md#keyTagsInsert) | **POST** /api/v2/KeyTags | /api/v2/KeyTags |
| [**keyTagsUpdate()**](KeyTagsApi.md#keyTagsUpdate) | **PUT** /api/v2/KeyTags | /api/v2/KeyTags |


## `keyTagsDelete()`

```php
keyTagsDelete($id)
```

/api/v2/KeyTags/{id}

Deletes given key tag.    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyTagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key tag id to delete

try {
    $apiInstance->keyTagsDelete($id);
} catch (Exception $e) {
    echo 'Exception when calling KeyTagsApi->keyTagsDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key tag id to delete | |

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

## `keyTagsGetAll()`

```php
keyTagsGetAll(): \OpenAPI\Client\Model\FNKeyTag[]
```

/api/v2/KeyTags

Gets all tags in locking system user has rights to    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyTagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->keyTagsGetAll();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeyTagsApi->keyTagsGetAll: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\FNKeyTag[]**](../Model/FNKeyTag.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keyTagsGetById()`

```php
keyTagsGetById($id): \OpenAPI\Client\Model\FNKeyTag
```

/api/v2/KeyTags/{id}

Gets tag by id    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyTagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Tag id

try {
    $result = $apiInstance->keyTagsGetById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeyTagsApi->keyTagsGetById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Tag id | |

### Return type

[**\OpenAPI\Client\Model\FNKeyTag**](../Model/FNKeyTag.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keyTagsGetTagsByFNKey()`

```php
keyTagsGetTagsByFNKey($id): \OpenAPI\Client\Model\FNKeyTag[]
```

/api/v2/Keys/{id}/KeyTags

Gets key's tags    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyTagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id

try {
    $result = $apiInstance->keyTagsGetTagsByFNKey($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeyTagsApi->keyTagsGetTagsByFNKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |

### Return type

[**\OpenAPI\Client\Model\FNKeyTag[]**](../Model/FNKeyTag.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keyTagsInsert()`

```php
keyTagsInsert($fn_key_tag)
```

/api/v2/KeyTags

Adds new tag for key    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyTagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$fn_key_tag = new \OpenAPI\Client\Model\FNKeyTag(); // \OpenAPI\Client\Model\FNKeyTag | Parameter

try {
    $apiInstance->keyTagsInsert($fn_key_tag);
} catch (Exception $e) {
    echo 'Exception when calling KeyTagsApi->keyTagsInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **fn_key_tag** | [**\OpenAPI\Client\Model\FNKeyTag**](../Model/FNKeyTag.md)| Parameter | |

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

## `keyTagsUpdate()`

```php
keyTagsUpdate($fn_key_tag)
```

/api/v2/KeyTags

Updates existing tag    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyTagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$fn_key_tag = new \OpenAPI\Client\Model\FNKeyTag(); // \OpenAPI\Client\Model\FNKeyTag | Parameter

try {
    $apiInstance->keyTagsUpdate($fn_key_tag);
} catch (Exception $e) {
    echo 'Exception when calling KeyTagsApi->keyTagsUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **fn_key_tag** | [**\OpenAPI\Client\Model\FNKeyTag**](../Model/FNKeyTag.md)| Parameter | |

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
