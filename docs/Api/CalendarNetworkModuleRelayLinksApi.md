# OpenAPI\Client\CalendarNetworkModuleRelayLinksApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**calendarNetworkModuleRelayLinksGetLinksByCalendarId()**](CalendarNetworkModuleRelayLinksApi.md#calendarNetworkModuleRelayLinksGetLinksByCalendarId) | **GET** /api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks | /api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks |
| [**calendarNetworkModuleRelayLinksGetLinksByNetworkModuleRelayId()**](CalendarNetworkModuleRelayLinksApi.md#calendarNetworkModuleRelayLinksGetLinksByNetworkModuleRelayId) | **GET** /api/v2/NetworkModuleDeviceRelays/{id}/CalendarNetworkModuleDeviceRelayLinks | /api/v2/NetworkModuleDeviceRelays/{id}/CalendarNetworkModuleDeviceRelayLinks |
| [**calendarNetworkModuleRelayLinksSetLinks()**](CalendarNetworkModuleRelayLinksApi.md#calendarNetworkModuleRelayLinksSetLinks) | **PUT** /api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks | /api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks |


## `calendarNetworkModuleRelayLinksGetLinksByCalendarId()`

```php
calendarNetworkModuleRelayLinksGetLinksByCalendarId($id): \OpenAPI\Client\Model\CalendarNetworkModuleRelayLink[]
```

/api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks

Gets links for given calendar    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarNetworkModuleRelayLinksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Calendar id

try {
    $result = $apiInstance->calendarNetworkModuleRelayLinksGetLinksByCalendarId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CalendarNetworkModuleRelayLinksApi->calendarNetworkModuleRelayLinksGetLinksByCalendarId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Calendar id | |

### Return type

[**\OpenAPI\Client\Model\CalendarNetworkModuleRelayLink[]**](../Model/CalendarNetworkModuleRelayLink.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calendarNetworkModuleRelayLinksGetLinksByNetworkModuleRelayId()`

```php
calendarNetworkModuleRelayLinksGetLinksByNetworkModuleRelayId($id): \OpenAPI\Client\Model\CalendarNetworkModuleRelayLink[]
```

/api/v2/NetworkModuleDeviceRelays/{id}/CalendarNetworkModuleDeviceRelayLinks

Gets links for given network module device relay    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarNetworkModuleRelayLinksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Network module device relay id

try {
    $result = $apiInstance->calendarNetworkModuleRelayLinksGetLinksByNetworkModuleRelayId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CalendarNetworkModuleRelayLinksApi->calendarNetworkModuleRelayLinksGetLinksByNetworkModuleRelayId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Network module device relay id | |

### Return type

[**\OpenAPI\Client\Model\CalendarNetworkModuleRelayLink[]**](../Model/CalendarNetworkModuleRelayLink.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calendarNetworkModuleRelayLinksSetLinks()`

```php
calendarNetworkModuleRelayLinksSetLinks($id, $calendar_network_module_device_relay_links_set_links_param)
```

/api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks

Links calendars to network module device relays.    The whole result set must be given when setting links because this method handles both adding/removing of links.    If no links are given, clears all calendar's links.    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\CalendarNetworkModuleRelayLinksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string
$calendar_network_module_device_relay_links_set_links_param = new \OpenAPI\Client\Model\CalendarNetworkModuleDeviceRelayLinksSetLinksParam(); // \OpenAPI\Client\Model\CalendarNetworkModuleDeviceRelayLinksSetLinksParam | Parameter containing links

try {
    $apiInstance->calendarNetworkModuleRelayLinksSetLinks($id, $calendar_network_module_device_relay_links_set_links_param);
} catch (Exception $e) {
    echo 'Exception when calling CalendarNetworkModuleRelayLinksApi->calendarNetworkModuleRelayLinksSetLinks: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |
| **calendar_network_module_device_relay_links_set_links_param** | [**\OpenAPI\Client\Model\CalendarNetworkModuleDeviceRelayLinksSetLinksParam**](../Model/CalendarNetworkModuleDeviceRelayLinksSetLinksParam.md)| Parameter containing links | |

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
