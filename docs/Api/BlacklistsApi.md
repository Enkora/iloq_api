# OpenAPI\Client\BlacklistsApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**blacklistsAddKey()**](BlacklistsApi.md#blacklistsAddKey) | **POST** /api/v2/Blacklists/AddKey/{fnkeyId} | /api/v2/Blacklists/AddKey/{fnkeyId} |
| [**blacklistsCanAddKey()**](BlacklistsApi.md#blacklistsCanAddKey) | **GET** /api/v2/Blacklists/CanAddKey/{fnkeyId} | /api/v2/Blacklists/CanAddKey/{fnkeyId} |
| [**blacklistsCanOrderS40Blacklist()**](BlacklistsApi.md#blacklistsCanOrderS40Blacklist) | **GET** /api/v2/Blacklists/CanOrderS40Blacklist | /api/v2/Blacklists/CanOrderS40Blacklist |
| [**blacklistsCanRemoveKey()**](BlacklistsApi.md#blacklistsCanRemoveKey) | **GET** /api/v2/Blacklists/CanRemoveKey/{fnkeyId} | /api/v2/Blacklists/CanRemoveKey/{fnkeyId} |
| [**blacklistsGetAll()**](BlacklistsApi.md#blacklistsGetAll) | **GET** /api/v2/Blacklists | /api/v2/Blacklists |
| [**blacklistsOrderS40Blacklist()**](BlacklistsApi.md#blacklistsOrderS40Blacklist) | **POST** /api/v2/Blacklists/OrderS40Blacklist | /api/v2/Blacklists/OrderS40Blacklist |
| [**blacklistsRemoveKey()**](BlacklistsApi.md#blacklistsRemoveKey) | **DELETE** /api/v2/Blacklists/RemoveKey/{fnkeyId} | /api/v2/Blacklists/RemoveKey/{fnkeyId} |


## `blacklistsAddKey()`

```php
blacklistsAddKey($fnkey_id)
```

/api/v2/Blacklists/AddKey/{fnkeyId}

Adds a key to the blocklist. Only S50 and 5 Series keys can be added.    <b>Required user rights:</b>    - Right to view black list tools    - Right to edit black list    - Right to view black list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\BlacklistsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$fnkey_id = 'fnkey_id_example'; // string | Key which is added to blocklist

try {
    $apiInstance->blacklistsAddKey($fnkey_id);
} catch (Exception $e) {
    echo 'Exception when calling BlacklistsApi->blacklistsAddKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **fnkey_id** | **string**| Key which is added to blocklist | |

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

## `blacklistsCanAddKey()`

```php
blacklistsCanAddKey($fnkey_id): bool
```

/api/v2/Blacklists/CanAddKey/{fnkeyId}

Checks if given key can be added to the blocklist. Only S50 and 5 Series keys can be added.    If key is already in blocklist or key doesn't have any access rights, it can't be added to blocklist.    <b>Required user rights:</b>    - Right to view black list tools    - Right to edit black list    - Right to view black list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\BlacklistsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$fnkey_id = 'fnkey_id_example'; // string | Key which would be added to blocklist

try {
    $result = $apiInstance->blacklistsCanAddKey($fnkey_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BlacklistsApi->blacklistsCanAddKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **fnkey_id** | **string**| Key which would be added to blocklist | |

### Return type

**bool**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `blacklistsCanOrderS40Blacklist()`

```php
blacklistsCanOrderS40Blacklist(): \OpenAPI\Client\Model\CanOrderS40BlacklistResult
```

/api/v2/Blacklists/CanOrderS40Blacklist

Checks if blocklist can be ordered throught public web api or is iLOQ Manager and Programming device required    <b>Required user rights:</b>    - Right to view black list tools    - Right to edit black list    - Right to view black list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\BlacklistsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->blacklistsCanOrderS40Blacklist();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BlacklistsApi->blacklistsCanOrderS40Blacklist: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\CanOrderS40BlacklistResult**](../Model/CanOrderS40BlacklistResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `blacklistsCanRemoveKey()`

```php
blacklistsCanRemoveKey($fnkey_id): bool
```

/api/v2/Blacklists/CanRemoveKey/{fnkeyId}

Checks if given key can be removed from the blocklist. Only S50 and 5 Series keys can be removed.    <b>Required user rights:</b>    - Right to view black list tools    - Right to edit black list    - Right to view black list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\BlacklistsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$fnkey_id = 'fnkey_id_example'; // string | Key which would be removed from blocklist

try {
    $result = $apiInstance->blacklistsCanRemoveKey($fnkey_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BlacklistsApi->blacklistsCanRemoveKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **fnkey_id** | **string**| Key which would be removed from blocklist | |

### Return type

**bool**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `blacklistsGetAll()`

```php
blacklistsGetAll(): \OpenAPI\Client\Model\GetS40BlacklistResult
```

/api/v2/Blacklists

Returns all items in current blocklist    <b>Required user rights:</b>    - Right to view black list tools    - Right to view black list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\BlacklistsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->blacklistsGetAll();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BlacklistsApi->blacklistsGetAll: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetS40BlacklistResult**](../Model/GetS40BlacklistResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `blacklistsOrderS40Blacklist()`

```php
blacklistsOrderS40Blacklist()
```

/api/v2/Blacklists/OrderS40Blacklist

Orders blocklist    <b>Required user rights:</b>    - Right to view black list tools    - Right to edit black list    - Right to view black list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\BlacklistsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $apiInstance->blacklistsOrderS40Blacklist();
} catch (Exception $e) {
    echo 'Exception when calling BlacklistsApi->blacklistsOrderS40Blacklist: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

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

## `blacklistsRemoveKey()`

```php
blacklistsRemoveKey($fnkey_id)
```

/api/v2/Blacklists/RemoveKey/{fnkeyId}

Removes a key from the blocklist. Only S50 and 5 Series keys can be removed.    <b>Required user rights:</b>    - Right to view black list tools    - Right to edit black list    - Right to view black list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\BlacklistsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$fnkey_id = 'fnkey_id_example'; // string | Key which is removed from blocklist

try {
    $apiInstance->blacklistsRemoveKey($fnkey_id);
} catch (Exception $e) {
    echo 'Exception when calling BlacklistsApi->blacklistsRemoveKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **fnkey_id** | **string**| Key which is removed from blocklist | |

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
