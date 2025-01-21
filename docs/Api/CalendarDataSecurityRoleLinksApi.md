# OpenAPI\Client\CalendarDataSecurityRoleLinksApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**calendarDataSecurityRoleLinksDeleteLinks()**](CalendarDataSecurityRoleLinksApi.md#calendarDataSecurityRoleLinksDeleteLinks) | **POST** /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks/Delete | /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks/Delete |
| [**calendarDataSecurityRoleLinksGetLinksByCalendarDataId()**](CalendarDataSecurityRoleLinksApi.md#calendarDataSecurityRoleLinksGetLinksByCalendarDataId) | **GET** /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks | /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks |
| [**calendarDataSecurityRoleLinksGetLinksBySecurityRoleId()**](CalendarDataSecurityRoleLinksApi.md#calendarDataSecurityRoleLinksGetLinksBySecurityRoleId) | **GET** /api/v2/SecurityRoles/{id}/CalendarDataSecurityRoleLinks | /api/v2/SecurityRoles/{id}/CalendarDataSecurityRoleLinks |
| [**calendarDataSecurityRoleLinksInsertLinks()**](CalendarDataSecurityRoleLinksApi.md#calendarDataSecurityRoleLinksInsertLinks) | **POST** /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks | /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks |
| [**calendarDataSecurityRoleLinksSetLinks()**](CalendarDataSecurityRoleLinksApi.md#calendarDataSecurityRoleLinksSetLinks) | **PUT** /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks | /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks |


## `calendarDataSecurityRoleLinksDeleteLinks()`

```php
calendarDataSecurityRoleLinksDeleteLinks($id, $calendar_data_security_role_links_delete_links_param)
```

/api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks/Delete

Deletes code access group links from calendar data.    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataSecurityRoleLinksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar data Id
$calendar_data_security_role_links_delete_links_param = new \OpenAPI\Client\Model\CalendarDataSecurityRoleLinksDeleteLinksParam(); // \OpenAPI\Client\Model\CalendarDataSecurityRoleLinksDeleteLinksParam | Parameter containing links which are deleted

try {
    $apiInstance->calendarDataSecurityRoleLinksDeleteLinks($id, $calendar_data_security_role_links_delete_links_param);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataSecurityRoleLinksApi->calendarDataSecurityRoleLinksDeleteLinks: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar data Id | |
| **calendar_data_security_role_links_delete_links_param** | [**\OpenAPI\Client\Model\CalendarDataSecurityRoleLinksDeleteLinksParam**](../Model/CalendarDataSecurityRoleLinksDeleteLinksParam.md)| Parameter containing links which are deleted | |

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

## `calendarDataSecurityRoleLinksGetLinksByCalendarDataId()`

```php
calendarDataSecurityRoleLinksGetLinksByCalendarDataId($id): \OpenAPI\Client\Model\CalendarDataSecurityRoleLink[]
```

/api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks

Gets links for given calendar data    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataSecurityRoleLinksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar data id

try {
    $result = $apiInstance->calendarDataSecurityRoleLinksGetLinksByCalendarDataId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataSecurityRoleLinksApi->calendarDataSecurityRoleLinksGetLinksByCalendarDataId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar data id | |

### Return type

[**\OpenAPI\Client\Model\CalendarDataSecurityRoleLink[]**](../Model/CalendarDataSecurityRoleLink.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calendarDataSecurityRoleLinksGetLinksBySecurityRoleId()`

```php
calendarDataSecurityRoleLinksGetLinksBySecurityRoleId($id): \OpenAPI\Client\Model\CalendarDataSecurityRoleLink[]
```

/api/v2/SecurityRoles/{id}/CalendarDataSecurityRoleLinks

Gets links for given code access group    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataSecurityRoleLinksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Code access group id

try {
    $result = $apiInstance->calendarDataSecurityRoleLinksGetLinksBySecurityRoleId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataSecurityRoleLinksApi->calendarDataSecurityRoleLinksGetLinksBySecurityRoleId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Code access group id | |

### Return type

[**\OpenAPI\Client\Model\CalendarDataSecurityRoleLink[]**](../Model/CalendarDataSecurityRoleLink.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calendarDataSecurityRoleLinksInsertLinks()`

```php
calendarDataSecurityRoleLinksInsertLinks($id, $calendar_data_security_role_links_insert_links_param)
```

/api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks

Adds code access group links to calendar data.    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataSecurityRoleLinksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar data Id
$calendar_data_security_role_links_insert_links_param = new \OpenAPI\Client\Model\CalendarDataSecurityRoleLinksInsertLinksParam(); // \OpenAPI\Client\Model\CalendarDataSecurityRoleLinksInsertLinksParam | Parameter containing links which are added

try {
    $apiInstance->calendarDataSecurityRoleLinksInsertLinks($id, $calendar_data_security_role_links_insert_links_param);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataSecurityRoleLinksApi->calendarDataSecurityRoleLinksInsertLinks: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar data Id | |
| **calendar_data_security_role_links_insert_links_param** | [**\OpenAPI\Client\Model\CalendarDataSecurityRoleLinksInsertLinksParam**](../Model/CalendarDataSecurityRoleLinksInsertLinksParam.md)| Parameter containing links which are added | |

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

## `calendarDataSecurityRoleLinksSetLinks()`

```php
calendarDataSecurityRoleLinksSetLinks($id, $calendar_data_security_role_links_set_links_param)
```

/api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks

Links calendar datas to code access groups.    The whole result set must be given when setting links because this method handles both adding/removing of links.    If no links are given, clears all calendar data's links.    <b>Required user rights:</b>    - Right to edit doors' calendar controls

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarDataSecurityRoleLinksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar data Id
$calendar_data_security_role_links_set_links_param = new \OpenAPI\Client\Model\CalendarDataSecurityRoleLinksSetLinksParam(); // \OpenAPI\Client\Model\CalendarDataSecurityRoleLinksSetLinksParam | Parameter containing links

try {
    $apiInstance->calendarDataSecurityRoleLinksSetLinks($id, $calendar_data_security_role_links_set_links_param);
} catch (Exception $e) {
    echo 'Exception when calling CalendarDataSecurityRoleLinksApi->calendarDataSecurityRoleLinksSetLinks: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar data Id | |
| **calendar_data_security_role_links_set_links_param** | [**\OpenAPI\Client\Model\CalendarDataSecurityRoleLinksSetLinksParam**](../Model/CalendarDataSecurityRoleLinksSetLinksParam.md)| Parameter containing links | |

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
