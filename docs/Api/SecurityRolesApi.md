# OpenAPI\Client\SecurityRolesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**securityRolesCanDelete()**](SecurityRolesApi.md#securityRolesCanDelete) | **GET** /api/v2/SecurityRoles/{id}/CanDelete | /api/v2/SecurityRoles/{id}/CanDelete |
| [**securityRolesDelete()**](SecurityRolesApi.md#securityRolesDelete) | **DELETE** /api/v2/SecurityRoles/{id} | /api/v2/SecurityRoles/{id} |
| [**securityRolesGetAll()**](SecurityRolesApi.md#securityRolesGetAll) | **GET** /api/v2/SecurityRoles | /api/v2/SecurityRoles |
| [**securityRolesGetById()**](SecurityRolesApi.md#securityRolesGetById) | **GET** /api/v2/SecurityRoles/{id} | /api/v2/SecurityRoles/{id} |
| [**securityRolesInsert()**](SecurityRolesApi.md#securityRolesInsert) | **POST** /api/v2/SecurityRoles | /api/v2/SecurityRoles |
| [**securityRolesUpdate()**](SecurityRolesApi.md#securityRolesUpdate) | **PUT** /api/v2/SecurityRoles | /api/v2/SecurityRoles |


## `securityRolesCanDelete()`

```php
securityRolesCanDelete($id): \OpenAPI\Client\Model\CanDeleteSecurityRole
```

/api/v2/SecurityRoles/{id}/CanDelete

Checks if security role can be deleted    <b>Required user rights:</b>    - Right to edit person roles

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->securityRolesCanDelete($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SecurityRolesApi->securityRolesCanDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\CanDeleteSecurityRole**](../Model/CanDeleteSecurityRole.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `securityRolesDelete()`

```php
securityRolesDelete($id)
```

/api/v2/SecurityRoles/{id}

Deletes security role    <b>Required user rights:</b>    - Right to edit person roles

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $apiInstance->securityRolesDelete($id);
} catch (Exception $e) {
    echo 'Exception when calling SecurityRolesApi->securityRolesDelete: ', $e->getMessage(), PHP_EOL;
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

## `securityRolesGetAll()`

```php
securityRolesGetAll(): \OpenAPI\Client\Model\SecurityRole[]
```

/api/v2/SecurityRoles

Returns all Security Roles    <b>Required user rights:</b>    - Right to view person role list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->securityRolesGetAll();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SecurityRolesApi->securityRolesGetAll: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\SecurityRole[]**](../Model/SecurityRole.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `securityRolesGetById()`

```php
securityRolesGetById($id): \OpenAPI\Client\Model\SecurityRole
```

/api/v2/SecurityRoles/{id}

Returns security role data by its ID    <b>Required user rights:</b>    - Right to view person role list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->securityRolesGetById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SecurityRolesApi->securityRolesGetById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\SecurityRole**](../Model/SecurityRole.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `securityRolesInsert()`

```php
securityRolesInsert($security_role): \OpenAPI\Client\Model\SecurityRole
```

/api/v2/SecurityRoles

Adds new security role    <b>Required user rights:</b>    - Right to edit person roles

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$security_role = new \OpenAPI\Client\Model\SecurityRole(); // \OpenAPI\Client\Model\SecurityRole

try {
    $result = $apiInstance->securityRolesInsert($security_role);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SecurityRolesApi->securityRolesInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **security_role** | [**\OpenAPI\Client\Model\SecurityRole**](../Model/SecurityRole.md)|  | |

### Return type

[**\OpenAPI\Client\Model\SecurityRole**](../Model/SecurityRole.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `securityRolesUpdate()`

```php
securityRolesUpdate($security_role)
```

/api/v2/SecurityRoles

Updates existing security role    <b>Required user rights:</b>    - Right to edit person roles

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\SecurityRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$security_role = new \OpenAPI\Client\Model\SecurityRole(); // \OpenAPI\Client\Model\SecurityRole

try {
    $apiInstance->securityRolesUpdate($security_role);
} catch (Exception $e) {
    echo 'Exception when calling SecurityRolesApi->securityRolesUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **security_role** | [**\OpenAPI\Client\Model\SecurityRole**](../Model/SecurityRole.md)|  | |

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
