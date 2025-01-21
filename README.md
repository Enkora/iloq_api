# OpenAPIClient-php

Public API for iLOQ 5 Series locking system.


# Introduction
This is OpenApi documentation for iLOQ Public API. 

Service is REST (Representational state transfer). 
Protocol used to transport the data is HTTP and JSON is used for data transfer.

Below is important information and notes about some business related concepts that have already been covered in you iLOQ training.

## Calendar reservations

Below is a chart that illustrates relations between calendars and network module components. 
![Calendar chart](/iLOQPublicApiDoc/images/iLOQ_API_Chart.png)

## Time limits

<h3> General information </h3>

Time limits are used to define when a key has access to a lock. Time limits are stored in the key.

Terms explained
 * Time limit slot is a memory slot in a key.
 * Time profile is a time limit slot that has a weekly clock.
 * Time limit title is a preconfigured time profile that can be added to a key
 * Time limit data is the weekly clock of a time profile

<h4> Time limit slot </h4>
A key's time limit slot is either the key's start date, end date or a time profile added to the key.
 
<h4> Time profile</h4>
Time profile need to be preconfigured in the locking system before it can be added to a key.
This is done by creating a TimeLimitTitle.
When adding time profiles to a key, you need to provide the TimeLimitTitle_ID of the preconfigured time profile you want to add.
Time profiles can be either fixed or editable.
 <li>Fixed time profiles cannot be modified as they are being added to the key. </li>
 <li>Editable time profiles can be modified as they are being added to the key.</li>
    
When adding fixed time profiles, the TimeLimitTitle start- and end dates and the weekly clocks need to be set with identical values to the preconfigured time profile.
 * The weekly clock start- and end times are in milliseconds. You will need to convert the time to milliseconds when adding time profiles to a key.
 
<h4> Time limit title</h4>
Time limit title can be either a fixed or editable time profile.
You need to create a time limit title before you can add time profiles to a key.

**[POST /api/v2/TimeLimitTitles](#operation/TimeLimitTitles_Insert)**.

<h4> Time limit data</h4>
Time limit data is the weekly clock of a time profile.
Do not add time limit data to a time limit slots 0 or 1.


<h3>Limitations to be considered</h3>

Take into account that physical key has hardware limitations. 
Depending on locks versions, keys have max 10 up to 23 memory slots. This limits how many time limits can be stored to the key.
C5 locks require minimum firmware version 138 and D5 locks require minimum firmware version 135 to support over 10 time limits.

Memory slot usage
* Start date takes one slot 
* End date takes one slot 
* Time profiles can take multiple slots
    * Time profile start date takes one slot
    * Time profile end date takes one slot
    * Each time limit data takes one slot

<h3> Key start date and end date -- slots 0 and 1 </h3>

Key's start and end date are stored in slots 0 and 1. These slots cannot be modified with any other endpoint than **[PUT /api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)**.

Common use cases:
- An employee's employment start and end date. 
- The time period when a technician has access to a certain site.
- A simple calendar reservations. For example, a single sports hall reservation on Friday 20.10.2023 from 19:00 to 23:00.

Example payload
```
{
    \"TimeLimitSlots\": [
        {
            \"LimitDateLg\": \"2022-05-01T10:00:00\",
            \"SlotNo\": 0
        },
        {
            \"LimitDateLg\": \"2022-06-30T18:00:00\",
            \"SlotNo\": 1
        }
    ]
}
```


<h3>Key time profiles -- slot 2</h3>

Common use cases are for example:
- Key holder makes a reservation in the calendar of a third party system and a time profile is added to the key. Time profile has start and end time.
- Recurring calendar reservation. In addition to start and end time, a weekly clock is added to the time profile.
- An employee transfered to a remote office for several days, but having access to office only on weekdays during office hours 08:00-16:00.
- Access to an office is limited to weekdays between 07:00 and 17:00.

Example payload
```
{
  \"TimeLimitSlots\": [
        {
            \"SlotNo\": 2,
   \"TimeLimitTitle_ID\":\"84c737d4-121e-4e4b-87f1-0d869a3fb161\",
   \"TimeLimitData\": [
    {
     \"EndTimeMS\": 62100000,
     \"StartTimeMS\": 31500000,
     \"WeekDayMask\": 16
    },
    {
     \"EndTimeMS\": 57600000,
     \"StartTimeMS\": 28800000,
     \"WeekDayMask\": 31
    }
            ]
        }
    ]
}
```

Example payload with start and end dates, fixed and editable time profiles.
```
{
    \"TimeLimitSlots\": [
        {
            \"SlotNo\": 2,
            \"TimeLimitData\": [
                {
                    \"WeekDayMask\": 31,
                    \"StartTimeMS\": 32400000,
                    \"EndTimeMS\": 61200000
                }
            ],
            \"TimeLimitTitle_ID\": \"a4da99c5-102e-46f8-a64b-a51bcd5cb42b\",
            \"TimeLimitTitleEndDateLg\": \"2022-06-15T19:30:00\",
            \"TimeLimitTitleStartDateLg\": \"2022-06-01T04:00:00\"
        },
        {
            \"SlotNo\": 2,
            \"TimeLimitData\": [
                {
                    \"WeekDayMask\": 31,
                    \"EndTimeMS\": 57600000,
                    \"StartTimeMS\": 28800000                    
                }
            ],
            \"TimeLimitTitle_ID\": \"103287c6-0757-4dec-b993-7b3fd616ae77\",
        },
        {
            \"LimitDateLg\": \"2022-05-01T10:00:00\",
            \"SlotNo\": 0,
        },
        {
            \"LimitDateLg\": \"2022-06-30T18:00:00\",
            \"SlotNo\": 1,
        }
    ]
}
```

Notes:
- Remember to use correct slot numbers. SlotNo 0 is for start date, SlotNo 1 is for end date and SlotNo 2 is for time profiles.
- Request datetimes in format \"yyyy-MM-ddTHH:mm:ss\" using in locking system time zone.
- When editing time limit slots using **[PUT /api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)** endpoint, remember to include all the needed slots, including start date, end date and time profiles. <b>All the ones you omit will be deleted from the key.</b>
    * Also, remember to include any used security access ids in the SecurityAccessIds array. <b>Otherwise they will be deleted from the key.</b>
- For complex time limit configurations try use iLOQ 5 Series Manager create these time limits. Then request **[GET Keys/{id}/TimeLimitTitles](#operation/Keys_GetTimeLimits)** to see how payloads of keys' time profiles should be defined.

## Phone keys

Phone keys can be created and programming tasks ordered through Public API. 
Phone S50 app gets the programming task, programs itself, reports to server and after that, phone key is programmed. 


### Creating a new phone key to locking system

First create a new phone key by requesting **[POST api/v2/Keys](#operation/Keys_Insert)**.  <br>
KeyTypeMask for phone key is 6 (S50 + PhoneKey). 

Then update phone key information with phone number or email for registration SMS or email by requesting **[PUT api/v2/KeyPhones](#operation/KeyPhones_Update)**.


### Setting main zone for the phone key

Check if main zone can be updated to the key by calling **[GET api/v2/Keys/{id}/CanUpdateMainZone](#operation/Keys_CanUpdateKeyMainZone)**. <br> 
If main zone can be updated, update by calling **[POST api/v2/Keys/{id}/UpdateMainZone](#operation/Keys_UpdateKeyMainZone)**.


### Adding access rights and time profiles for the phone key

Check first if access right can be added to the key by **[GET api/v2/Keys/{id}/SecurityAccesses/CanAdd](#operation/Keys_CanAddSecurityAccess)**.  <br> 
Add access rights by calling **[POST api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_InsertSecurityAccess)**. <br>

Check first if time profile can be added to the key by **[POST api/v2/Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**.  <br> 
Add time profiles by calling **[POST api/v2/Keys/{id}/TimeLimitTitles](#operation/Keys_InsertTimeLimitTitle)**.


### First time registration and ordering programming task

Check if programming can be ordered through API by calling **[GET api/v2/Keys/{id}/CanOrder](#operation/Keys_CanOrderKey)**.   <br> 
Do this step always before ordering programming task. <br> 
Order programming task for this new key by calling **[POST api/v2/Keys/{id}/Order](#operation/Keys_OrderKey)**. 


## External RFID tag keys

External RFID tag keys can be created and instantly programmed on server side through Public API. 

### Creating a new external tag key to locking system

First create a new external tag key by requesting **[POST api/v2/Keys](#operation/Keys_Insert)**. <br>  
When creating a new key, KeyTypeMask for external RFID tag key is 384 (5 Series + Other than iLoq physical key). 

### Setting main zone for the external tag key

Check if main zone can be updated to the key by calling **[GET api/v2/Keys/{id}/CanUpdateMainZone](#operation/Keys_CanUpdateKeyMainZone)**. <br> 
If main zone can be updated, update by calling **[POST api/v2/Keys/{id}/UpdateMainZone](#operation/Keys_UpdateKeyMainZone)**.


### Adding access rights and time profiles for the external tag key

Check first if access right can be added to the key by **[GET api/v2/Keys/{id}/SecurityAccesses/CanAdd](#operation/Keys_CanAddSecurityAccess)**.  <br> 
Add access rights by calling **[POST api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_InsertSecurityAccess)**. <br>

Check first if time profile can be added to the key by **[POST api/v2/Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**.  <br> 
Add time profiles by calling **[POST api/v2/Keys/{id}/TimeLimitTitles](#operation/Keys_InsertTimeLimitTitle)**.


### Program the external RFID tag key

Check if programming can be ordered through API by calling **[GET api/v2/Keys/{id}/CanOrder](#operation/Keys_CanOrderKey)**.   <br> 
Do this step always before ordering programming task. <br> 
Order programming task for this new key by calling **[POST api/v2/Keys/{id}/Order](#operation/Keys_OrderKey)**.

RFID external tg gets programmed on the server side and is ready to use. After programming, KeyTypeMask for external RFID tag key is 400 (5 Series + Other than iLoq physical key + Classic Mifare rfid). 

## Returning the keys through API

Only S50 phone keys external RFID tag keys can be returned through API. Other types of keys require iLOQ 5 series Manager + programming key to return. Returning the key through API also deletes it from system. 
Returning the key does not require separate **DELETE api/v2/Keys/{id}** request. 

You can check if key can be returned through API by calling  **[GET api/v2/Keys/{id}/CanReturn](#operation/Keys_CanReturnKey)**. 

If CanReturn reponse indicates that key can be returned with API then call **[POST api/v2/Keys/{id}/Return](#operation/Keys_ReturnKey)**.

If returning is not possible, see CanReturn response for further information. 

Public API also supports deleting the keys. If key has been programmed or issued to programming it cannot be deleted from locking system anymore. Try instead returning. <br>
Check first if key can be deleted calling **[GET api/v2/Keys/{id}/CanDelete](#operation/Keys_CanDeleteKey)**. <br>
If response 0 Key can be deleted then proceed to call **[DELETE api/v2/Keys/{id}](#operation/Keys_Delete)**. 
Any kind of non-programmed key type can be deleted throught API.



# Public API
## API Documentation
This OpenApi 3.0 documentation is for Public API version 2 for 5 Series locking systems. Other locking systems should use version 1.

For other versions use this endpoint documentation: https://s10.iloq.com/iloqwsapi/help


OpenApi Json document can be used to generate client library in multiple programming languages (C#, java, javascript, etc.). For more information about swagger, visit https://swagger.io/

## Usage

To use the API, you first need to make sure your locking system is API enabled. If it isn't enabled, an error will occur during login. You can view if your locking system is API enabled by logging into 5 Series Manager and going to Edit locking system information window and then selecting Settings tab. A checkbox will appear if API is enabled. For further assistance, please contact iLOQ. Contact information can be found at https://www.iloq.com/en/sales/iloq-sales-support/

Before starting, it is recommended to get familiar with the general idea and principles behind iLOQ's locking system. You can contact iLOQ to book a training course about the locking system and iLOQ Manager software. This training takes from half a day to a day. Here is also some reading about the locking system:

* S10: https://www.iloq.com/manual/en/s10/
* 5 Series: https://www.iloq.com/manual/en/5-series/

The API is a RESTful service. Endpoints can be called with simple HTTP calls and HTTP protocols are mapped to CRUD operations:

* GET will retrieve data
* PUT updates data
* POST inserts new data (sometimes also used to just retrieve data if complex parameter is required)
* DELETE deletes data

# Getting started


**NOTE! Headers** <br>
In all API calls, the Http header called **\"SessionId\"** is mandatory after step 2 Create session.<br>
If you are using API Gateway, the header **\"x-api-key\"** must be included for every request.

Those header values you get from here: 
* SessionID value from Create Session request
* x-api-key value from API Developer Portal on My Dashboard-Page.


## General process
Using iLOQ Public API is a six step process.

![Session handling chart](/iLOQPublicApiDoc/images/session_handling.png)


| Steps                  |                                                |
| ---------------------- |------------------------------------------------|
| 1. Resolve url         | Resolves which server url to use               |
| 2. Create session      | Creates session                                |
| 3. Get locking systems | Returns locking systems user has rights to use |
| 4. Set locking system  | Logging to locking system                      |
| 5. Call endpoints      | Use endpoints to manage locking system         |
| 6. Kill session        | Terminates session after it's no longer needed |

## 1. Resolve url
First step is to get the correct url to use for the rest of the API calls.

Use your iLOQ Manager server url to call **[POST Url/GetUrl](#operation/Url_GetUrl)** endpoint with customer code.
This endpoint returns you rest of url.

Calling this endpoint and resolving the url makes sure your application always uses the correct url to access the API.

Usually your iLOQ Manager server url is: 
* https://s5.iloq.com/iloqws 
* https://s5.iloq.de/iloqws

For example, after calling https://s5.iloq.com/iloqws/api/v2/Url/GetUrl endpoint, you might get https://s5.iloq.com/iloqwspool2/ as response. Use this new url to call rest of the API endpoints, e.g. https://s5.iloq.com/iloqwspool2/api/v2/CreateSession.

**NOTE!** If GetUrl returns a null or empty string, use original url that you used in **[POST Url/GetUrl](#operation/Url_GetUrl)** request to call rest of the endpoints. Do not skip this first part in your integration, even if **[POST Url/GetUrl](#operation/Url_GetUrl)** seems to always to return empty string.


## 2. Create session
After resolving the url, you can log in. Logging in must be done before calling any other API endpoint.
This is done by calling **[POST CreateSession](#operation/Authentication_CreateSession)** endpoint with credentials.

| Credentials   | Description                        |
| ------------- |----------------------------------- |
| UserName      | User name                          |
| Password      | Password                           |
| CustomerCode  | Customer code                      |
| ApiKey        | Leave empty for now                |
| ApiSecret     | Leave empty for now                |


Call returns response token with SessionId and result which tells if the session creation was successful. This token has to be used in all API calls in Http header called \"SessionId\".
## 3. Get locking systems
After retrieving session id successfully, you need to set the locking system user uses for the duration of this session. Persons, keys, locks and other resources are always linked to a locking system. Before they can be accessed, user must be authenticated to a locking system. 


First you need to get all the locking systems user has rights to.
Call **[GET LockGroups](#operation/LockGroups_GetAllLockGroups)** endpoint to get all locking systems that user has rights.
Resultset contains one or more locking systems. If only one locking system is returned, that can be used directly. Otherwise show locking systems to end user and let user to choose locking system.
## 4. Set locking system
To Authenticate to selected locking system call **[POST SetLockgroup](#operation/Authentication_SetLockgroup)** with the chosen locking system.


SetLockgroup returns user's permission rights. You can use this bit mask value to enable/disable certain actions in your software. For example, if your application is used to book times using a calendar and user doesn't have permission to edit calendars (CanEditCalendars (2251799813685248)), you can disable calendar edit controls.

Now user can call the rest of the API endpoints.
## 5. Call endpoints
Call endpoints to manage locking system.
## 6. Kill session
Lastly when you have finished using Public API endpoints, terminate session with **[GET KillSession](#operation/Authentication_KillSession)**.
# Samples
## Common use cases
These samples describe what endpoints and in which order to call them.
These use cases do not provide parameters or responses. 
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_BlacklistingKeys.html\" target=\"_blank\">Blocklisting keys</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_CalendarSecurityAccessGroup.html\" target=\"_blank\">Code access groups to calendar controls</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_SessionAndLogging.html\" target=\"_blank\">Creating session and logging to locking system</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_Calendars.html\" target=\"_blank\">Managing calendars and time controls</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCalendarControlledDoors.html\" target=\"_blank\">Manage calendar controlled doors</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCalendarControlledDoorsSecurityCode.html\" target=\"_blank\">Manage calendar controlled doors with code access groups</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCodeAccesGroups.html\" target=\"_blank\">Manage code access groups</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManangingKeys.html\" target=\"_blank\">Managing keys</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManageKeysSecurityAccessesRemotely.html\" target=\"_blank\">Manage key's security accesses remotely</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManageLocksSecurityAccessesRemotely.html\" target=\"_blank\">Manage lock's security accesses remotely</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingPersons.html\" target=\"_blank\">Manage persons</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_OrderingPhoneKeys.html\" target=\"_blank\">Managing phone keys</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_OrderingRFIDKeys.html\" target=\"_blank\">Managing external RFID tags</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingSecurityAccesses.html\" target=\"_blank\">Manage security accesses</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingTimeLimits.html\" target=\"_blank\">Manage time profiles</a>
* <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_S5KeyTimeProfiles.html\" target=\"_blank\">Manage time restrictions for iLOQ S5 keys</a>

## UWP application
Sample project is an UWP application written In C#.
Project can be downloaded from **<a href=\"iLOQPublicApiDoc/use_cases/PublicApiUseCases.zip\">here</a>**.
It shows you how to login to a locking system and it also covers these common use cases:

* Transferring person data from your system to iLOQ.
* Making calendar reservations for common area, like laundry room or sauna.
* Adding and configuring S5 keys for tenants.
* Managing iLOQ S50 phone keys.

# Change history

## Version 7.5
 * New features 
    * Public API now supports creating, ordering, programming and returning external RFID tags
      * Sample lists of requests can be found **[in samples section](#section/Samples/Common-use-cases)**.
      * More about programming of external RFID tag keys can be found **[here](#section/Introduction/External-RFID-tag-keys)**. 


 * New endpoints
    * **[GET Keys/{id}/LocationReporting](#operation/Keys_GetKeyLocationReportingInAuditTrail)**
      * Query if phone key records the last known valid location of mobile device to audit trail during lock open event.
    * **[PUT Keys/{id}/LocationReporting](#operation/Keys_SetKeyLocationReportingInAuditTrail)**
      * Set if you want phone key to record the last known valid location of mobile device to audit trail during lock open event.

## Version 7.4

 * New endpoints
    * **[POST Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**
      * This endpoint will replace previous version that was HTTP GET method
    * **[GET PersonRoles/{id}/SecurityAccesses](#operation/PersonRoles_GetSecurityAccessesByPersonRoleId)**
      * Gets security accesses by person role

## Version 7.1.8200.35003
 
 * New features
    * **[New webhook event for subcribing lock logs.](#section/Webhook-(Beta)/Events)**
        * This new feature will replace SignalR.     
    * Locks real estate can be updated through **[PUT Locks](#operation/Locks_Update)** -endpoint   
    * Enum values and descriptions for **[Locks](#operation/Locks_GetLockById)** **PhysicalState** property
    * **[GET Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)** has new return value CanAddTimeLimit
    * Two new read only properties for **[Keys](#operation/Keys_GetKey)**
        * **ProgrammingState** of the key. This new field equivalent to 5 series Manager's Programming State -field.  
        * **IsProgrammed** has key ever been programmed.
            
* New endpoints 
    * **[GET Persons/{id}/NortecActivationCode](#operation/Persons_GetNortecCode)**
      * Gets Nortec laundry code 
    * **[GET Webhooks/Subscriptions/{id}/Payloads](#operation/Webhooks_GetPayloadsForSubscription)**
      * Gets payloads which have the given state. Returns most recent, maximum of 1000 payloads.
    * **[GET Webhooks/Subscriptions/PendingPayloads](#operation/Webhooks_GetSubscriptionsWithPendingPayloads)**
      * Gets webhook subscriptions which have sent payloads that aren't sent successfully (state = 3 or 4).
 

## Version 6.9.1.0

 * **Breaking changes**
    * From this version on **S50 phone keys require Person_ID -link**. Inserting and updating phone key without person link will cause validation error and key will not be inserted or updated.

* New endpoints for key's security access and time profile management
    * Key's security access management
        * **[Can security access to be added to key](#operation/Keys_CanAddSecurityAccess)**
        * **[Add security access to key](#operation/Keys_InsertSecurityAccess)**
        * **[Can security access to be deleted from key](#operation/Keys_CanDeleteSecurityAccess)**
        * **[Delete security access from key](#operation/Keys_DeleteSecurityAccess)**

    * Key's time profile management
        * **[Can time profile to added to key](#operation/Keys_CanAddTimeLimitTitle)**
        * **[Add time profile to key](#operation/Keys_InsertTimeLimitTitle)**
        * **[Modify key's time profile](#operation/Keys_UpdateTimeLimit)**
        * **[Get information of key's time profile](#operation/Keys_GetTimeLimit)**
        * **[Delete time profile from key](#operation/Keys_DeleteTimeLimit)**

    * **[PUT Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)** works as before

* New read-only property **TagKeyHex** for Keys
    * RFID Tag presented as HEX. Empty if TagKey is absent.


## Version 6.8.0.16
 * **[Webhook (Beta)](#section/Webhook-(Beta))**
    * Webhooks allows subscribing to events happening in iLOQ Manager and iLOQ Public Api

* New endpoint for **[re-registering phone keys](#operation/KeyPhones_SendPhoneRegistration)** 

## Version 6.5.0.1

 * New endpoints **[KeyTag](#tag/KeyTags)**
    * Ticketing support
 
# General advice and FAQ


In this section you can find few useful tips and FAQ for using iLOQ API.


## API
* Locking system has to be API enabled. See more in **[here](#section/Public-API/Usage)**.
* To make changes to key's security accesses and order them via API, type of the security acceess that is being changed, has to be API access. Changes to Standard access require Manager and Token to order.


## Can-methods 
* iLOQ Public API provides several CanAdd, CanAddKey, CanRemoveKey, CanRemove, CanOrder, CanReturn -methods. These endpoints may provide usefull information why something cannot be done. It also prevents unsuccessfull POST and DELETE requests. 

## GUIDs and ID fields
* General rule is that integrator defines new GUIDs for ID fields for POST requests.
* Some POST endpoints may generate GUID or add 00000000-0000-0000-0000-000000000000 as GUID, but generate your own GUIDs also in these cases.

## KeyTypeMask
* KeyTypeMask describes type of the key.
* Accepts the following combinations: S10 + iLoqKey (S10 key), S50 + PhoneKey (S50 phone key), S50 + iLoqKey (S50 fob key), 5 Series + iLoqKey (S5 key), 5 Series + Other than iLoq physical key (External RFID tag key).

## Logging
* We strongly advice to have sufficient logging on your side of integration. For security reasons iLOQ Public API does not log or store payloads of **successfull requests**. Errors are always logged in iLOQ Public API.

## Rights
* Locking system administrator grants user rights for API user when creating user.
* Successfully logging to locking system with [POST SetLockgroup](#operation/Authentication_SetLockgroup) return RightsMask that contains user's rights as a bit mask. List of rights can be found [SetLockgroup](#operation/Authentication_SetLockgroup).
* Contact your locking system administrator concerning insuffient user rights.

## Terms 

Here is some term differences between iLOQ 5 series Manager and iLOQ Public API

|Manager              |Public API |
| --------------------|-------------------------|
|Access rights        |SecurityAccesses         |
|Blocklist            |Blacklist                |
|Calendar             |CalendarDataTitles       |
|Calendar control     |CalendarData             |
|Code access groups   |SecurityRoles            |
|Service code         |CustomerCode             |
|Time profile         |TimeLimitTitles          |


# Contact
For API support, contact api.support@iloq.com.

In problem situations provide **payloads**, possible **error responses** and **service code** to hasten support.

For non-API-related issues (like contract issues), contact other supports which can be found at https://www.iloq.com/en/sales/iloq-sales-support/

# Webhook (Beta)

Webhooks allow you to build or set up integrations in a loosely coupled manner. Webhooks are created by subscribing to certain events happening in iLOQ. When one of those events is triggered, we will send a `HTTP POST` payload to the URL that has been provided by you.

Once the subscription is created and active, payload will be sent each time the subscribed event occurs.

Up to **3** subscriptions can be created for each event per locking system.

<h3>Subscription</h3>

When creating a subscription, you define which event you're interested in and `http(s)://` endpoint where the payload will be sent. Following information needs to be provided:
1. Endpoint URL that accepts `HTTP POST` requests
2. Starting date and time; when will this subscription start sending payloads
3. Ending date and time; when will this subscription stop sending payloads. Maximum is one year ahead.
4. Event; what occurring event will send the payload
5. Subscription Id; guid generated by you
6. *Custom header (Optional)*; free text that will be sent as part of the payload header
7. *JSON path filter (Optional)*; filter out data you are not interested in

<h4>JSON path filter</h4>

`JSON path filter` -property allows you to filter out events by using [JSON path](https://tools.ietf.org/id/draft-goessner-dispatch-jsonpath-00.html). For example, by giving the following value `$[?($.KeyTypeMask == 9 || $.KeyTypeMask == 4)]`, you receive only payloads that have `KeyTypeMask` with value `4 or 9`, the rest will be ignored. See _Events and Payloads_ for property names that can be used to filter out the webhooks.

<h3>Event</h3>

Each event corresponds to a certain action that can happen within your iLOQ environment. For example, if you subscribe to the `key_added` event, you will receive detailed payload every time an key has been added via iLOQ manager or iLOQ Public api. If you are interested in only certain keys, you can use Json path filter to filter the events.

For a complete list of available webhook events and their payloads, see _Events and Payloads_

<h3>Preparing to receive webhooks</h3>

Provide a public RESTFUL endpoint that accepts the `HTTP POST` requests. If you use `HTTPS`, make sure the certification is correctly setup and matches your domain. Design your endpoint in asynchronous manner. For ex. provide response with a http status code `2xx` instantly and do long-running tasks in the background. Format of the response is irrelevant, but it will be persisted for troubleshooting purposes and the content size is limited to `1MB`

<h3>Error handling & limitations</h3>

If the payload sent by iLOQ does not succesfully complete, iLOQ will try to resend the payloads in a following manner:

|Failed attempts|Delay|
|--|--|
|1|5 minutes|
|2|15 minutes|
|3|1 hour|
|4|6 hours|
|5|12 hours|
|6|24 hours|

This totals 7 requests, after that has been reached, this specific event is marked as obsolete and iLOQ stops sending the payload.

For troubleshooting purposes, each unique webhook (and related response given by your endpoint) is persisted for `30 days` and permanently removed after that threshold is reached

<h3>Errors in response</h3>

Webhook sender will check the status code endpoint gives in the response. If the response contains status code that's something else than 2xx, this specific event is marked as failed and iLOQ will try resending the payload later.

<h4>Timeout</h4>

Webhook sender will timeout after **5** seconds if no response is given. Prepare your receiving endpoint in a asynchronous manner so that you can provide the response as soon as possible. If timeout occurs, this specific event is marked as failed and iLOQ will try resending the payload later.

<h4>SSL verification error</h4>

If HTTPS-address is used and SSL verification fails, this specific event is marked as failed and iLOQ will try resending the payload later.

<h4>Host unreachable</h4>

If host is unreachable, this specific event is marked as failed and iLOQ will try resending the payload later.

<h4> Payload common properties </h4>

Each webhook sent by iLOQ has content-type of `application/json; charset=utf-8` and contains following common properties:

<h4>Headers</h4>

|Key|Type|Description|Example
|--|--|--|--|
|Counter|number|Incremental counter that shows how many unique payloads has been sent to the endpoint provided in the subscription.<br><br>**Important:** Resent requests won't increase the count|2342|
|Event-Name|string|Name of the event|key_added|
|Subscription-Id|string|Subscription Id that was provided when creating the subscription|90B3B527-3667-4CF8-9930-5D744E5EA877|
|Webhook-Signature|string|[Webhook Signature](https://dev.azure.com/SebittiiLOQ/iLOQWebhook/_wiki/wikis/iLOQWebhook-dokumentaatio/41/Webhook-Signature) related to this payload|3133e11d8b3087cf5c2b33c2c14ce4701f5b31a4746f9245681be32449958930|
|Custom-Header|string<br>*optional*|Free text given for the subscription. Is delivered as Base64 encoded string|dGVzdA==

<h4>Payload body</h4>

|Key|Type|Description|Example|
|--|--|--|--|
|Data|object|Event related data provided<br><br>See *Events* for detailed descriptions for each event|{\"Description\": \"string\",\"ExpireDate\": \"2021-04-20T10:42:40.803Z\",\"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"InfoText\": \"string\", \"KeyTypeMask\": 0, \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"ROM_ID\": \"string\", \"Stamp\": \"string\", \"StampSource\": 0, \"State\": 0, \"TagKey\": \"string\", \"TagKeySource\": 0, \"VersionCode\": \"string\"}
|CreationTimeUtc|string|UTC timestamp when the payload was sent|2021-04-29T09:08:31.6653347Z

## Events
Each event has unique Data provided within the payload's `BODY`

### key_added

Key added event occurs, when new key has been added via iLOQ Manager or iLOQ Public api

|Key|Type|Description|
|--|--|--|
|Description|string|Description text|
|ExpireDate|string?|Expiration date. Null if the key doesn't expire|
|FNKey_ID|string(Guid)|Key Id|
|InfoText|string|Additional info text|
|KeyTypeMask|number|Key's types in bitmask|
|Person_ID|string?(Guid)|Person to whom the key is linked to. Null if the key isn't linked to anyone|
|RealEstate_ID|string(Guid)|Id of the real estate where this key belongs to|
|ROM_ID|string|ROM ID|
|Stamp|string|Number consisting of 4 digits written to the physical key|
|StampSource|number|The source of the key labeling (Stamp)|
|State|number|Current state|
|TagKey|string|RFID Tag. Empty string if not given|
|TagKeySource|int|The source of the key's tagkey enumeration|
|VersionCode|string|Version information|

Key Added payload example (prettified)

```
{
  \"Data\": {
    \"Description\": \"string\",
    \"ExpireDate\": \"2021-04-20T10:42:40.803Z\",
    \"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",
    \"InfoText\": \"string\",
    \"KeyTypeMask\": 0,
    \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",
    \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",
    \"ROM_ID\": \"string\",
    \"Stamp\": \"string\",
    \"StampSource\": 0,
    \"State\": 0,
    \"TagKey\": \"string\",
    \"TagKeySource\": 0,
    \"VersionCode\": \"string\"
  },
  \"CreationTimeUtc\": \"2021-04-27T14:54:06.747\"
}
```

Full Request example
```
POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/key-added HTTP/1.1
Host: 10.0.1.6
Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1
Event-Name: key_added
Custom-Header: VGVzdCBoZWFkZXI=
Subscription-Id: 449226d9-bb2f-41f2-be90-32ec2b9b00c4
Counter: 5304
Content-Type: application/json; charset=utf-8
Content-Length: 433

{\"Data\":{\"Description\":\"string\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"string\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-04-29T09:08:31.6653347Z\"}
```

### key_blocklisted

Key blocklisted event occurs, when key has been blocklisted via iLOQ Manager or iLOQ Public api

|Key|Type|Description|
|--|--|--|
|Description|string|Description text|
|ExpireDate|string?|Expiration date. Null if the key doesn't expire|
|FNKey_ID|string(Guid)|Key Id|
|InfoText|string|Additional info text|
|KeyTypeMask|number|Key's types in bitmask|
|Person_ID|string?(Guid)|Person to whom the key is linked to. Null if the key isn't linked to anyone|
|RealEstate_ID|string(Guid)|Id of the real estate where this key belongs to|
|ROM_ID|string|ROM ID|
|Stamp|string|Number consisting of 4 digits written to the physical key|
|StampSource|number|The source of the key labeling (Stamp)|
|State|number|Current state|
|TagKey|string|RFID Tag. Empty string if not given|
|TagKeySource|int|The source of the key's tagkey enumeration|
|VersionCode|string|Version information|

Key Blocklisted payload example (prettified)
```
{
  \"Data\": {
    \"Description\": \"string\",
    \"ExpireDate\": \"2021-04-20T10:42:40.803Z\",
    \"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",
    \"InfoText\": \"string\",
    \"KeyTypeMask\": 0,
    \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",
    \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",
    \"ROM_ID\": \"string\",
    \"Stamp\": \"string\",
    \"StampSource\": 0,
    \"State\": 0,
    \"TagKey\": \"string\",
    \"TagKeySource\": 0,
    \"VersionCode\": \"string\"
  },
  \"CreationTimeUtc\": \"2021-04-27T14:54:06.747Z\"
}
```
Full Request example
```
POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/key-added HTTP/1.1
Host: 10.0.1.6
Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1
Event-Name: key_blocklisted
Custom-Header: VGVzdCBoZWFkZXI=
Subscription-Id: 3fa85f64-5717-4562-b3fc-2c963f66afa6
Counter: 5304
Content-Type: application/json; charset=utf-8
Content-Length: 433

{\"Data\":{\"Description\":\"string\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"string\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-04-29T09:08:31.6653347Z\"}
```

### device_log_arrived
Device log arrived event occurs, when lock, key or network module sends audit trails or other device logs to server

|Key|Type|Description|
|--|--|--|
|DeviceLogTypeMask|int|Lock log types as bit mask values. For example 1028 would be successful S10 key access. 12 would be successful phone access etc.|
|FLock_ID|string(Guid)?|Id of the lock. Null if the event isn't related to lock|
|FNKey_ID|string(Guid)?|Id of the key. Null if the event isn't related to key|
|GoingDateUtc|string?|Date and time of log access. Null if the event isn't related to key or lock access|
|KeyTypeMask|number?|Key's types in bitmask. Null if the event isn't related to key|
|LanguageCode|string?|Language code for person linked to key. Null if the event isn't related to key or this information is not available|
|LockSerialNumber|int?|Serial number for the lock. Null if the event isn't related to lock|
|Person_ID|string?|Id of the person to whom the key is linked to. Null if the key isn't linked to anyone or the event isn't related to key|
|PersonFullName|string)|Full name of the person to whom the key is linked to. Null if the key isn't linked to anyone or the event isn't related to key|
|PhoneEmail|string)|Email linked to the phone key. Null if the event isn't related to phone key|
|PhoneNo|string)|Phone number linked to the phone key. Null if the event isn't related to phone key|
|RealEstate_ID|string?|Id of the real estate where lock belongs to. Null if the event isn't related to lock|

Device Log Arrived payload example (prettified)
```
{
  \"Data\": {
    \"DeviceLogTypeMask\": 12,
    \"FLock_ID\": \"3589CBEB-C801-41C9-BB06-B7A51C1F346B\",
    \"fnKey_ID\": \"FD051B34-5DDC-485A-915A-205016EA74D6\",
    \"GoingDateUtc\": \"2022-05-09T14:54:06.747Z\",
    \"KeyTypeMask\": 4,
    \"Person_ID\": \"36FCDD5C-D306-43EC-845D-DB424568F38B\",
    \"RealEstate_ID\": \"0565B189-9474-4E06-94F6-DAD33F2863F5\",
    \"LanguageCode\": \"FIN\",
    \"LockSerialNumber\": 123456,
    \"PersonFullName\": \"Foo Bar\",
    \"PhoneEmail\": \"foo@domain.com\",
    \"PhoneNo\": \"555-12345678\"
  },
  \"CreationTimeUtc\": \"2022-05-11T14:54:06.747Z\"
}
```
Full Request example
```
POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/device-log-arrived HTTP/1.1
Host: 10.0.1.6
Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1
Event-Name: device_log_arrived
Custom-Header: VGVzdCBoZWFkZXI=
Subscription-Id: 3fa85f64-5717-4562-b3fc-2c963f66afa6
Counter: 1204
Content-Type: application/json; charset=utf-8
Content-Length: 433

{\"Data\":{\"DeviceLogTypeMask\":12,\"FLock_ID\":\"3589CBEB-C801-41C9-BB06-B7A51C1F346B\",\"fnKey_ID\":\"FD051B34-5DDC-485A-915A-205016EA74D6\",\"GoingDateUtc\":\"2022-05-09T14:54:06.747Z\",\"KeyTypeMask\":4,\"Person_ID\":\"36FCDD5C-D306-43EC-845D-DB424568F38B\",\"RealEstate_ID\":\"0565B189-9474-4E06-94F6-DAD33F2863F5\",\"LanguageCode\":\"FIN\",\"LockSerialNumber\":123456,\"PersonFullName\":\"Foo Bar\",\"PhoneEmail\":\"foo@domain.com\",\"PhoneNo\":\"555-12345678\"},\"CreationTimeUtc\":\"2022-05-11T14:54:06.747Z\"}
```

## Webhook signature

Webhook service will create unique signature for each sent webhook. 

By recreating and comparing this hex digest to the one sent within the headers, payload receiver can make sure that the payload has remained intact and is sent from a trusty source.

Signature is within the HEADER `Webhook-Signature`

To recreate this hex digest, you will need following info:
* `SignKey` linked to the subscription
* `BODY` of the payload

`Webhook-Signature` is the HMAC hex digest of the request body, and is generated using the SHA-256 hash function and the `SignKey` as the HMAC key.

<h3>Example</h3>

Body of the payload:

```{\"Data\":{\"Description\":\"kuvaus\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"infoa\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-01-05T12:15:30Z\"}```

SignKey:

`EFE3FD29-0B3E-405F-98EE-0CC5385DF5D5`

With the above data, following `Webhook-Signature` is generated:

`0468a4741fc1445f9b70805456016c88ad5b61544dd8c38502be546f3e05b4e8`

<h4>Code example (C#)</h4>

```
public static string ComputeWebhookSignature(string signKey, string body)
{
    var bytes = Encoding.UTF8.GetBytes(signKey);
    using (var hasher = new HMACSHA256(bytes))
    {
        var data = Encoding.UTF8.GetBytes(body);
        return BitConverter.ToString(hasher.ComputeHash(data)).ToLower().Replace(\"-\", \"\");
    }
}
```

<h3>Additional security</h3>

Each payload body will contain property `CreationTimeUtc`. This timestamp is generated just before sending the request. This will allow the receiver to secure themselves from *Replay*-attacks, for ex. by validating that the `CreationTimeUtc` is below some threshold.





## Installation & Usage

### Requirements

PHP 7.4 and later.
Should also work with PHP 8.0.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/OpenAPIClient-php/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$create_session_param = new \OpenAPI\Client\Model\CreateSessionParam(); // \OpenAPI\Client\Model\CreateSessionParam

try {
    $result = $apiInstance->authenticationCreateSession($create_session_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->authenticationCreateSession: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *http://localhost*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*AuthenticationApi* | [**authenticationCreateSession**](docs/Api/AuthenticationApi.md#authenticationcreatesession) | **POST** /api/v2/CreateSession | /api/v2/CreateSession
*AuthenticationApi* | [**authenticationKillSession**](docs/Api/AuthenticationApi.md#authenticationkillsession) | **GET** /api/v2/KillSession | /api/v2/KillSession
*AuthenticationApi* | [**authenticationSetLockgroup**](docs/Api/AuthenticationApi.md#authenticationsetlockgroup) | **POST** /api/v2/SetLockgroup | /api/v2/SetLockgroup
*AuthenticationApi* | [**authenticationTest**](docs/Api/AuthenticationApi.md#authenticationtest) | **GET** /api/v2/Test | /api/v2/Test
*AuthenticationApi* | [**authenticationVersion**](docs/Api/AuthenticationApi.md#authenticationversion) | **GET** /api/v2/Version | /api/v2/Version
*BlacklistsApi* | [**blacklistsAddKey**](docs/Api/BlacklistsApi.md#blacklistsaddkey) | **POST** /api/v2/Blacklists/AddKey/{fnkeyId} | /api/v2/Blacklists/AddKey/{fnkeyId}
*BlacklistsApi* | [**blacklistsCanAddKey**](docs/Api/BlacklistsApi.md#blacklistscanaddkey) | **GET** /api/v2/Blacklists/CanAddKey/{fnkeyId} | /api/v2/Blacklists/CanAddKey/{fnkeyId}
*BlacklistsApi* | [**blacklistsCanOrderS40Blacklist**](docs/Api/BlacklistsApi.md#blacklistscanorders40blacklist) | **GET** /api/v2/Blacklists/CanOrderS40Blacklist | /api/v2/Blacklists/CanOrderS40Blacklist
*BlacklistsApi* | [**blacklistsCanRemoveKey**](docs/Api/BlacklistsApi.md#blacklistscanremovekey) | **GET** /api/v2/Blacklists/CanRemoveKey/{fnkeyId} | /api/v2/Blacklists/CanRemoveKey/{fnkeyId}
*BlacklistsApi* | [**blacklistsGetAll**](docs/Api/BlacklistsApi.md#blacklistsgetall) | **GET** /api/v2/Blacklists | /api/v2/Blacklists
*BlacklistsApi* | [**blacklistsOrderS40Blacklist**](docs/Api/BlacklistsApi.md#blacklistsorders40blacklist) | **POST** /api/v2/Blacklists/OrderS40Blacklist | /api/v2/Blacklists/OrderS40Blacklist
*BlacklistsApi* | [**blacklistsRemoveKey**](docs/Api/BlacklistsApi.md#blacklistsremovekey) | **DELETE** /api/v2/Blacklists/RemoveKey/{fnkeyId} | /api/v2/Blacklists/RemoveKey/{fnkeyId}
*CalendarDataSecurityRoleLinksApi* | [**calendarDataSecurityRoleLinksDeleteLinks**](docs/Api/CalendarDataSecurityRoleLinksApi.md#calendardatasecurityrolelinksdeletelinks) | **POST** /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks/Delete | /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks/Delete
*CalendarDataSecurityRoleLinksApi* | [**calendarDataSecurityRoleLinksGetLinksByCalendarDataId**](docs/Api/CalendarDataSecurityRoleLinksApi.md#calendardatasecurityrolelinksgetlinksbycalendardataid) | **GET** /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks | /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks
*CalendarDataSecurityRoleLinksApi* | [**calendarDataSecurityRoleLinksGetLinksBySecurityRoleId**](docs/Api/CalendarDataSecurityRoleLinksApi.md#calendardatasecurityrolelinksgetlinksbysecurityroleid) | **GET** /api/v2/SecurityRoles/{id}/CalendarDataSecurityRoleLinks | /api/v2/SecurityRoles/{id}/CalendarDataSecurityRoleLinks
*CalendarDataSecurityRoleLinksApi* | [**calendarDataSecurityRoleLinksInsertLinks**](docs/Api/CalendarDataSecurityRoleLinksApi.md#calendardatasecurityrolelinksinsertlinks) | **POST** /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks | /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks
*CalendarDataSecurityRoleLinksApi* | [**calendarDataSecurityRoleLinksSetLinks**](docs/Api/CalendarDataSecurityRoleLinksApi.md#calendardatasecurityrolelinkssetlinks) | **PUT** /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks | /api/v2/CalendarDatas/{id}/CalendarDataSecurityRoleLinks
*CalendarDataTitlesApi* | [**calendarDataTitlesDelete**](docs/Api/CalendarDataTitlesApi.md#calendardatatitlesdelete) | **DELETE** /api/v2/CalendarDataTitles/{id} | /api/v2/CalendarDataTitles/{id}
*CalendarDataTitlesApi* | [**calendarDataTitlesGetAll**](docs/Api/CalendarDataTitlesApi.md#calendardatatitlesgetall) | **GET** /api/v2/CalendarDataTitles | /api/v2/CalendarDataTitles
*CalendarDataTitlesApi* | [**calendarDataTitlesGetById**](docs/Api/CalendarDataTitlesApi.md#calendardatatitlesgetbyid) | **GET** /api/v2/CalendarDataTitles/{id} | /api/v2/CalendarDataTitles/{id}
*CalendarDataTitlesApi* | [**calendarDataTitlesInsert**](docs/Api/CalendarDataTitlesApi.md#calendardatatitlesinsert) | **POST** /api/v2/CalendarDataTitles | /api/v2/CalendarDataTitles
*CalendarDataTitlesApi* | [**calendarDataTitlesUpdate**](docs/Api/CalendarDataTitlesApi.md#calendardatatitlesupdate) | **PUT** /api/v2/CalendarDataTitles | /api/v2/CalendarDataTitles
*CalendarDatasApi* | [**calendarDatasDelete**](docs/Api/CalendarDatasApi.md#calendardatasdelete) | **DELETE** /api/v2/CalendarDatas/{id} | /api/v2/CalendarDatas/{id}
*CalendarDatasApi* | [**calendarDatasGetByCalendarDataId**](docs/Api/CalendarDatasApi.md#calendardatasgetbycalendardataid) | **GET** /api/v2/CalendarDatas/{id} | /api/v2/CalendarDatas/{id}
*CalendarDatasApi* | [**calendarDatasGetByCalendarId**](docs/Api/CalendarDatasApi.md#calendardatasgetbycalendarid) | **GET** /api/v2/CalendarDataTitles/{id}/CalendarDatas | /api/v2/CalendarDataTitles/{id}/CalendarDatas
*CalendarDatasApi* | [**calendarDatasInsert**](docs/Api/CalendarDatasApi.md#calendardatasinsert) | **POST** /api/v2/CalendarDatas | /api/v2/CalendarDatas
*CalendarDatasApi* | [**calendarDatasUpdate**](docs/Api/CalendarDatasApi.md#calendardatasupdate) | **PUT** /api/v2/CalendarDatas | /api/v2/CalendarDatas
*CalendarNetworkModuleRelayLinksApi* | [**calendarNetworkModuleRelayLinksGetLinksByCalendarId**](docs/Api/CalendarNetworkModuleRelayLinksApi.md#calendarnetworkmodulerelaylinksgetlinksbycalendarid) | **GET** /api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks | /api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks
*CalendarNetworkModuleRelayLinksApi* | [**calendarNetworkModuleRelayLinksGetLinksByNetworkModuleRelayId**](docs/Api/CalendarNetworkModuleRelayLinksApi.md#calendarnetworkmodulerelaylinksgetlinksbynetworkmodulerelayid) | **GET** /api/v2/NetworkModuleDeviceRelays/{id}/CalendarNetworkModuleDeviceRelayLinks | /api/v2/NetworkModuleDeviceRelays/{id}/CalendarNetworkModuleDeviceRelayLinks
*CalendarNetworkModuleRelayLinksApi* | [**calendarNetworkModuleRelayLinksSetLinks**](docs/Api/CalendarNetworkModuleRelayLinksApi.md#calendarnetworkmodulerelaylinkssetlinks) | **PUT** /api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks | /api/v2/CalendarDataTitles/{id}/CalendarNetworkModuleDeviceRelayLinks
*KeyPhonesApi* | [**keyPhonesGetByKeyId**](docs/Api/KeyPhonesApi.md#keyphonesgetbykeyid) | **GET** /api/v2/Keys/{id}/KeyPhone | /api/v2/Keys/{id}/KeyPhone
*KeyPhonesApi* | [**keyPhonesSendPhoneRegistration**](docs/Api/KeyPhonesApi.md#keyphonessendphoneregistration) | **POST** /api/v2/KeyPhones/{id}/ReRegister | /api/v2/KeyPhones/{id}/ReRegister
*KeyPhonesApi* | [**keyPhonesUpdate**](docs/Api/KeyPhonesApi.md#keyphonesupdate) | **PUT** /api/v2/KeyPhones | /api/v2/KeyPhones
*KeyTagsApi* | [**keyTagsDelete**](docs/Api/KeyTagsApi.md#keytagsdelete) | **DELETE** /api/v2/KeyTags/{id} | /api/v2/KeyTags/{id}
*KeyTagsApi* | [**keyTagsGetAll**](docs/Api/KeyTagsApi.md#keytagsgetall) | **GET** /api/v2/KeyTags | /api/v2/KeyTags
*KeyTagsApi* | [**keyTagsGetById**](docs/Api/KeyTagsApi.md#keytagsgetbyid) | **GET** /api/v2/KeyTags/{id} | /api/v2/KeyTags/{id}
*KeyTagsApi* | [**keyTagsGetTagsByFNKey**](docs/Api/KeyTagsApi.md#keytagsgettagsbyfnkey) | **GET** /api/v2/Keys/{id}/KeyTags | /api/v2/Keys/{id}/KeyTags
*KeyTagsApi* | [**keyTagsInsert**](docs/Api/KeyTagsApi.md#keytagsinsert) | **POST** /api/v2/KeyTags | /api/v2/KeyTags
*KeyTagsApi* | [**keyTagsUpdate**](docs/Api/KeyTagsApi.md#keytagsupdate) | **PUT** /api/v2/KeyTags | /api/v2/KeyTags
*KeysApi* | [**keysCanAddSecurityAccess**](docs/Api/KeysApi.md#keyscanaddsecurityaccess) | **GET** /api/v2/Keys/{id}/SecurityAccesses/CanAdd | /api/v2/Keys/{id}/SecurityAccesses/CanAdd
*KeysApi* | [**keysCanAddTimeLimitTitle**](docs/Api/KeysApi.md#keyscanaddtimelimittitle) | **POST** /api/v2/Keys/{id}/TimeLimitTitles/CanAdd | /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
*KeysApi* | [**keysCanAddTimeLimitTitleObsolete**](docs/Api/KeysApi.md#keyscanaddtimelimittitleobsolete) | **GET** /api/v2/Keys/{id}/TimeLimitTitles/CanAdd | /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
*KeysApi* | [**keysCanDeleteKey**](docs/Api/KeysApi.md#keyscandeletekey) | **GET** /api/v2/Keys/{id}/CanDelete | /api/v2/Keys/{id}/CanDelete
*KeysApi* | [**keysCanDeleteSecurityAccess**](docs/Api/KeysApi.md#keyscandeletesecurityaccess) | **GET** /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete | /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete
*KeysApi* | [**keysCanOrderKey**](docs/Api/KeysApi.md#keyscanorderkey) | **GET** /api/v2/Keys/{id}/CanOrder | /api/v2/Keys/{id}/CanOrder
*KeysApi* | [**keysCanReturnKey**](docs/Api/KeysApi.md#keyscanreturnkey) | **GET** /api/v2/Keys/{id}/CanReturn | /api/v2/Keys/{id}/CanReturn
*KeysApi* | [**keysCanUpdateKeyMainZone**](docs/Api/KeysApi.md#keyscanupdatekeymainzone) | **GET** /api/v2/Keys/{id}/CanUpdateMainZone | /api/v2/Keys/{id}/CanUpdateMainZone
*KeysApi* | [**keysDelete**](docs/Api/KeysApi.md#keysdelete) | **DELETE** /api/v2/Keys/{id} | /api/v2/Keys/{id}
*KeysApi* | [**keysDeleteSecurityAccess**](docs/Api/KeysApi.md#keysdeletesecurityaccess) | **DELETE** /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId} | /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}
*KeysApi* | [**keysDeleteTimeLimit**](docs/Api/KeysApi.md#keysdeletetimelimit) | **DELETE** /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} | /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
*KeysApi* | [**keysGetAllKeys**](docs/Api/KeysApi.md#keysgetallkeys) | **GET** /api/v2/Keys | /api/v2/Keys
*KeysApi* | [**keysGetKey**](docs/Api/KeysApi.md#keysgetkey) | **GET** /api/v2/Keys/{id} | /api/v2/Keys/{id}
*KeysApi* | [**keysGetKeyLocationReportingInAuditTrail**](docs/Api/KeysApi.md#keysgetkeylocationreportinginaudittrail) | **GET** /api/v2/Keys/{id}/LocationReporting | /api/v2/Keys/{id}/LocationReporting
*KeysApi* | [**keysGetKeysByPerson**](docs/Api/KeysApi.md#keysgetkeysbyperson) | **GET** /api/v2/Persons/{id}/Keys | /api/v2/Persons/{id}/Keys
*KeysApi* | [**keysGetKeysByRomIds**](docs/Api/KeysApi.md#keysgetkeysbyromids) | **GET** /api/v2/Keys/GetByRomIds | /api/v2/Keys/GetByRomIds
*KeysApi* | [**keysGetSecurityAccesses**](docs/Api/KeysApi.md#keysgetsecurityaccesses) | **GET** /api/v2/Keys/{id}/SecurityAccesses | /api/v2/Keys/{id}/SecurityAccesses
*KeysApi* | [**keysGetTimeLimit**](docs/Api/KeysApi.md#keysgettimelimit) | **GET** /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} | /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
*KeysApi* | [**keysGetTimeLimits**](docs/Api/KeysApi.md#keysgettimelimits) | **GET** /api/v2/Keys/{id}/TimeLimitTitles | /api/v2/Keys/{id}/TimeLimitTitles
*KeysApi* | [**keysGetZones**](docs/Api/KeysApi.md#keysgetzones) | **GET** /api/v2/Keys/{id}/Zones | /api/v2/Keys/{id}/Zones
*KeysApi* | [**keysInsert**](docs/Api/KeysApi.md#keysinsert) | **POST** /api/v2/Keys | /api/v2/Keys
*KeysApi* | [**keysInsertSecurityAccess**](docs/Api/KeysApi.md#keysinsertsecurityaccess) | **POST** /api/v2/Keys/{id}/SecurityAccesses | /api/v2/Keys/{id}/SecurityAccesses
*KeysApi* | [**keysInsertTimeLimitTitle**](docs/Api/KeysApi.md#keysinserttimelimittitle) | **POST** /api/v2/Keys/{id}/TimeLimitTitles | /api/v2/Keys/{id}/TimeLimitTitles
*KeysApi* | [**keysOrderKey**](docs/Api/KeysApi.md#keysorderkey) | **POST** /api/v2/Keys/{id}/Order | /api/v2/Keys/{id}/Order
*KeysApi* | [**keysReturnKey**](docs/Api/KeysApi.md#keysreturnkey) | **POST** /api/v2/Keys/{id}/Return | /api/v2/Keys/{id}/Return
*KeysApi* | [**keysSetKeyLocationReportingInAuditTrail**](docs/Api/KeysApi.md#keyssetkeylocationreportinginaudittrail) | **PUT** /api/v2/Keys/{id}/LocationReporting | /api/v2/Keys/{id}/LocationReporting
*KeysApi* | [**keysUpdate**](docs/Api/KeysApi.md#keysupdate) | **PUT** /api/v2/Keys | /api/v2/Keys
*KeysApi* | [**keysUpdateMainZone**](docs/Api/KeysApi.md#keysupdatemainzone) | **PUT** /api/v2/Keys/{id}/UpdateMainZone | /api/v2/Keys/{id}/UpdateMainZone
*KeysApi* | [**keysUpdateSecurityAccesses**](docs/Api/KeysApi.md#keysupdatesecurityaccesses) | **PUT** /api/v2/Keys/{id}/SecurityAccesses | /api/v2/Keys/{id}/SecurityAccesses
*KeysApi* | [**keysUpdateTimeLimit**](docs/Api/KeysApi.md#keysupdatetimelimit) | **PUT** /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId} | /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
*LockGroupsApi* | [**lockGroupsGenerateAccessToken**](docs/Api/LockGroupsApi.md#lockgroupsgenerateaccesstoken) | **POST** /api/v2/LockGroups/GenerateAccessToken | /api/v2/LockGroups/GenerateAccessToken
*LockGroupsApi* | [**lockGroupsGetAllLockGroups**](docs/Api/LockGroupsApi.md#lockgroupsgetalllockgroups) | **GET** /api/v2/LockGroups | /api/v2/LockGroups
*LockGroupsApi* | [**lockGroupsGetConnectionSettings**](docs/Api/LockGroupsApi.md#lockgroupsgetconnectionsettings) | **GET** /api/v2/LockGroups/ConnectionSettings | /api/v2/LockGroups/ConnectionSettings
*LockLogsApi* | [**lockLogsGetLockLogDataByGoingDates**](docs/Api/LockLogsApi.md#locklogsgetlocklogdatabygoingdates) | **POST** /api/v2/LockLogs/GetLockLogDataByGoingDates | /api/v2/LockLogs/GetLockLogDataByGoingDates
*LockLogsApi* | [**lockLogsGetLockLogDataByTimestamp**](docs/Api/LockLogsApi.md#locklogsgetlocklogdatabytimestamp) | **POST** /api/v2/LockLogs/GetLockLogDataByTimestamp | /api/v2/LockLogs/GetLockLogDataByTimestamp
*LockLogsApi* | [**lockLogsGetLockLogs**](docs/Api/LockLogsApi.md#locklogsgetlocklogs) | **POST** /api/v2/LockLogs | /api/v2/LockLogs
*LocksApi* | [**locksCanOrderLock**](docs/Api/LocksApi.md#lockscanorderlock) | **GET** /api/v2/Locks/{id}/CanOrder | /api/v2/Locks/{id}/CanOrder
*LocksApi* | [**locksDelete**](docs/Api/LocksApi.md#locksdelete) | **DELETE** /api/v2/Locks/{id} | /api/v2/Locks/{id}
*LocksApi* | [**locksGetAllLocks**](docs/Api/LocksApi.md#locksgetalllocks) | **GET** /api/v2/Locks | /api/v2/Locks
*LocksApi* | [**locksGetLockById**](docs/Api/LocksApi.md#locksgetlockbyid) | **GET** /api/v2/Locks/{id} | /api/v2/Locks/{id}
*LocksApi* | [**locksGetLockOptions**](docs/Api/LocksApi.md#locksgetlockoptions) | **GET** /api/v2/Locks/{id}/Options | /api/v2/Locks/{id}/Options
*LocksApi* | [**locksGetSecurityAccesses**](docs/Api/LocksApi.md#locksgetsecurityaccesses) | **GET** /api/v2/Locks/{id}/SecurityAccesses | /api/v2/Locks/{id}/SecurityAccesses
*LocksApi* | [**locksGetTimeLimits**](docs/Api/LocksApi.md#locksgettimelimits) | **GET** /api/v2/Locks/{id}/TimeLimitTitles | /api/v2/Locks/{id}/TimeLimitTitles
*LocksApi* | [**locksInsert**](docs/Api/LocksApi.md#locksinsert) | **POST** /api/v2/Locks | /api/v2/Locks
*LocksApi* | [**locksOrderLock**](docs/Api/LocksApi.md#locksorderlock) | **POST** /api/v2/Locks/{id}/Order | /api/v2/Locks/{id}/Order
*LocksApi* | [**locksUpdate**](docs/Api/LocksApi.md#locksupdate) | **PUT** /api/v2/Locks | /api/v2/Locks
*LocksApi* | [**locksUpdateSecurityAccesses**](docs/Api/LocksApi.md#locksupdatesecurityaccesses) | **PUT** /api/v2/Locks/{id}/SecurityAccesses | /api/v2/Locks/{id}/SecurityAccesses
*NetworkModuleDeviceRelaysApi* | [**networkModuleDeviceRelaysGetById**](docs/Api/NetworkModuleDeviceRelaysApi.md#networkmoduledevicerelaysgetbyid) | **GET** /api/v2/NetworkModuleDeviceRelays/{id} | /api/v2/NetworkModuleDeviceRelays/{id}
*NetworkModuleDeviceRelaysApi* | [**networkModuleDeviceRelaysGetByNetworkModuleDeviceId**](docs/Api/NetworkModuleDeviceRelaysApi.md#networkmoduledevicerelaysgetbynetworkmoduledeviceid) | **GET** /api/v2/NetworkModuleDevices/{id}/NetworkModuleDeviceRelays | /api/v2/NetworkModuleDevices/{id}/NetworkModuleDeviceRelays
*NetworkModuleDeviceRelaysApi* | [**networkModuleDeviceRelaysGetByNetworkModuleId**](docs/Api/NetworkModuleDeviceRelaysApi.md#networkmoduledevicerelaysgetbynetworkmoduleid) | **GET** /api/v2/NetworkModules/{id}/NetworkModuleDeviceRelays | /api/v2/NetworkModules/{id}/NetworkModuleDeviceRelays
*NetworkModuleDevicesApi* | [**networkModuleDevicesGetAll**](docs/Api/NetworkModuleDevicesApi.md#networkmoduledevicesgetall) | **GET** /api/v2/NetworkModuleDevices | /api/v2/NetworkModuleDevices
*NetworkModuleDevicesApi* | [**networkModuleDevicesGetById**](docs/Api/NetworkModuleDevicesApi.md#networkmoduledevicesgetbyid) | **GET** /api/v2/NetworkModuleDevices/{id} | /api/v2/NetworkModuleDevices/{id}
*NetworkModuleDevicesApi* | [**networkModuleDevicesGetByNetworkModuleId**](docs/Api/NetworkModuleDevicesApi.md#networkmoduledevicesgetbynetworkmoduleid) | **GET** /api/v2/NetworkModules/{id}/NetworkModuleDevices | /api/v2/NetworkModules/{id}/NetworkModuleDevices
*NetworkModulesApi* | [**networkModulesGetAll**](docs/Api/NetworkModulesApi.md#networkmodulesgetall) | **GET** /api/v2/NetworkModules | /api/v2/NetworkModules
*NetworkModulesApi* | [**networkModulesGetById**](docs/Api/NetworkModulesApi.md#networkmodulesgetbyid) | **GET** /api/v2/NetworkModules/{id} | /api/v2/NetworkModules/{id}
*PersonRolesApi* | [**personRolesGetAllPersonRoles**](docs/Api/PersonRolesApi.md#personrolesgetallpersonroles) | **GET** /api/v2/PersonRoles | /api/v2/PersonRoles
*PersonRolesApi* | [**personRolesGetPersonRolesByPersonResult**](docs/Api/PersonRolesApi.md#personrolesgetpersonrolesbypersonresult) | **GET** /api/v2/Persons/{id}/PersonRoles | /api/v2/Persons/{id}/PersonRoles
*PersonRolesApi* | [**personRolesGetRoleById**](docs/Api/PersonRolesApi.md#personrolesgetrolebyid) | **GET** /api/v2/PersonRoles/{id} | /api/v2/PersonRoles/{id}
*PersonRolesApi* | [**personRolesGetSecurityAccessesByPersonRoleId**](docs/Api/PersonRolesApi.md#personrolesgetsecurityaccessesbypersonroleid) | **GET** /api/v2/PersonRoles/{id}/SecurityAccesses | /api/v2/PersonRoles/{id}/SecurityAccesses
*PersonsApi* | [**personsCanDelete**](docs/Api/PersonsApi.md#personscandelete) | **GET** /api/v2/Persons/{id}/CanDelete | /api/v2/Persons/{id}/CanDelete
*PersonsApi* | [**personsDelete**](docs/Api/PersonsApi.md#personsdelete) | **DELETE** /api/v2/Persons/{id} | /api/v2/Persons/{id}
*PersonsApi* | [**personsGetAllPersons**](docs/Api/PersonsApi.md#personsgetallpersons) | **GET** /api/v2/Persons | /api/v2/Persons
*PersonsApi* | [**personsGetNortecCode**](docs/Api/PersonsApi.md#personsgetnorteccode) | **GET** /api/v2/Persons/{id}/NortecActivationCode | /api/v2/Persons/{id}/NortecActivationCode
*PersonsApi* | [**personsGetPerson**](docs/Api/PersonsApi.md#personsgetperson) | **GET** /api/v2/Persons/{id} | /api/v2/Persons/{id}
*PersonsApi* | [**personsGetPersonsByExternalPersonIds**](docs/Api/PersonsApi.md#personsgetpersonsbyexternalpersonids) | **GET** /api/v2/Persons/GetByExternalPersonIds | /api/v2/Persons/GetByExternalPersonIds
*PersonsApi* | [**personsInsert**](docs/Api/PersonsApi.md#personsinsert) | **POST** /api/v2/Persons | /api/v2/Persons
*PersonsApi* | [**personsUpdate**](docs/Api/PersonsApi.md#personsupdate) | **PUT** /api/v2/Persons | /api/v2/Persons
*RealEstatesApi* | [**realEstatesGetValues**](docs/Api/RealEstatesApi.md#realestatesgetvalues) | **GET** /api/v2/RealEstates | /api/v2/RealEstates
*SecurityAccessApi* | [**securityAccessDelete**](docs/Api/SecurityAccessApi.md#securityaccessdelete) | **DELETE** /api/v2/SecurityAccesses/{id} | /api/v2/SecurityAccesses/{id}
*SecurityAccessApi* | [**securityAccessGetAllSecurityAccesses**](docs/Api/SecurityAccessApi.md#securityaccessgetallsecurityaccesses) | **GET** /api/v2/SecurityAccesses | /api/v2/SecurityAccesses
*SecurityAccessApi* | [**securityAccessInsert**](docs/Api/SecurityAccessApi.md#securityaccessinsert) | **POST** /api/v2/SecurityAccesses | /api/v2/SecurityAccesses
*SecurityAccessApi* | [**securityAccessUpdate**](docs/Api/SecurityAccessApi.md#securityaccessupdate) | **PUT** /api/v2/SecurityAccesses | /api/v2/SecurityAccesses
*SecurityRolesApi* | [**securityRolesCanDelete**](docs/Api/SecurityRolesApi.md#securityrolescandelete) | **GET** /api/v2/SecurityRoles/{id}/CanDelete | /api/v2/SecurityRoles/{id}/CanDelete
*SecurityRolesApi* | [**securityRolesDelete**](docs/Api/SecurityRolesApi.md#securityrolesdelete) | **DELETE** /api/v2/SecurityRoles/{id} | /api/v2/SecurityRoles/{id}
*SecurityRolesApi* | [**securityRolesGetAll**](docs/Api/SecurityRolesApi.md#securityrolesgetall) | **GET** /api/v2/SecurityRoles | /api/v2/SecurityRoles
*SecurityRolesApi* | [**securityRolesGetById**](docs/Api/SecurityRolesApi.md#securityrolesgetbyid) | **GET** /api/v2/SecurityRoles/{id} | /api/v2/SecurityRoles/{id}
*SecurityRolesApi* | [**securityRolesInsert**](docs/Api/SecurityRolesApi.md#securityrolesinsert) | **POST** /api/v2/SecurityRoles | /api/v2/SecurityRoles
*SecurityRolesApi* | [**securityRolesUpdate**](docs/Api/SecurityRolesApi.md#securityrolesupdate) | **PUT** /api/v2/SecurityRoles | /api/v2/SecurityRoles
*TimeLimitDataApi* | [**timeLimitDataGetByTimeLimitTitleId**](docs/Api/TimeLimitDataApi.md#timelimitdatagetbytimelimittitleid) | **GET** /api/v2/TimeLimitTitles/{id}/TimeLimitData | /api/v2/TimeLimitTitles/{id}/TimeLimitData
*TimeLimitTitlesApi* | [**timeLimitTitlesCanDelete**](docs/Api/TimeLimitTitlesApi.md#timelimittitlescandelete) | **GET** /api/v2/TimeLimitTitles/{id}/CanDelete | /api/v2/TimeLimitTitles/{id}/CanDelete
*TimeLimitTitlesApi* | [**timeLimitTitlesDelete**](docs/Api/TimeLimitTitlesApi.md#timelimittitlesdelete) | **DELETE** /api/v2/TimeLimitTitles/{id} | /api/v2/TimeLimitTitles/{id}
*TimeLimitTitlesApi* | [**timeLimitTitlesGetAll**](docs/Api/TimeLimitTitlesApi.md#timelimittitlesgetall) | **GET** /api/v2/TimeLimitTitles | /api/v2/TimeLimitTitles
*TimeLimitTitlesApi* | [**timeLimitTitlesGetById**](docs/Api/TimeLimitTitlesApi.md#timelimittitlesgetbyid) | **GET** /api/v2/TimeLimitTitles/{id} | /api/v2/TimeLimitTitles/{id}
*TimeLimitTitlesApi* | [**timeLimitTitlesInsert**](docs/Api/TimeLimitTitlesApi.md#timelimittitlesinsert) | **POST** /api/v2/TimeLimitTitles | /api/v2/TimeLimitTitles
*TimeLimitTitlesApi* | [**timeLimitTitlesUpdate**](docs/Api/TimeLimitTitlesApi.md#timelimittitlesupdate) | **PUT** /api/v2/TimeLimitTitles | /api/v2/TimeLimitTitles
*UrlApi* | [**urlGetUrl**](docs/Api/UrlApi.md#urlgeturl) | **POST** /api/v2/Url/GetUrl | /api/v2/Url/GetUrl
*WebhooksApi* | [**webhooksAddSubscription**](docs/Api/WebhooksApi.md#webhooksaddsubscription) | **POST** /api/v2/Webhooks/Subscriptions | /api/v2/Webhooks/Subscriptions
*WebhooksApi* | [**webhooksDeleteSubscription**](docs/Api/WebhooksApi.md#webhooksdeletesubscription) | **DELETE** /api/v2/Webhooks/Subscriptions/{id} | /api/v2/Webhooks/Subscriptions/{id}
*WebhooksApi* | [**webhooksGetEvents**](docs/Api/WebhooksApi.md#webhooksgetevents) | **GET** /api/v2/Webhooks/Events | /api/v2/Webhooks/Events
*WebhooksApi* | [**webhooksGetPayloadsForSubscription**](docs/Api/WebhooksApi.md#webhooksgetpayloadsforsubscription) | **GET** /api/v2/Webhooks/Subscriptions/{id}/Payloads | /api/v2/Webhooks/Subscriptions/{id}/Payloads
*WebhooksApi* | [**webhooksGetPendingEventsForSubscription**](docs/Api/WebhooksApi.md#webhooksgetpendingeventsforsubscription) | **GET** /api/v2/Webhooks/Subscriptions/{id}/PendingEvents | /api/v2/Webhooks/Subscriptions/{id}/PendingEvents
*WebhooksApi* | [**webhooksGetSubscription**](docs/Api/WebhooksApi.md#webhooksgetsubscription) | **GET** /api/v2/Webhooks/Subscriptions/{id} | /api/v2/Webhooks/Subscriptions/{id}
*WebhooksApi* | [**webhooksGetSubscriptions**](docs/Api/WebhooksApi.md#webhooksgetsubscriptions) | **GET** /api/v2/Webhooks/Subscriptions | /api/v2/Webhooks/Subscriptions
*WebhooksApi* | [**webhooksGetSubscriptionsWithPendingEvents**](docs/Api/WebhooksApi.md#webhooksgetsubscriptionswithpendingevents) | **GET** /api/v2/Webhooks/Subscriptions/PendingEvents | /api/v2/Webhooks/Subscriptions/PendingEvents
*WebhooksApi* | [**webhooksGetSubscriptionsWithPendingPayloads**](docs/Api/WebhooksApi.md#webhooksgetsubscriptionswithpendingpayloads) | **GET** /api/v2/Webhooks/Subscriptions/PendingPayloads | /api/v2/Webhooks/Subscriptions/PendingPayloads
*WebhooksApi* | [**webhooksUpdateSubscription**](docs/Api/WebhooksApi.md#webhooksupdatesubscription) | **PUT** /api/v2/Webhooks/Subscriptions | /api/v2/Webhooks/Subscriptions
*ZonesApi* | [**zonesGetAllZones**](docs/Api/ZonesApi.md#zonesgetallzones) | **GET** /api/v2/Zones | /api/v2/Zones

## Models

- [AccessTokenTypeMask](docs/Model/AccessTokenTypeMask.md)
- [AddSecurityAccessParam](docs/Model/AddSecurityAccessParam.md)
- [AddSubscriptionParam](docs/Model/AddSubscriptionParam.md)
- [AllowedSocketRequestTypeMask](docs/Model/AllowedSocketRequestTypeMask.md)
- [BlackList](docs/Model/BlackList.md)
- [BlackListChangeType](docs/Model/BlackListChangeType.md)
- [BlackListKeyTypeMask](docs/Model/BlackListKeyTypeMask.md)
- [BlacklistPacket](docs/Model/BlacklistPacket.md)
- [BlacklistPacketState](docs/Model/BlacklistPacketState.md)
- [BlocklistChangeType](docs/Model/BlocklistChangeType.md)
- [CalendarDataEntry](docs/Model/CalendarDataEntry.md)
- [CalendarDataEntryType](docs/Model/CalendarDataEntryType.md)
- [CalendarDataGetByCalendarDataIdResult](docs/Model/CalendarDataGetByCalendarDataIdResult.md)
- [CalendarDataGetByCalendarDataIdResultEntry](docs/Model/CalendarDataGetByCalendarDataIdResultEntry.md)
- [CalendarDataGetByCalendarDataIdResultRecurringEntry](docs/Model/CalendarDataGetByCalendarDataIdResultRecurringEntry.md)
- [CalendarDataGetByCalendarDataIdResultRecurringEntryException](docs/Model/CalendarDataGetByCalendarDataIdResultRecurringEntryException.md)
- [CalendarDataGetByCalendarIdResult](docs/Model/CalendarDataGetByCalendarIdResult.md)
- [CalendarDataInsertParam](docs/Model/CalendarDataInsertParam.md)
- [CalendarDataRecurringEntry](docs/Model/CalendarDataRecurringEntry.md)
- [CalendarDataRecurringEntryException](docs/Model/CalendarDataRecurringEntryException.md)
- [CalendarDataSecurityRoleLink](docs/Model/CalendarDataSecurityRoleLink.md)
- [CalendarDataSecurityRoleLinksDeleteLinksParam](docs/Model/CalendarDataSecurityRoleLinksDeleteLinksParam.md)
- [CalendarDataSecurityRoleLinksInsertLinksParam](docs/Model/CalendarDataSecurityRoleLinksInsertLinksParam.md)
- [CalendarDataSecurityRoleLinksSetLinksParam](docs/Model/CalendarDataSecurityRoleLinksSetLinksParam.md)
- [CalendarDataTitle](docs/Model/CalendarDataTitle.md)
- [CalendarDataTitleInsert](docs/Model/CalendarDataTitleInsert.md)
- [CalendarDataTitleInsertOptionMask](docs/Model/CalendarDataTitleInsertOptionMask.md)
- [CalendarDataTitleInsertReservationTargetType](docs/Model/CalendarDataTitleInsertReservationTargetType.md)
- [CalendarDataTitleInsertType](docs/Model/CalendarDataTitleInsertType.md)
- [CalendarDataTitleOptionMask](docs/Model/CalendarDataTitleOptionMask.md)
- [CalendarDataTitleReservationTargetType](docs/Model/CalendarDataTitleReservationTargetType.md)
- [CalendarDataTitleType](docs/Model/CalendarDataTitleType.md)
- [CalendarDataTitleUpdate](docs/Model/CalendarDataTitleUpdate.md)
- [CalendarDataType](docs/Model/CalendarDataType.md)
- [CalendarDataUpdateParam](docs/Model/CalendarDataUpdateParam.md)
- [CalendarNetworkModuleDeviceRelayLinksSetLinksParam](docs/Model/CalendarNetworkModuleDeviceRelayLinksSetLinksParam.md)
- [CalendarNetworkModuleRelayLink](docs/Model/CalendarNetworkModuleRelayLink.md)
- [CanAddSecurityAccessLink](docs/Model/CanAddSecurityAccessLink.md)
- [CanAddTimeLimit](docs/Model/CanAddTimeLimit.md)
- [CanDeleteKeyResult](docs/Model/CanDeleteKeyResult.md)
- [CanDeleteSecurityAccessLink](docs/Model/CanDeleteSecurityAccessLink.md)
- [CanDeleteSecurityRole](docs/Model/CanDeleteSecurityRole.md)
- [CanDeleteTimeLimitTitleResult](docs/Model/CanDeleteTimeLimitTitleResult.md)
- [CanOrderKeyResultType](docs/Model/CanOrderKeyResultType.md)
- [CanOrderLockResultType](docs/Model/CanOrderLockResultType.md)
- [CanOrderS40BlacklistResult](docs/Model/CanOrderS40BlacklistResult.md)
- [CanReturnKeyResultType](docs/Model/CanReturnKeyResultType.md)
- [CanUpdateKeyMainZoneResult](docs/Model/CanUpdateKeyMainZoneResult.md)
- [CreateSessionParam](docs/Model/CreateSessionParam.md)
- [CreateSessionResult](docs/Model/CreateSessionResult.md)
- [CreateSessionResultResult](docs/Model/CreateSessionResultResult.md)
- [CreateSessionResultType](docs/Model/CreateSessionResultType.md)
- [DeviceLogFNKey](docs/Model/DeviceLogFNKey.md)
- [DeviceLogFNKeyKeyTypeMask](docs/Model/DeviceLogFNKeyKeyTypeMask.md)
- [DeviceLogFNKeyOptionMask](docs/Model/DeviceLogFNKeyOptionMask.md)
- [DeviceLogFlock](docs/Model/DeviceLogFlock.md)
- [DeviceLogFlockLockType](docs/Model/DeviceLogFlockLockType.md)
- [DeviceLogLocationData](docs/Model/DeviceLogLocationData.md)
- [DeviceLogTypeMask](docs/Model/DeviceLogTypeMask.md)
- [EnuCalendarDataState](docs/Model/EnuCalendarDataState.md)
- [EnuLockType](docs/Model/EnuLockType.md)
- [EnuSecurityAccessMode](docs/Model/EnuSecurityAccessMode.md)
- [EventState](docs/Model/EventState.md)
- [FNKeyDeviceLogOptionMask](docs/Model/FNKeyDeviceLogOptionMask.md)
- [FNKeyPhoneOptionMask](docs/Model/FNKeyPhoneOptionMask.md)
- [FNKeyPhoneRequestTypeMask](docs/Model/FNKeyPhoneRequestTypeMask.md)
- [FNKeyTag](docs/Model/FNKeyTag.md)
- [FprogKeyStateMask](docs/Model/FprogKeyStateMask.md)
- [GenerateAccessTokenParam](docs/Model/GenerateAccessTokenParam.md)
- [GenerateAccessTokenParamTypeMask](docs/Model/GenerateAccessTokenParamTypeMask.md)
- [GenerateAccessTokenResult](docs/Model/GenerateAccessTokenResult.md)
- [GetConnectionSettingsResult](docs/Model/GetConnectionSettingsResult.md)
- [GetKeySecurityAccessesResult](docs/Model/GetKeySecurityAccessesResult.md)
- [GetKeysByPersonResult](docs/Model/GetKeysByPersonResult.md)
- [GetKeysByPersonResult1](docs/Model/GetKeysByPersonResult1.md)
- [GetLockLogDataParam](docs/Model/GetLockLogDataParam.md)
- [GetLockLogDataResult](docs/Model/GetLockLogDataResult.md)
- [GetLockLogsParam](docs/Model/GetLockLogsParam.md)
- [GetLockLogsParamTypeMask](docs/Model/GetLockLogsParamTypeMask.md)
- [GetLockSecurityAccessesResult](docs/Model/GetLockSecurityAccessesResult.md)
- [GetLockTimeLimitsResult](docs/Model/GetLockTimeLimitsResult.md)
- [GetS40BlacklistResult](docs/Model/GetS40BlacklistResult.md)
- [GetS40BlacklistResultBlacklistPacket](docs/Model/GetS40BlacklistResultBlacklistPacket.md)
- [GetSecurityAccessesView](docs/Model/GetSecurityAccessesView.md)
- [GetSubscriptionsWithPendingPayloadsResult](docs/Model/GetSubscriptionsWithPendingPayloadsResult.md)
- [GetTimeLimitsResult](docs/Model/GetTimeLimitsResult.md)
- [GetTimeLimitsResultKeyScheduler](docs/Model/GetTimeLimitsResultKeyScheduler.md)
- [GetTimeLimitsView](docs/Model/GetTimeLimitsView.md)
- [GetZonesResult](docs/Model/GetZonesResult.md)
- [InsertKeyParam](docs/Model/InsertKeyParam.md)
- [InsertKeyParam1](docs/Model/InsertKeyParam1.md)
- [InsertKeyParam1Key](docs/Model/InsertKeyParam1Key.md)
- [InsertKeyParamKey](docs/Model/InsertKeyParamKey.md)
- [InsertKeyTimeLimitSlotParam](docs/Model/InsertKeyTimeLimitSlotParam.md)
- [InsertKeyTimeLimitSlotParamTimeLimitSlot](docs/Model/InsertKeyTimeLimitSlotParamTimeLimitSlot.md)
- [InsertLockParam](docs/Model/InsertLockParam.md)
- [InsertLockParam1](docs/Model/InsertLockParam1.md)
- [InsertLockParam1Lock](docs/Model/InsertLockParam1Lock.md)
- [InsertLockParam1LockRelay](docs/Model/InsertLockParam1LockRelay.md)
- [InsertLockParam1TimeLimit](docs/Model/InsertLockParam1TimeLimit.md)
- [InsertLockParamLockOptions](docs/Model/InsertLockParamLockOptions.md)
- [InsertPersonParam](docs/Model/InsertPersonParam.md)
- [InsertPersonParamPerson](docs/Model/InsertPersonParamPerson.md)
- [InsertResult](docs/Model/InsertResult.md)
- [InsertSecurityAccessParam](docs/Model/InsertSecurityAccessParam.md)
- [InsertSecurityAccessParamSecurityAccess](docs/Model/InsertSecurityAccessParamSecurityAccess.md)
- [InsertSecurityAccessResult](docs/Model/InsertSecurityAccessResult.md)
- [InsertSecurityAccessResultSecurityAccess](docs/Model/InsertSecurityAccessResultSecurityAccess.md)
- [InsertTimeLimitTitlesParam](docs/Model/InsertTimeLimitTitlesParam.md)
- [InsertTimeLimitTitlesParamTimeLimitTitle](docs/Model/InsertTimeLimitTitlesParamTimeLimitTitle.md)
- [Key](docs/Model/Key.md)
- [Key1](docs/Model/Key1.md)
- [KeyHolderResponseType](docs/Model/KeyHolderResponseType.md)
- [KeyInsert](docs/Model/KeyInsert.md)
- [KeyInsert1](docs/Model/KeyInsert1.md)
- [KeyInsertKeyTypeMask](docs/Model/KeyInsertKeyTypeMask.md)
- [KeyKeyTypeMask](docs/Model/KeyKeyTypeMask.md)
- [KeyPhone](docs/Model/KeyPhone.md)
- [KeyPhoneOptionMask](docs/Model/KeyPhoneOptionMask.md)
- [KeyPhoneRequestTypeMask](docs/Model/KeyPhoneRequestTypeMask.md)
- [KeyProgrammingState](docs/Model/KeyProgrammingState.md)
- [KeyScheduler](docs/Model/KeyScheduler.md)
- [KeySchedulerRenewGapType](docs/Model/KeySchedulerRenewGapType.md)
- [KeyTimeLimit](docs/Model/KeyTimeLimit.md)
- [KeyTimeLimitData](docs/Model/KeyTimeLimitData.md)
- [KeyTimeLimitSlot](docs/Model/KeyTimeLimitSlot.md)
- [KeyTypeMask](docs/Model/KeyTypeMask.md)
- [LLockOptionMaskParam](docs/Model/LLockOptionMaskParam.md)
- [LNKeyTimeLimitData](docs/Model/LNKeyTimeLimitData.md)
- [LNKeyTimeLimitSlot](docs/Model/LNKeyTimeLimitSlot.md)
- [LNKeyTimeLimitSlotSlotNo](docs/Model/LNKeyTimeLimitSlotSlotNo.md)
- [LNKeyTimelimitSlotNo](docs/Model/LNKeyTimelimitSlotNo.md)
- [LocationInfoMask](docs/Model/LocationInfoMask.md)
- [Lock](docs/Model/Lock.md)
- [Lock2](docs/Model/Lock2.md)
- [Lock2LockType](docs/Model/Lock2LockType.md)
- [Lock2PhysicalState](docs/Model/Lock2PhysicalState.md)
- [LockGroup](docs/Model/LockGroup.md)
- [LockInsert](docs/Model/LockInsert.md)
- [LockLockType](docs/Model/LockLockType.md)
- [LockLogData](docs/Model/LockLogData.md)
- [LockLogDataAccessTypeMask](docs/Model/LockLogDataAccessTypeMask.md)
- [LockPhysicalState](docs/Model/LockPhysicalState.md)
- [LockRelay](docs/Model/LockRelay.md)
- [LockRelayRelayMode](docs/Model/LockRelayRelayMode.md)
- [LockRelayRelayQuasarMode](docs/Model/LockRelayRelayQuasarMode.md)
- [LockSecurityAccessInsert](docs/Model/LockSecurityAccessInsert.md)
- [LockSocketRequestTypeMask](docs/Model/LockSocketRequestTypeMask.md)
- [LockStateConfirmation](docs/Model/LockStateConfirmation.md)
- [LockStateConfirmationKeyHolderResponse](docs/Model/LockStateConfirmationKeyHolderResponse.md)
- [LockTimeLimit](docs/Model/LockTimeLimit.md)
- [LockUpdate](docs/Model/LockUpdate.md)
- [LockUpdateState](docs/Model/LockUpdateState.md)
- [NetworkModule](docs/Model/NetworkModule.md)
- [NetworkModuleAllowedSocketRequest](docs/Model/NetworkModuleAllowedSocketRequest.md)
- [NetworkModuleCalendarDataState](docs/Model/NetworkModuleCalendarDataState.md)
- [NetworkModuleDevice](docs/Model/NetworkModuleDevice.md)
- [NetworkModuleDeviceRelay](docs/Model/NetworkModuleDeviceRelay.md)
- [NetworkModuleDeviceStateMask](docs/Model/NetworkModuleDeviceStateMask.md)
- [NetworkModuleDeviceType](docs/Model/NetworkModuleDeviceType.md)
- [NetworkModuleRequestType](docs/Model/NetworkModuleRequestType.md)
- [NetworkModuleState](docs/Model/NetworkModuleState.md)
- [NetworkModuleStateMask](docs/Model/NetworkModuleStateMask.md)
- [NetworkModuleType](docs/Model/NetworkModuleType.md)
- [Payload](docs/Model/Payload.md)
- [PayloadState](docs/Model/PayloadState.md)
- [Person](docs/Model/Person.md)
- [PersonInsert](docs/Model/PersonInsert.md)
- [PersonInsertState](docs/Model/PersonInsertState.md)
- [PersonRole](docs/Model/PersonRole.md)
- [PersonState](docs/Model/PersonState.md)
- [PersonUpdate](docs/Model/PersonUpdate.md)
- [PniFLockState](docs/Model/PniFLockState.md)
- [PniLogicalState](docs/Model/PniLogicalState.md)
- [PniPersonCanDeleteErrorType](docs/Model/PniPersonCanDeleteErrorType.md)
- [PniPersonState](docs/Model/PniPersonState.md)
- [PniProgrammingKeyState](docs/Model/PniProgrammingKeyState.md)
- [PniProgrammingKeyType](docs/Model/PniProgrammingKeyType.md)
- [PniSecurityAccessDefaultAccess](docs/Model/PniSecurityAccessDefaultAccess.md)
- [PniSecurityAccessExt](docs/Model/PniSecurityAccessExt.md)
- [PniSecurityAccessStatus](docs/Model/PniSecurityAccessStatus.md)
- [PniSecurityAccessType](docs/Model/PniSecurityAccessType.md)
- [PublicApiDeviceLogData](docs/Model/PublicApiDeviceLogData.md)
- [PublicApiDeviceLogDataFLock](docs/Model/PublicApiDeviceLogDataFLock.md)
- [PublicApiDeviceLogDataFNKey](docs/Model/PublicApiDeviceLogDataFNKey.md)
- [PublicApiDeviceLogDataLocationData](docs/Model/PublicApiDeviceLogDataLocationData.md)
- [PublicApiDeviceLogDataLocationInfoMask](docs/Model/PublicApiDeviceLogDataLocationInfoMask.md)
- [PublicApiDeviceLogDataLockStateConfirmation](docs/Model/PublicApiDeviceLogDataLockStateConfirmation.md)
- [PublicApiDeviceLogDataTypeMask](docs/Model/PublicApiDeviceLogDataTypeMask.md)
- [PublicApiGetKeyLocationReportingInAuditTrailQueryResult](docs/Model/PublicApiGetKeyLocationReportingInAuditTrailQueryResult.md)
- [PublicApiGetLockLogsResult](docs/Model/PublicApiGetLockLogsResult.md)
- [PublicApiGetUrlParam](docs/Model/PublicApiGetUrlParam.md)
- [PublicApiSetKeyLocationReportingInAuditTrailParam](docs/Model/PublicApiSetKeyLocationReportingInAuditTrailParam.md)
- [QuasarModeMask](docs/Model/QuasarModeMask.md)
- [RealEstate](docs/Model/RealEstate.md)
- [RelayMode](docs/Model/RelayMode.md)
- [RenewGapType](docs/Model/RenewGapType.md)
- [SecurityAccess](docs/Model/SecurityAccess.md)
- [SecurityAccess2](docs/Model/SecurityAccess2.md)
- [SecurityAccess2Status](docs/Model/SecurityAccess2Status.md)
- [SecurityAccess2Type](docs/Model/SecurityAccess2Type.md)
- [SecurityAccessAccessMode](docs/Model/SecurityAccessAccessMode.md)
- [SecurityAccessDefaultAccess](docs/Model/SecurityAccessDefaultAccess.md)
- [SecurityAccessExt](docs/Model/SecurityAccessExt.md)
- [SecurityAccessInsert](docs/Model/SecurityAccessInsert.md)
- [SecurityAccessRelay](docs/Model/SecurityAccessRelay.md)
- [SecurityAccessStatus](docs/Model/SecurityAccessStatus.md)
- [SecurityAccessType](docs/Model/SecurityAccessType.md)
- [SecurityAccessUpdate](docs/Model/SecurityAccessUpdate.md)
- [SecurityRole](docs/Model/SecurityRole.md)
- [SecurityRoleTypeMask](docs/Model/SecurityRoleTypeMask.md)
- [SetLockgroupParam](docs/Model/SetLockgroupParam.md)
- [SetLockgroupResult](docs/Model/SetLockgroupResult.md)
- [Subscription](docs/Model/Subscription.md)
- [SubscriptionState](docs/Model/SubscriptionState.md)
- [TimeLimitData](docs/Model/TimeLimitData.md)
- [TimeLimitTitle](docs/Model/TimeLimitTitle.md)
- [TimeLimitTitleOptionMask](docs/Model/TimeLimitTitleOptionMask.md)
- [TimeLimitTitleOptionMaskEnum](docs/Model/TimeLimitTitleOptionMaskEnum.md)
- [UpdateKeyMainZoneParam](docs/Model/UpdateKeyMainZoneParam.md)
- [UpdateKeyParam](docs/Model/UpdateKeyParam.md)
- [UpdateKeyParam1](docs/Model/UpdateKeyParam1.md)
- [UpdateKeyParam1Key](docs/Model/UpdateKeyParam1Key.md)
- [UpdateKeyParamKey](docs/Model/UpdateKeyParamKey.md)
- [UpdateKeyPhoneParam](docs/Model/UpdateKeyPhoneParam.md)
- [UpdateKeyPhoneParamOptionMask](docs/Model/UpdateKeyPhoneParamOptionMask.md)
- [UpdateKeySecurityAccessesParam](docs/Model/UpdateKeySecurityAccessesParam.md)
- [UpdateKeySecurityAccessesParam1](docs/Model/UpdateKeySecurityAccessesParam1.md)
- [UpdateKeyTimeLimitSlotParam](docs/Model/UpdateKeyTimeLimitSlotParam.md)
- [UpdateLockParam](docs/Model/UpdateLockParam.md)
- [UpdateLockParamLock](docs/Model/UpdateLockParamLock.md)
- [UpdateLockSecurityAccessesParam](docs/Model/UpdateLockSecurityAccessesParam.md)
- [UpdateLockSecurityAccessesParam1](docs/Model/UpdateLockSecurityAccessesParam1.md)
- [UpdateLockSecurityAccessesParam1LockRelay](docs/Model/UpdateLockSecurityAccessesParam1LockRelay.md)
- [UpdateLockSecurityAccessesParam1TimeLimit](docs/Model/UpdateLockSecurityAccessesParam1TimeLimit.md)
- [UpdateLockSecurityAccessesParamLockOptions](docs/Model/UpdateLockSecurityAccessesParamLockOptions.md)
- [UpdatePersonParam](docs/Model/UpdatePersonParam.md)
- [UpdatePersonParamPerson](docs/Model/UpdatePersonParamPerson.md)
- [UpdateSecurityAccessParam](docs/Model/UpdateSecurityAccessParam.md)
- [UpdateSecurityAccessParamSecurityAccess](docs/Model/UpdateSecurityAccessParamSecurityAccess.md)
- [UpdateTimeLimitTitlesParam](docs/Model/UpdateTimeLimitTitlesParam.md)
- [UpdateTimeLimitTitlesParamTimeLimitTitle](docs/Model/UpdateTimeLimitTitlesParamTimeLimitTitle.md)
- [WebhookEvent](docs/Model/WebhookEvent.md)
- [Zone](docs/Model/Zone.md)

## Authorization
Endpoints do not require authorization.

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `v2`
    - Generator version: `7.10.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
