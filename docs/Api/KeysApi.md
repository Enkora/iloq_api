# OpenAPI\Client\KeysApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**keysCanAddSecurityAccess()**](KeysApi.md#keysCanAddSecurityAccess) | **GET** /api/v2/Keys/{id}/SecurityAccesses/CanAdd | /api/v2/Keys/{id}/SecurityAccesses/CanAdd |
| [**keysCanAddTimeLimitTitle()**](KeysApi.md#keysCanAddTimeLimitTitle) | **POST** /api/v2/Keys/{id}/TimeLimitTitles/CanAdd | /api/v2/Keys/{id}/TimeLimitTitles/CanAdd |
| [**keysCanAddTimeLimitTitleObsolete()**](KeysApi.md#keysCanAddTimeLimitTitleObsolete) | **GET** /api/v2/Keys/{id}/TimeLimitTitles/CanAdd | /api/v2/Keys/{id}/TimeLimitTitles/CanAdd |
| [**keysCanDeleteKey()**](KeysApi.md#keysCanDeleteKey) | **GET** /api/v2/Keys/{id}/CanDelete | /api/v2/Keys/{id}/CanDelete |
| [**keysCanDeleteSecurityAccess()**](KeysApi.md#keysCanDeleteSecurityAccess) | **GET** /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete | /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete |
| [**keysCanOrderKey()**](KeysApi.md#keysCanOrderKey) | **GET** /api/v2/Keys/{id}/CanOrder | /api/v2/Keys/{id}/CanOrder |
| [**keysCanReturnKey()**](KeysApi.md#keysCanReturnKey) | **GET** /api/v2/Keys/{id}/CanReturn | /api/v2/Keys/{id}/CanReturn |
| [**keysCanUpdateKeyMainZone()**](KeysApi.md#keysCanUpdateKeyMainZone) | **GET** /api/v2/Keys/{id}/CanUpdateMainZone | /api/v2/Keys/{id}/CanUpdateMainZone |
| [**keysDelete()**](KeysApi.md#keysDelete) | **DELETE** /api/v2/Keys/{id} | /api/v2/Keys/{id} |
| [**keysDeleteSecurityAccess()**](KeysApi.md#keysDeleteSecurityAccess) | **DELETE** /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId} | /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId} |
| [**keysDeleteTimeLimit()**](KeysApi.md#keysDeleteTimeLimit) | **DELETE** /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} | /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} |
| [**keysGetAllKeys()**](KeysApi.md#keysGetAllKeys) | **GET** /api/v2/Keys | /api/v2/Keys |
| [**keysGetKey()**](KeysApi.md#keysGetKey) | **GET** /api/v2/Keys/{id} | /api/v2/Keys/{id} |
| [**keysGetKeyLocationReportingInAuditTrail()**](KeysApi.md#keysGetKeyLocationReportingInAuditTrail) | **GET** /api/v2/Keys/{id}/LocationReporting | /api/v2/Keys/{id}/LocationReporting |
| [**keysGetKeysByPerson()**](KeysApi.md#keysGetKeysByPerson) | **GET** /api/v2/Persons/{id}/Keys | /api/v2/Persons/{id}/Keys |
| [**keysGetKeysByRomIds()**](KeysApi.md#keysGetKeysByRomIds) | **GET** /api/v2/Keys/GetByRomIds | /api/v2/Keys/GetByRomIds |
| [**keysGetSecurityAccesses()**](KeysApi.md#keysGetSecurityAccesses) | **GET** /api/v2/Keys/{id}/SecurityAccesses | /api/v2/Keys/{id}/SecurityAccesses |
| [**keysGetTimeLimit()**](KeysApi.md#keysGetTimeLimit) | **GET** /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} | /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} |
| [**keysGetTimeLimits()**](KeysApi.md#keysGetTimeLimits) | **GET** /api/v2/Keys/{id}/TimeLimitTitles | /api/v2/Keys/{id}/TimeLimitTitles |
| [**keysGetZones()**](KeysApi.md#keysGetZones) | **GET** /api/v2/Keys/{id}/Zones | /api/v2/Keys/{id}/Zones |
| [**keysInsert()**](KeysApi.md#keysInsert) | **POST** /api/v2/Keys | /api/v2/Keys |
| [**keysInsertSecurityAccess()**](KeysApi.md#keysInsertSecurityAccess) | **POST** /api/v2/Keys/{id}/SecurityAccesses | /api/v2/Keys/{id}/SecurityAccesses |
| [**keysInsertTimeLimitTitle()**](KeysApi.md#keysInsertTimeLimitTitle) | **POST** /api/v2/Keys/{id}/TimeLimitTitles | /api/v2/Keys/{id}/TimeLimitTitles |
| [**keysOrderKey()**](KeysApi.md#keysOrderKey) | **POST** /api/v2/Keys/{id}/Order | /api/v2/Keys/{id}/Order |
| [**keysReturnKey()**](KeysApi.md#keysReturnKey) | **POST** /api/v2/Keys/{id}/Return | /api/v2/Keys/{id}/Return |
| [**keysSetKeyLocationReportingInAuditTrail()**](KeysApi.md#keysSetKeyLocationReportingInAuditTrail) | **PUT** /api/v2/Keys/{id}/LocationReporting | /api/v2/Keys/{id}/LocationReporting |
| [**keysUpdate()**](KeysApi.md#keysUpdate) | **PUT** /api/v2/Keys | /api/v2/Keys |
| [**keysUpdateMainZone()**](KeysApi.md#keysUpdateMainZone) | **PUT** /api/v2/Keys/{id}/UpdateMainZone | /api/v2/Keys/{id}/UpdateMainZone |
| [**keysUpdateSecurityAccesses()**](KeysApi.md#keysUpdateSecurityAccesses) | **PUT** /api/v2/Keys/{id}/SecurityAccesses | /api/v2/Keys/{id}/SecurityAccesses |
| [**keysUpdateTimeLimit()**](KeysApi.md#keysUpdateTimeLimit) | **PUT** /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} | /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} |


## `keysCanAddSecurityAccess()`

```php
keysCanAddSecurityAccess($id): \OpenAPI\Client\Model\CanAddSecurityAccessLink
```

/api/v2/Keys/{id}/SecurityAccesses/CanAdd

Checks if new security accesses can be added to the key    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id

try {
    $result = $apiInstance->keysCanAddSecurityAccess($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysCanAddSecurityAccess: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |

### Return type

[**\OpenAPI\Client\Model\CanAddSecurityAccessLink**](../Model/CanAddSecurityAccessLink.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysCanAddTimeLimitTitle()`

```php
keysCanAddTimeLimitTitle($id, $insert_key_time_limit_slot_param): \OpenAPI\Client\Model\CanAddTimeLimit
```

/api/v2/Keys/{id}/TimeLimitTitles/CanAdd

Checks if time limit can be added to the key    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string
$insert_key_time_limit_slot_param = new \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam(); // \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam

try {
    $result = $apiInstance->keysCanAddTimeLimitTitle($id, $insert_key_time_limit_slot_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysCanAddTimeLimitTitle: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |
| **insert_key_time_limit_slot_param** | [**\OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam**](../Model/InsertKeyTimeLimitSlotParam.md)|  | |

### Return type

[**\OpenAPI\Client\Model\CanAddTimeLimit**](../Model/CanAddTimeLimit.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysCanAddTimeLimitTitleObsolete()`

```php
keysCanAddTimeLimitTitleObsolete($id, $insert_key_time_limit_slot_param): \OpenAPI\Client\Model\CanAddTimeLimit
```

/api/v2/Keys/{id}/TimeLimitTitles/CanAdd

Checks if time limit can be added to the key    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string
$insert_key_time_limit_slot_param = new \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam(); // \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam

try {
    $result = $apiInstance->keysCanAddTimeLimitTitleObsolete($id, $insert_key_time_limit_slot_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysCanAddTimeLimitTitleObsolete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |
| **insert_key_time_limit_slot_param** | [**\OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam**](../Model/InsertKeyTimeLimitSlotParam.md)|  | |

### Return type

[**\OpenAPI\Client\Model\CanAddTimeLimit**](../Model/CanAddTimeLimit.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysCanDeleteKey()`

```php
keysCanDeleteKey($id): \OpenAPI\Client\Model\CanDeleteKeyResult
```

/api/v2/Keys/{id}/CanDelete

Checks if key can be deleted.    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id

try {
    $result = $apiInstance->keysCanDeleteKey($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysCanDeleteKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |

### Return type

[**\OpenAPI\Client\Model\CanDeleteKeyResult**](../Model/CanDeleteKeyResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysCanDeleteSecurityAccess()`

```php
keysCanDeleteSecurityAccess($id, $security_access_id): \OpenAPI\Client\Model\CanDeleteSecurityAccessLink
```

/api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete

Checks if new security accesses can be added to the key    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id
$security_access_id = 'security_access_id_example'; // string | Security access id

try {
    $result = $apiInstance->keysCanDeleteSecurityAccess($id, $security_access_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysCanDeleteSecurityAccess: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |
| **security_access_id** | **string**| Security access id | |

### Return type

[**\OpenAPI\Client\Model\CanDeleteSecurityAccessLink**](../Model/CanDeleteSecurityAccessLink.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysCanOrderKey()`

```php
keysCanOrderKey($id): \OpenAPI\Client\Model\CanOrderKeyResultType
```

/api/v2/Keys/{id}/CanOrder

Checks if key can be ordered.    Only S50 Phone keys and S5 Series keys can be ordered using this public API.    <b>Required user rights:</b>    - Right to order keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key Id

try {
    $result = $apiInstance->keysCanOrderKey($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysCanOrderKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key Id | |

### Return type

[**\OpenAPI\Client\Model\CanOrderKeyResultType**](../Model/CanOrderKeyResultType.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysCanReturnKey()`

```php
keysCanReturnKey($id): \OpenAPI\Client\Model\CanReturnKeyResultType
```

/api/v2/Keys/{id}/CanReturn

Checks if key can be returned.    Only S50 Phone keys can be returned using this public API and only if the key doesn't have anything else but API access rights.    <b>Requires at least one of the following user rights:</b>    - Right to handle key returns    - Right to order keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->keysCanReturnKey($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysCanReturnKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\CanReturnKeyResultType**](../Model/CanReturnKeyResultType.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysCanUpdateKeyMainZone()`

```php
keysCanUpdateKeyMainZone($id): \OpenAPI\Client\Model\CanUpdateKeyMainZoneResult
```

/api/v2/Keys/{id}/CanUpdateMainZone

Checks if key's main zone can be updated.    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->keysCanUpdateKeyMainZone($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysCanUpdateKeyMainZone: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\CanUpdateKeyMainZoneResult**](../Model/CanUpdateKeyMainZoneResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysDelete()`

```php
keysDelete($id)
```

/api/v2/Keys/{id}

Deletes given key. Key can be deleted if it hasn't been given to programming, programmed or blocklisted. If key has been programmed, use return endpoint instead.    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id to delete

try {
    $apiInstance->keysDelete($id);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id to delete | |

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

## `keysDeleteSecurityAccess()`

```php
keysDeleteSecurityAccess($id, $security_access_id)
```

/api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}

Deletes key's security access rule    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id
$security_access_id = 'security_access_id_example'; // string | Security access's id

try {
    $apiInstance->keysDeleteSecurityAccess($id, $security_access_id);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysDeleteSecurityAccess: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |
| **security_access_id** | **string**| Security access&#39;s id | |

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

## `keysDeleteTimeLimit()`

```php
keysDeleteTimeLimit($id, $time_limit_title_id)
```

/api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}

Deletes time limit from the key    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id
$time_limit_title_id = 'time_limit_title_id_example'; // string | Time limit to be deleted

try {
    $apiInstance->keysDeleteTimeLimit($id, $time_limit_title_id);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysDeleteTimeLimit: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |
| **time_limit_title_id** | **string**| Time limit to be deleted | |

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

## `keysGetAllKeys()`

```php
keysGetAllKeys(): \OpenAPI\Client\Model\Key[]
```

/api/v2/Keys

Gets all keys in locking system user has rights to    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->keysGetAllKeys();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetAllKeys: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\Key[]**](../Model/Key.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysGetKey()`

```php
keysGetKey($id): \OpenAPI\Client\Model\Key
```

/api/v2/Keys/{id}

Gets key information by key id    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id

try {
    $result = $apiInstance->keysGetKey($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |

### Return type

[**\OpenAPI\Client\Model\Key**](../Model/Key.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysGetKeyLocationReportingInAuditTrail()`

```php
keysGetKeyLocationReportingInAuditTrail($id): \OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult
```

/api/v2/Keys/{id}/LocationReporting

Query if phone key records the last known valid location of mobile device to audit trail during lock open event.    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id

try {
    $result = $apiInstance->keysGetKeyLocationReportingInAuditTrail($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetKeyLocationReportingInAuditTrail: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |

### Return type

[**\OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult**](../Model/PublicApiGetKeyLocationReportingInAuditTrailQueryResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysGetKeysByPerson()`

```php
keysGetKeysByPerson($id): \OpenAPI\Client\Model\GetKeysByPersonResult
```

/api/v2/Persons/{id}/Keys

Gets keys linked to the given person by person id    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Person id

try {
    $result = $apiInstance->keysGetKeysByPerson($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetKeysByPerson: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Person id | |

### Return type

[**\OpenAPI\Client\Model\GetKeysByPersonResult**](../Model/GetKeysByPersonResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysGetKeysByRomIds()`

```php
keysGetKeysByRomIds($rom_ids): \OpenAPI\Client\Model\Key[]
```

/api/v2/Keys/GetByRomIds

Gets key informations by keys' rom ids    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$rom_ids = array('rom_ids_example'); // string[] | Rom ids

try {
    $result = $apiInstance->keysGetKeysByRomIds($rom_ids);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetKeysByRomIds: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **rom_ids** | [**string[]**](../Model/string.md)| Rom ids | [optional] |

### Return type

[**\OpenAPI\Client\Model\Key[]**](../Model/Key.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysGetSecurityAccesses()`

```php
keysGetSecurityAccesses($id, $mode): \OpenAPI\Client\Model\GetKeySecurityAccessesResult
```

/api/v2/Keys/{id}/SecurityAccesses

Gets key's security accesses    <b>Requires at least one of the following user rights:</b>    - Right to view key list    - Right to edit keys    - Right to view security access list    - Right to edit security accesses    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id
$mode = new \OpenAPI\Client\Model\\OpenAPI\Client\Model\GetSecurityAccessesView(); // \OpenAPI\Client\Model\GetSecurityAccessesView

try {
    $result = $apiInstance->keysGetSecurityAccesses($id, $mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetSecurityAccesses: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |
| **mode** | [**\OpenAPI\Client\Model\GetSecurityAccessesView**](../Model/.md)|  | |

### Return type

[**\OpenAPI\Client\Model\GetKeySecurityAccessesResult**](../Model/GetKeySecurityAccessesResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysGetTimeLimit()`

```php
keysGetTimeLimit($id, $time_limit_title_id): \OpenAPI\Client\Model\KeyTimeLimitSlot
```

/api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}

Gets key's time limit    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id
$time_limit_title_id = 'time_limit_title_id_example'; // string | Time limit title id

try {
    $result = $apiInstance->keysGetTimeLimit($id, $time_limit_title_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetTimeLimit: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |
| **time_limit_title_id** | **string**| Time limit title id | |

### Return type

[**\OpenAPI\Client\Model\KeyTimeLimitSlot**](../Model/KeyTimeLimitSlot.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysGetTimeLimits()`

```php
keysGetTimeLimits($id, $mode): \OpenAPI\Client\Model\GetTimeLimitsResult
```

/api/v2/Keys/{id}/TimeLimitTitles

Returns key's time limits    <b>Requires at least one of the following user rights:</b>    - Right to edit keys    - Right to view security access list    - Right to edit security accesses    - Right to edit key access    - Right to browse lock list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key Id
$mode = new \OpenAPI\Client\Model\\OpenAPI\Client\Model\GetTimeLimitsView(); // \OpenAPI\Client\Model\GetTimeLimitsView

try {
    $result = $apiInstance->keysGetTimeLimits($id, $mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetTimeLimits: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key Id | |
| **mode** | [**\OpenAPI\Client\Model\GetTimeLimitsView**](../Model/.md)|  | |

### Return type

[**\OpenAPI\Client\Model\GetTimeLimitsResult**](../Model/GetTimeLimitsResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysGetZones()`

```php
keysGetZones($id): \OpenAPI\Client\Model\GetZonesResult
```

/api/v2/Keys/{id}/Zones

Gets all keys in locking system user has rights to    <b>Requires at least one of the following user rights:</b>    - Right to view key list    - Right to view zone list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->keysGetZones($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysGetZones: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\GetZonesResult**](../Model/GetZonesResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysInsert()`

```php
keysInsert($insert_key_param): \OpenAPI\Client\Model\Key
```

/api/v2/Keys

Adds new key    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$insert_key_param = new \OpenAPI\Client\Model\InsertKeyParam(); // \OpenAPI\Client\Model\InsertKeyParam | Parameter

try {
    $result = $apiInstance->keysInsert($insert_key_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **insert_key_param** | [**\OpenAPI\Client\Model\InsertKeyParam**](../Model/InsertKeyParam.md)| Parameter | |

### Return type

[**\OpenAPI\Client\Model\Key**](../Model/Key.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keysInsertSecurityAccess()`

```php
keysInsertSecurityAccess($id, $add_security_access_param)
```

/api/v2/Keys/{id}/SecurityAccesses

Inserts new key's security access rule    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id
$add_security_access_param = new \OpenAPI\Client\Model\AddSecurityAccessParam(); // \OpenAPI\Client\Model\AddSecurityAccessParam

try {
    $apiInstance->keysInsertSecurityAccess($id, $add_security_access_param);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysInsertSecurityAccess: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |
| **add_security_access_param** | [**\OpenAPI\Client\Model\AddSecurityAccessParam**](../Model/AddSecurityAccessParam.md)|  | |

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

## `keysInsertTimeLimitTitle()`

```php
keysInsertTimeLimitTitle($id, $insert_key_time_limit_slot_param)
```

/api/v2/Keys/{id}/TimeLimitTitles

Adds a new timelimit to the key    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string
$insert_key_time_limit_slot_param = new \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam(); // \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam

try {
    $apiInstance->keysInsertTimeLimitTitle($id, $insert_key_time_limit_slot_param);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysInsertTimeLimitTitle: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |
| **insert_key_time_limit_slot_param** | [**\OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam**](../Model/InsertKeyTimeLimitSlotParam.md)|  | |

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

## `keysOrderKey()`

```php
keysOrderKey($id)
```

/api/v2/Keys/{id}/Order

Orders key.    Only S50 Phone keys and 5 Series keys can be ordered using this public API.    <b>Required user rights:</b>    - Right to order keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key Id

try {
    $apiInstance->keysOrderKey($id);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysOrderKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key Id | |

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

## `keysReturnKey()`

```php
keysReturnKey($id)
```

/api/v2/Keys/{id}/Return

Order return task for key.    Only S50 Phone keys can be returned using this public API and only if the keys don't have anything else but API access rights.    <b>Requires at least one of the following user rights:</b>    - Right to handle key returns    - Right to order keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $apiInstance->keysReturnKey($id);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysReturnKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

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

## `keysSetKeyLocationReportingInAuditTrail()`

```php
keysSetKeyLocationReportingInAuditTrail($id, $public_api_set_key_location_reporting_in_audit_trail_param)
```

/api/v2/Keys/{id}/LocationReporting

Set if you want phone key to record the last known valid location of mobile device to audit trail during lock open event.    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id of phone key
$public_api_set_key_location_reporting_in_audit_trail_param = new \OpenAPI\Client\Model\PublicApiSetKeyLocationReportingInAuditTrailParam(); // \OpenAPI\Client\Model\PublicApiSetKeyLocationReportingInAuditTrailParam

try {
    $apiInstance->keysSetKeyLocationReportingInAuditTrail($id, $public_api_set_key_location_reporting_in_audit_trail_param);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysSetKeyLocationReportingInAuditTrail: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id of phone key | |
| **public_api_set_key_location_reporting_in_audit_trail_param** | [**\OpenAPI\Client\Model\PublicApiSetKeyLocationReportingInAuditTrailParam**](../Model/PublicApiSetKeyLocationReportingInAuditTrailParam.md)|  | |

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

## `keysUpdate()`

```php
keysUpdate($update_key_param, $update_version_code)
```

/api/v2/Keys

Updates existing key    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$update_key_param = new \OpenAPI\Client\Model\UpdateKeyParam(); // \OpenAPI\Client\Model\UpdateKeyParam | Parameter
$update_version_code = false; // bool

try {
    $apiInstance->keysUpdate($update_key_param, $update_version_code);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **update_key_param** | [**\OpenAPI\Client\Model\UpdateKeyParam**](../Model/UpdateKeyParam.md)| Parameter | |
| **update_version_code** | **bool**|  | [optional] [default to false] |

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

## `keysUpdateMainZone()`

```php
keysUpdateMainZone($id, $update_key_main_zone_param)
```

/api/v2/Keys/{id}/UpdateMainZone

Updates key's main zone. In use in 5 series systems.    <b>Required user rights:</b>    - Right to edit keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string
$update_key_main_zone_param = new \OpenAPI\Client\Model\UpdateKeyMainZoneParam(); // \OpenAPI\Client\Model\UpdateKeyMainZoneParam

try {
    $apiInstance->keysUpdateMainZone($id, $update_key_main_zone_param);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysUpdateMainZone: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |
| **update_key_main_zone_param** | [**\OpenAPI\Client\Model\UpdateKeyMainZoneParam**](../Model/UpdateKeyMainZoneParam.md)|  | |

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

## `keysUpdateSecurityAccesses()`

```php
keysUpdateSecurityAccesses($id, $update_key_security_accesses_param)
```

/api/v2/Keys/{id}/SecurityAccesses

Updates key's security accesses and time limits    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id
$update_key_security_accesses_param = new \OpenAPI\Client\Model\UpdateKeySecurityAccessesParam(); // \OpenAPI\Client\Model\UpdateKeySecurityAccessesParam

try {
    $apiInstance->keysUpdateSecurityAccesses($id, $update_key_security_accesses_param);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysUpdateSecurityAccesses: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |
| **update_key_security_accesses_param** | [**\OpenAPI\Client\Model\UpdateKeySecurityAccessesParam**](../Model/UpdateKeySecurityAccessesParam.md)|  | |

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

## `keysUpdateTimeLimit()`

```php
keysUpdateTimeLimit($id, $time_limit_title_id, $update_key_time_limit_slot_param)
```

/api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}

Updates key's timelimit    <b>Required user rights:</b>    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key id
$time_limit_title_id = 'time_limit_title_id_example'; // string | Time limit title id
$update_key_time_limit_slot_param = new \OpenAPI\Client\Model\UpdateKeyTimeLimitSlotParam(); // \OpenAPI\Client\Model\UpdateKeyTimeLimitSlotParam

try {
    $apiInstance->keysUpdateTimeLimit($id, $time_limit_title_id, $update_key_time_limit_slot_param);
} catch (Exception $e) {
    echo 'Exception when calling KeysApi->keysUpdateTimeLimit: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key id | |
| **time_limit_title_id** | **string**| Time limit title id | |
| **update_key_time_limit_slot_param** | [**\OpenAPI\Client\Model\UpdateKeyTimeLimitSlotParam**](../Model/UpdateKeyTimeLimitSlotParam.md)|  | |

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
