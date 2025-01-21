# OpenAPI\Client\KeyPhonesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**keyPhonesGetByKeyId()**](KeyPhonesApi.md#keyPhonesGetByKeyId) | **GET** /api/v2/Keys/{id}/KeyPhone | /api/v2/Keys/{id}/KeyPhone |
| [**keyPhonesSendPhoneRegistration()**](KeyPhonesApi.md#keyPhonesSendPhoneRegistration) | **POST** /api/v2/KeyPhones/{id}/ReRegister | /api/v2/KeyPhones/{id}/ReRegister |
| [**keyPhonesUpdate()**](KeyPhonesApi.md#keyPhonesUpdate) | **PUT** /api/v2/KeyPhones | /api/v2/KeyPhones |


## `keyPhonesGetByKeyId()`

```php
keyPhonesGetByKeyId($id): \OpenAPI\Client\Model\KeyPhone
```

/api/v2/Keys/{id}/KeyPhone

Returns KeyPhone information by Key id    <b>Required user rights:</b>    - Right to view key list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyPhonesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key Id

try {
    $result = $apiInstance->keyPhonesGetByKeyId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling KeyPhonesApi->keyPhonesGetByKeyId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Key Id | |

### Return type

[**\OpenAPI\Client\Model\KeyPhone**](../Model/KeyPhone.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `keyPhonesSendPhoneRegistration()`

```php
keyPhonesSendPhoneRegistration($id)
```

/api/v2/KeyPhones/{id}/ReRegister

Sends new registration message to phone. This is used for example when phone is replaced with an another phone.    <b>Required user rights:</b>    - Right to view key tools    - Right to edit keys    - Right to order keys

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyPhonesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Key Id

try {
    $apiInstance->keyPhonesSendPhoneRegistration($id);
} catch (Exception $e) {
    echo 'Exception when calling KeyPhonesApi->keyPhonesSendPhoneRegistration: ', $e->getMessage(), PHP_EOL;
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

## `keyPhonesUpdate()`

```php
keyPhonesUpdate($update_key_phone_param)
```

/api/v2/KeyPhones

Updates Key's phone information.    <b>Required user rights:</b>    - Right to view key tools    - Right to edit keys    - Right to edit key access

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\KeyPhonesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$update_key_phone_param = new \OpenAPI\Client\Model\UpdateKeyPhoneParam(); // \OpenAPI\Client\Model\UpdateKeyPhoneParam | Parameter containing phone information and key id

try {
    $apiInstance->keyPhonesUpdate($update_key_phone_param);
} catch (Exception $e) {
    echo 'Exception when calling KeyPhonesApi->keyPhonesUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **update_key_phone_param** | [**\OpenAPI\Client\Model\UpdateKeyPhoneParam**](../Model/UpdateKeyPhoneParam.md)| Parameter containing phone information and key id | |

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
