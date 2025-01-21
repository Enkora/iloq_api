# OpenAPI\Client\WebhooksApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**webhooksAddSubscription()**](WebhooksApi.md#webhooksAddSubscription) | **POST** /api/v2/Webhooks/Subscriptions | /api/v2/Webhooks/Subscriptions |
| [**webhooksDeleteSubscription()**](WebhooksApi.md#webhooksDeleteSubscription) | **DELETE** /api/v2/Webhooks/Subscriptions/{id} | /api/v2/Webhooks/Subscriptions/{id} |
| [**webhooksGetEvents()**](WebhooksApi.md#webhooksGetEvents) | **GET** /api/v2/Webhooks/Events | /api/v2/Webhooks/Events |
| [**webhooksGetPayloadsForSubscription()**](WebhooksApi.md#webhooksGetPayloadsForSubscription) | **GET** /api/v2/Webhooks/Subscriptions/{id}/Payloads | /api/v2/Webhooks/Subscriptions/{id}/Payloads |
| [**webhooksGetPendingEventsForSubscription()**](WebhooksApi.md#webhooksGetPendingEventsForSubscription) | **GET** /api/v2/Webhooks/Subscriptions/{id}/PendingEvents | /api/v2/Webhooks/Subscriptions/{id}/PendingEvents |
| [**webhooksGetSubscription()**](WebhooksApi.md#webhooksGetSubscription) | **GET** /api/v2/Webhooks/Subscriptions/{id} | /api/v2/Webhooks/Subscriptions/{id} |
| [**webhooksGetSubscriptions()**](WebhooksApi.md#webhooksGetSubscriptions) | **GET** /api/v2/Webhooks/Subscriptions | /api/v2/Webhooks/Subscriptions |
| [**webhooksGetSubscriptionsWithPendingEvents()**](WebhooksApi.md#webhooksGetSubscriptionsWithPendingEvents) | **GET** /api/v2/Webhooks/Subscriptions/PendingEvents | /api/v2/Webhooks/Subscriptions/PendingEvents |
| [**webhooksGetSubscriptionsWithPendingPayloads()**](WebhooksApi.md#webhooksGetSubscriptionsWithPendingPayloads) | **GET** /api/v2/Webhooks/Subscriptions/PendingPayloads | /api/v2/Webhooks/Subscriptions/PendingPayloads |
| [**webhooksUpdateSubscription()**](WebhooksApi.md#webhooksUpdateSubscription) | **PUT** /api/v2/Webhooks/Subscriptions | /api/v2/Webhooks/Subscriptions |


## `webhooksAddSubscription()`

```php
webhooksAddSubscription($add_subscription_param)
```

/api/v2/Webhooks/Subscriptions

Adds new webhook subscription    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$add_subscription_param = new \OpenAPI\Client\Model\AddSubscriptionParam(); // \OpenAPI\Client\Model\AddSubscriptionParam

try {
    $apiInstance->webhooksAddSubscription($add_subscription_param);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksAddSubscription: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **add_subscription_param** | [**\OpenAPI\Client\Model\AddSubscriptionParam**](../Model/AddSubscriptionParam.md)|  | |

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

## `webhooksDeleteSubscription()`

```php
webhooksDeleteSubscription($id)
```

/api/v2/Webhooks/Subscriptions/{id}

Deletes webhook subscription    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $apiInstance->webhooksDeleteSubscription($id);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksDeleteSubscription: ', $e->getMessage(), PHP_EOL;
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

## `webhooksGetEvents()`

```php
webhooksGetEvents(): \OpenAPI\Client\Model\WebhookEvent[]
```

/api/v2/Webhooks/Events

Gets all supported webhook events which can be subscripted to    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->webhooksGetEvents();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksGetEvents: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\WebhookEvent[]**](../Model/WebhookEvent.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksGetPayloadsForSubscription()`

```php
webhooksGetPayloadsForSubscription($id, $state): \OpenAPI\Client\Model\Payload[]
```

/api/v2/Webhooks/Subscriptions/{id}/Payloads

Gets payloads which have the given state. Returns most recent, maximum of 1000 payloads.    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string
$state = new \OpenAPI\Client\Model\\OpenAPI\Client\Model\EventState(); // \OpenAPI\Client\Model\EventState

try {
    $result = $apiInstance->webhooksGetPayloadsForSubscription($id, $state);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksGetPayloadsForSubscription: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |
| **state** | [**\OpenAPI\Client\Model\EventState**](../Model/.md)|  | |

### Return type

[**\OpenAPI\Client\Model\Payload[]**](../Model/Payload.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksGetPendingEventsForSubscription()`

```php
webhooksGetPendingEventsForSubscription($id): \OpenAPI\Client\Model\Payload[]
```

/api/v2/Webhooks/Subscriptions/{id}/PendingEvents

Deprecated: Use Webhooks/Subscriptions/{id}/Payloads instead        Gets subscription's payloads which haven't been sent successfully.    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->webhooksGetPendingEventsForSubscription($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksGetPendingEventsForSubscription: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\Payload[]**](../Model/Payload.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksGetSubscription()`

```php
webhooksGetSubscription($id): \OpenAPI\Client\Model\Subscription
```

/api/v2/Webhooks/Subscriptions/{id}

Gets webhook subscription information    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->webhooksGetSubscription($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksGetSubscription: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\Subscription**](../Model/Subscription.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksGetSubscriptions()`

```php
webhooksGetSubscriptions(): \OpenAPI\Client\Model\Subscription[]
```

/api/v2/Webhooks/Subscriptions

Gets webhook subscriptions    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->webhooksGetSubscriptions();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksGetSubscriptions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\Subscription[]**](../Model/Subscription.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksGetSubscriptionsWithPendingEvents()`

```php
webhooksGetSubscriptionsWithPendingEvents(): \OpenAPI\Client\Model\GetSubscriptionsWithPendingPayloadsResult
```

/api/v2/Webhooks/Subscriptions/PendingEvents

Deprecated: Use Webhooks/PendingPayloads instead        Gets webhook subscriptions which have sent payloads that aren't sent successfully (state = 3 or 4).    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->webhooksGetSubscriptionsWithPendingEvents();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksGetSubscriptionsWithPendingEvents: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetSubscriptionsWithPendingPayloadsResult**](../Model/GetSubscriptionsWithPendingPayloadsResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksGetSubscriptionsWithPendingPayloads()`

```php
webhooksGetSubscriptionsWithPendingPayloads(): \OpenAPI\Client\Model\GetSubscriptionsWithPendingPayloadsResult
```

/api/v2/Webhooks/Subscriptions/PendingPayloads

Gets webhook subscriptions which have sent payloads that aren't sent successfully (state = 3 or 4).    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->webhooksGetSubscriptionsWithPendingPayloads();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksGetSubscriptionsWithPendingPayloads: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetSubscriptionsWithPendingPayloadsResult**](../Model/GetSubscriptionsWithPendingPayloadsResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksUpdateSubscription()`

```php
webhooksUpdateSubscription($add_subscription_param)
```

/api/v2/Webhooks/Subscriptions

Updates existing webhook subscription    <b>Required user rights:</b>    - Right to administrate locking system

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$add_subscription_param = new \OpenAPI\Client\Model\AddSubscriptionParam(); // \OpenAPI\Client\Model\AddSubscriptionParam

try {
    $apiInstance->webhooksUpdateSubscription($add_subscription_param);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksUpdateSubscription: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **add_subscription_param** | [**\OpenAPI\Client\Model\AddSubscriptionParam**](../Model/AddSubscriptionParam.md)|  | |

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
